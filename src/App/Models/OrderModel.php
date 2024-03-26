<?php

namespace App\Models;

use App\Models\Cart\CartDataInitializer;
use App\Models\Classes\Order;
use App\DAO\OrderDAO;

/**
 * Represents an order in the application.
 */
class OrderModel
{
    private string $user_id;

    private string $user_name;

    private string $address_id;
    private array $products;
    private float $total_price;
    private string $delivery_date;

    private string $status = 'pending';

    /**
     * Constructs a new OrderModel object.
     *
     * @param string $user_id The ID of the user placing the order.
     * @param string $address_id The ID of the delivery address for the order.
     * @param CartDataInitializer $products The cart data initializer containing the products in the order.
     * @param string $delivery_date The delivery date for the order.
     * @param string|null $status The status of the order (default: 'pending').
     */
    public function __construct(string $user_id, string $user_name, string $address_id, CartDataInitializer $products, string $delivery_date, ?string $status = 'pending')
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->address_id = $address_id;
        $this->status = $status;
        $this->products = $products->generateProductsDataObject();
        $this->total_price = $products->getTotalPrice();
        $this->delivery_date = $delivery_date;
    }

    /**
     * Saves the order data to the database.
     *
     * @return bool True if the order data was successfully saved, false otherwise.
     */
    public function saveOrderData(): bool
    {
        $orderDAO = new OrderDAO();

        $result = $orderDAO->saveOrderData($this->user_id, $this->user_name, $this->address_id, $this->products, $this->total_price, $this->status, $this->delivery_date);

        return $result;
    }

    /**
     * Retrieves an order by its ID.
     *
     * @param string $userId The ID of the user.
     * @param string $orderId The ID of the order.
     * @return Order|null The order object if found, null otherwise.
     */
    static public function getOrderById(string $userId, string $orderId): ?Order
    {
        $orderDAO = new OrderDAO();

        $order = $orderDAO->getOrderById($userId,  $orderId);

        return $order;
    }

    /**
     * Retrieves all orders for a user.
     *
     * @param string $userId The ID of the user.
     * @return Order[]|null An array of order objects if found, null otherwise.
     */
    static public function getUserOrders(string $userId): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserId($userId);

        return $orders;
    }

    /**
     * Retrieves all orders for a user with a specific status.
     *
     * @param string $userId The ID of the user.
     * @param string $status The status of the orders.
     * @return Order[]|null An array of order objects if found, null otherwise.
     */
    static public function getUserOrdersByStatus(string $userId, string $status): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserIdAndStatus($userId, $status);

        return $orders;
    }

    /**
     * Cancels an order.
     *
     * @param string $userId The ID of the user.
     * @param string $orderId The ID of the order.
     * @return bool True if the order was successfully canceled, false otherwise.
     */
    static public function cancelOrder(string $userId, string $orderId): bool
    {
        $orderDAO = new OrderDAO();

        $result = $orderDAO->cancelOrder($userId, $orderId);

        return $result;
    }
}
