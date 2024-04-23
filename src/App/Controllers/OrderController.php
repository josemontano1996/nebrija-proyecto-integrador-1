<?php

declare(strict_types=1);

namespace App\Controllers;

require_once __DIR__ .  '/../../lib/data-validation.php';

use App\AuthSession;
use App\Models\AddressModel;
use App\Models\Cart\CartCookie;
use App\Models\Cart\CartDataInitializer;
use App\Models\OrderModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;

/**
 * Class OrderController
 * 
 * This class handles the logic for managing orders.
 */
class OrderController
{
    /**
     * Cancels a pending order.
     *
     * @return void
     */
    public function cancelPendingOrder()
    {
        // Get the user ID from the session
        $userId = AuthSession::getUserId();
        // Get the order ID
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;

        if (!$userId) {
            // If the user is not logged in, redirect to the login page
            ResponseStatus::sendResponseStatus(401, 'You must be logged in to cancel an order.', '/login');
        }

        if (!$orderId) {
            // If the order ID is not set, redirect to the orders page
            ResponseStatus::sendResponseStatus(400, 'Order not found.', '/user/orders');
        }

        try {
            // Get the order data
            $order = OrderModel::getUserOrderById($userId, $orderId);

            if (!$order) {
                // If the order is not found, redirect to the orders page
                ResponseStatus::sendResponseStatus(400, 'Order not found.', '/user/orders');
            }

            if ($order->getStatus() !== 'pending') {
                // If the order is not pending, redirect to the orders page
                ResponseStatus::sendResponseStatus(400, 'Order is not pending, cannot be cancelled.', '/user/orders');
            }

            // Cancel the order (only if the status is pending)
            $success = OrderModel::cancelOrder($userId, $orderId);

            if (!$success) {
                // If the order could not be cancelled, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Order could not be cancelled.', '/user/orders');
            }

            // Redirect to the order page
            $order_url = '/user/orders?orderid=' . $orderId;
            ResponseStatus::sendResponseStatus(200, 'Order cancelled successfully.', $order_url);
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/user/orders');
        }
    }

    /**
     * Retrieves an order from an user and renders the view.
     *
     * @return string|null The rendered order view.
     */
    public function getUserOrder(): ?string
    {
        // Get the user ID from the session
        $userId = AuthSession::getUserId();
        // Get the order ID
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;

        if (!$userId) {
            // If the user is not logged in, redirect to the login page
            ResponseStatus::sendResponseStatus(401, 'You must be logged in to view an order.', '/login');
        }

        if (!$orderId) {
            // If the order ID is not set, redirect to the orders page
            ResponseStatus::sendResponseStatus(400, 'Order not found.', '/user/orders');
        }

        try {
            // Get the order data
            $order = OrderModel::getUserOrderById($userId, $orderId);

            if (!$order) {
                // If the order is not found, redirect to the orders page
                ResponseStatus::sendResponseStatus(400, 'Order not found.', '/user/orders');
            }

            // Render the view with the order data
            return (new View('user/orders/order', [$order]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/user/orders');
        }
    }

    /**
     * Retrieves the orders information and renders the orders view.
     *
     * @return string|null The rendered view of all orders.
     */
    public function getUserOrders(): ?string
    {
        // Get the user ID from the session
        $userId = AuthSession::getUserId();

        if (!$userId) {
            // If the user is not logged in, redirect to the login page
            ResponseStatus::sendResponseStatus(401, 'You must be logged in to view orders.', '/login');
        }
        try {
            //Initialize the orders array
            $orders = [];

            //If there is no status query, get all orders
            if (!isset($_GET['status'])) {
                // Get all user orders
                $orders = OrderModel::getUserOrders($userId);
                if (!$orders) {
                    // If no orders are found, return a 404 error
                    ResponseStatus::sendResponseStatus(400, 'No orders found.', '/menu');
                }
            } else {
                // Get user orders by status
                $status = $_GET['status'];
                // Get the orders by status
                $orders = OrderModel::getUserOrdersByStatus($userId, $status);
                if (!$orders) {
                    // If no orders are found, return a 404 error
                    ResponseStatus::sendResponseStatus(400, 'No orders found.', '/user/orders');
                }
            }
            // Render the view with the orders
            return (new View('user/orders/allOrders', [$orders]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred.', '/menu');
        }
    }

    /**
     * Handles the AJAX request to place an order.
     *
     * @return void
     */
    public function postOrderAjax(): void
    {
        // Get the user ID from the session
        $userId = AuthSession::getUserId();

        if (!$userId) {
            // If the user is not logged in, return a 401 error
            ResponseStatus::sendResponseStatus(401, 'You must be logged in to place an order.', '/login', true);
        }

        // Get the form data
        $user_name = trim($_POST['user_name']);
        $street = trim($_POST['street']);
        $postal = trim($_POST['postal']);
        $city = trim($_POST['city']);
        $delivery_date = $_POST['delivery_date'];

        // Get the cart data from the cookie
        $order_data = CartCookie::getCartFromCookie();


        //Validate inputs
        if ($delivery_date < date('Y-m-d H:i:s')) {
            ResponseStatus::sendResponseStatus(400, 'Invalid date.', null, true);
        }

        if (!$order_data) {
            // If there is no order data, return a 400 error
            ResponseStatus::sendResponseStatus(400, 'No order data.', null, true);
        }

        // Check if the delivery data is invalid
        $isInvalidData = isInvalidDeliveryData($user_name, $street, $postal, $city, $delivery_date);

        if ($isInvalidData) {
            // If the delivery data is invalid, return a 400 error
            ResponseStatus::sendResponseStatus(400, $isInvalidData, null, true);
        }

        try {
            // Save the address data
            $addressModel = new AddressModel($street, $city, $postal,);
            $addressId = $addressModel->saveAddressData();

            if (!$addressId) {
                // If the address could not be saved, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'An error ocurred. Try again later.', null, true);
            }

            // Save the order data
            $orderModel = new OrderModel($userId, $user_name, $addressId, new CartDataInitializer(), $delivery_date);
            $success = $orderModel->saveOrderData();

            if (!$success) {
                // If the order could not be saved, return a 500 error and delete the stored address
                $addressModel->deleteAddressData($addressId);
                ResponseStatus::sendResponseStatus(500, 'An error ocurred. Try again later.', null, true);
            }

            // Clear the cart cookie
            CartCookie::destroyCartCookie();
            // Redirect to the orders page
            ResponseStatus::sendResponseStatus(200, null, '/user/orders', true);
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'An error ocurred. Try again later.', null, true);
        }
    }
}
