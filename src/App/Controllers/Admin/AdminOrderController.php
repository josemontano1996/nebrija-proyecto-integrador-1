<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\View;

class AdminOrderController
{

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
}
