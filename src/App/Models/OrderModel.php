<?php

namespace App\Models;

use App\Models\Cart\CartDataInitializer;
use App\Models\Classes\Order;
use App\DAO\OrderDAO;


class OrderModel
{
    private string $user_id;
    private string $address_id;
    private array $products;
    private float $total_price;
    private string $delivery_date;

    private string $status = 'pending';
    private string|null $createdAt;
    public function __construct(string $user_id, string $address_id, CartDataInitializer $products, string $delivery_date, ?string $status = 'pending', ?string $createdAt = null)
    {
        $this->user_id = $user_id;
        $this->address_id = $address_id;
        $this->status = $status;
        $this->products = $products->generateProductsDataObject();
        $this->total_price = $products->getTotalPrice();
        $this->delivery_date = $delivery_date;
        $this->createdAt = $createdAt;
    }

    public function saveOrderData(): bool
    {

        $orderDAO = new OrderDAO();

        $result = $orderDAO->saveOrderData($this->user_id, $this->address_id, $this->products, $this->total_price, $this->status, $this->delivery_date);

        return $result;
    }

    static public function getUserOrders(string $userId): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserId($userId);
         
        return $orders;
    }

    static public function getUserOrdersByStatus(string $userId, string $status): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserIdAndStatus($userId, $status);

        return $orders;
    }
}
