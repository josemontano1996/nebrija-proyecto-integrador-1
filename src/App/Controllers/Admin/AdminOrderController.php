<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\ResponseStatus;
use App\ServerErrorLog;
use App\View;

class AdminOrderController
{
    public function getOrder(): ?string
    {
        // Get the order id from the GET request
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;

        if (!$orderId) {
            // If no order id is found, return a 404 error
            ResponseStatus::sendResponseStatus(404, 'Order not found', '/admin/orders');
        }

        try {
            // Get the order by id
            $order = OrderModel::getOrderById($orderId);

            if (!$order) {
                // If no order is found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'Order not found', '/admin/orders');
            }

            // Render the view with the order
            return (new View('admin/orders/adminOrder', [$order]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the order. Please try again later.', '/admin/orders');
        }
    }

    public function getOrders(): ?string
    {

        // Get the status and page from the GET request
        $status = isset($_GET['status']) ? trim($_GET['status']) : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        //Initialize the orders array
        $orders = [];
        try {
            // Get all orders by status
            if ($status) {
                $orders = OrderModel::getAllOrdersByStatus($status, $page, 5);

                if (!$orders) {
                    // If no orders are found, return a 404 error
                    ResponseStatus::sendResponseStatus(404, 'No more orders found, or no orders with that status.', '/admin/orders');
                }
            } else {

                $orders = OrderModel::getAllOrders($page, 5);

                if (!$orders) {
                    // If no orders are found, return a 404 error
                    ResponseStatus::sendResponseStatus(404, 'No more orders found.', '/admin/orders');
                }
            }

            // Render the view with the orders
            return (new View('admin/orders/adminOrders', [$orders, $page]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the orders. Please try again later.', '/admin/orders');
        }
    }

    public function changeOrderStatus(): void
    {
        // Get the order id and status from the POST request
        $orderId = isset($_POST['orderid']) ? $_POST['orderid'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;


        if (!$orderId || !$status) {
            // If no order id or status is found, return an error
            ResponseStatus::sendResponseStatus(400, 'Invalid data.', '/admin/orders');
        }

        try {
            // Change the order status
            $success = OrderModel::changeOrderStatus($orderId, $status);

            if (!$success) {
                // If the order status is not changed, return an error
                ResponseStatus::sendResponseStatus(500, 'Error while changing the order status.', '/admin/orders');
            }

            $order_url = '/admin/order?orderid=' . $orderId;
            // Redirect to the order page
            ResponseStatus::sendResponseStatus(302, 'Order status changed successfully.', $order_url);
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while changing the order status.', '/admin/orders');
        }
    }
}
