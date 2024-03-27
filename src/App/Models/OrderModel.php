<?php

namespace App\Models;

use App\Models\Cart\CartDataInitializer;
use App\Models\Classes\AddressData;
use App\Models\Classes\Order;
use App\DAO\OrderDAO;
use App\Models\Cart\CartProductData;

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

    static public function getOrderById(string $orderId): ?Order
    {
        $orderDAO = new OrderDAO();
        
        $order = $orderDAO->getOrderById( $orderId);
        
        return $order;
    }
    /**
     * Retrieves an order by its ID.
     *
     * @param string $userId The ID of the user.
     * @param string $orderId The ID of the order.
     * @return Order|null The order object if found, null otherwise.
     */
    static public function getUserOrderById(string $userId, string $orderId): ?Order
    {
        $orderDAO = new OrderDAO();

        $order = $orderDAO->getUserOrderById($userId,  $orderId);

        return $order;
    }

    /**
     * Retrieves all orders for a user.
     *
     * @param string $userId The ID of the user.
     * @return Order[]|null An array of order objects if found, null otherwise.
     */
    static public function getUserOrders(string $userId, ?int $page = null, ?int $limit = 5): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserId($userId);

        return $orders;
    }

    static public function getAllOrdersByStatus(string $status, ?int $page = null, ?int $limit = 5): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getAllOrdersByStatus($status, $page, $limit);

        return $orders;
    }

    /**
     * Retrieves all orders for a user with a specific status.
     *
     * @param string $userId The ID of the user.
     * @param string $status The status of the orders.
     * @return Order[]|null An array of order objects if found, null otherwise.
     */
    static public function getUserOrdersByStatus(string $userId, string $status, ?int $page = null, ?int $limit = 5): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getOrdersByUserIdAndStatus($userId, $status, $page, $limit);

        return $orders;
    }

    static public function getAllOrders(?int $page = null, ?int $limit = 5): ?array
    {
        $orderDAO = new OrderDAO();

        $orders = $orderDAO->getAllOrders($page, $limit);

        return $orders;
    }

    static public function changeOrderStatus(string $orderId, string $status): bool
    {
        $orderDAO = new OrderDAO();

        $result = $orderDAO->changeOrderStatus($orderId, $status);

        return $result;
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

    /**
     * Generate order data based on the given order data array.
     *
     * @param array $orderData The order data array fetched from the DB.
     * @return Order[] The generated order data array.
     */
    static public function generateMultipleOrderDataFromDb(array $orderData): array
    {
        $products = [];

        foreach ($orderData as $key => $order) {
            $decodedProducts = json_decode($order['products'], true);

            foreach ($decodedProducts as $product) {
                $products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
            }

            $orderData[$key] = new Order($order['user_id'], $order['user_name'], new AddressData($order['street'], $order['city'], $order['postal'], $order['address_id']), $products, (float) $order['total_price'], $order['delivery_date'], $order['status'], $order['created_at'], $order['id']);
        }

        return $orderData;
    }
    static public function generateOneOrderDataFromDb(array $orderData): Order
    {
        $products = [];

        $decodedProducts = json_decode($orderData['products'], true);

        foreach ($decodedProducts as $product) {
            $products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
        }

        $order = new Order($orderData['user_id'], $orderData['user_name'], new AddressData($orderData['street'], $orderData['city'], $orderData['postal'], $orderData['address_id']), $products, (float) $orderData['total_price'], $orderData['delivery_date'], $orderData['status'], $orderData['created_at'], $orderData['id']);


        return $order;
    }
}
