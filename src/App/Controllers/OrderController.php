<?php

declare(strict_types=1);

namespace App\Controllers;

require_once __DIR__ .  '/../../lib/data-validation.php';

use App\Models\AddressModel;
use App\Models\Cart\CartCookie;
use App\Models\Cart\CartDataInitializer;
use App\Models\OrderModel;
use App\View;

class OrderController
{

    public function cancelPendingOrder(){
        $userId = $_SESSION['user']['id'];
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;

        if (!$userId) {
            $_SESSION['error'] = 'Session not found. Log in again.';
            $_SESSION['user'] = null;
            header('Location: /login');
            exit();
        }

        if (!$orderId) {
            $_SESSION['error'] = 'Order not found.';
            header('Location: /user/orders');
            exit();
        }

        try {
            $order = OrderModel::getOrderById($userId, $orderId);

            if (!$order) {
                $_SESSION['error'] = 'Order not found.';
                header('Location: /user/orders');
                exit();
            }

            if($order->getStatus() !== 'pending'){
                $_SESSION['error'] = 'Order cannot be cancelled.';
                header('Location: /user/orders');
                exit();
            }

            $success = OrderModel::cancelOrder($userId, $orderId);

            if(!$success){
                $_SESSION['error'] = 'Order could not be cancelled.';
                header('Location: /user/orders');
                exit();
            }

            $_SESSION['success'] = 'Order cancelled successfully.';
            header('Location: /user/orders?orderid=' . $orderId);
            exit();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /user/orders');
            exit();
        }
    }

    public function getOrder()
    {
        $userId = $_SESSION['user']['id'];
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;

        if (!$userId) {
            $_SESSION['error'] = 'Session not found. Log in again.';
            $_SESSION['user'] = null;
            header('Location: /login');
            exit();
        }

        if (!$orderId) {
            $_SESSION['error'] = 'Order not found.';
            header('Location: /user/orders');
            exit();
        }

        try {
            $order = OrderModel::getOrderById($userId, $orderId);

            if (!$order) {
                $_SESSION['error'] = 'Order not found.';
                header('Location: /user/orders');
                exit();
            }

            return (new View('user/orders/order', [$order]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /user/orders');
            exit();
        }
    }

    public function getOrders()
    {
        $userId = $_SESSION['user']['id'];

        if (!$userId) {
            $_SESSION['error'] = 'Session not found. Log in again.';
            $_SESSION['user'] = null;
            header('Location: /login');
            exit();
        }
        try {
            $orders = [];

            if (!isset($_GET['status'])) {
                $orders = OrderModel::getUserOrders($userId);
            } else {
                $status = $_GET['status'];
                $orders = OrderModel::getUserOrdersByStatus($userId, $status);
            }

            if (!$orders) {
                $_SESSION['error'] = 'No orders found.';
                header('Location: /user/orders');
                exit();
            }

            return (new View('user/orders/allOrders', [$orders]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /menu');
            exit();
        }
    }
    public function postOrder(): void
    {
        $userId = $_SESSION['user']['id'];

        if (!$userId) {
            http_response_code(401);
            echo json_encode('You must be logged in to place an order.');
            exit();
        }

        $street = trim($_POST['street']);
        $postal = trim($_POST['postal']);
        $city = trim($_POST['city']);
        $delivery_date = $_POST['delivery_date'];

        $order_data = json_decode($_COOKIE['cart']);


        if ($delivery_date < date('Y-m-d H:i:s')) {
            http_response_code(400);
            echo json_encode('Invalid date.');
            exit();
        }

        if (!$order_data) {
            http_response_code(400);
            echo json_encode('No order data.');
            exit();
        }

        $isInvalidData = isInvalidDeliveryData($street, $postal, $city, $delivery_date);

        if ($isInvalidData) {
            http_response_code(400);
            echo json_encode($isInvalidData);
            exit();
        }

        try {

            $addressModel = new AddressModel($street, $city, $postal,);
            $addressId = $addressModel->saveAddressData();
            //TODO:add order model with address data and rest of data, add the dao and so on
            if (!$addressId) {
                http_response_code(500);
                echo json_encode('An error ocurred. Try again later.');
                exit();
            }

            $orderModel = new OrderModel($userId, $addressId, new CartDataInitializer(), $delivery_date);

            $success = $orderModel->saveOrderData();


            if (!$success) {
                $addressModel->deleteAddressData($addressId);

                http_response_code(500);
                echo json_encode('An error ocurred. Try again later.');
                exit();
            }

            CartCookie::destroyCartCookie();

            echo json_encode('/user/orders');
            exit();
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode('Something went wrong. Try again later.');
            exit();
        }
    }
}
