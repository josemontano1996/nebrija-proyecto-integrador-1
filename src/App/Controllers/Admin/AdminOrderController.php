<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\View;

class AdminOrderController
{
    public function getOrder(): ?string
    {
        $orderId = isset($_GET['orderid']) ? $_GET['orderid'] : null;;
        if (!$orderId) {
            $_SESSION['error'] = 'Order not found.';
            header('Location: /user/orders');
            exit();
        }

        try {
            $order = OrderModel::getOrderById($orderId);

            if (!$order) {
                $_SESSION['error'] = 'Order not found.';
                header('Location: /user/orders');
                exit();
            }

            return (new View('admin/orders/adminOrder', [$order]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            header('Location: /user/orders');
            exit();
        }
    }

    public function getOrders(): ?string
    {

        $status = isset($_GET['status']) ? trim($_GET['status']) : null;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $orders = [];
        try {

            if ($status) {
                $orders = OrderModel::getAllOrdersByStatus($status, $page, 5);

                if (!$orders) {
                    $_SESSION['error'] = 'No more orders found, or no orders with that status.';
                    http_response_code(404);
                }
            } else {

                $orders = OrderModel::getAllOrders($page, 5);

                if (!$orders) {
                    $_SESSION['error'] = 'No more orders found.';
                    http_response_code(404);
                }
            }

            return (new View('admin/orders/adminOrders', [$orders, $page]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error while loading the orders. Please try again later.';
            http_response_code(500);
            header('Location: /admin/orders');
            exit();
        }
    }

    public function changeOrderStatus(): void
    {
        $orderId = isset($_POST['orderid']) ? $_POST['orderid'] : null;
        $status = isset($_POST['status']) ? $_POST['status'] : null;

        if (!$orderId || !$status) {
            $_SESSION['error'] = 'Invalid data.';
            header('Location: /admin/orders');
            exit();
        }

        try {
            $success = OrderModel::changeOrderStatus($orderId, $status);

            if (!$success) {
                $_SESSION['error'] = 'Error while changing the order status.';
                header('Location: /admin/orders');
                exit();
            }

            $_SESSION['success'] = 'Order status changed successfully.';
            header('Location: /admin/order?orderid=' . $orderId);
        } catch (\Exception $e) {
            $_SESSION['error'] = 'An error ocurred.';
            header('Location: /admin/orders');
            exit();
        }
    }
}
