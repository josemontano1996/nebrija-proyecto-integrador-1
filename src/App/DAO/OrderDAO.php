<?php

namespace App\DAO;

use App\DB;
use App\Models\Cart\CartProductData;
use App\Models\Classes\Order;
use App\Models\Classes\AddressData;
use mysqli;
use Ramsey\Uuid\Uuid;

class OrderDAO
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = DB::getInstance()->getDb();
    }

    public function saveOrderData(string $user_id, string $address_id, array $products, float $total_price, string $status, string $delivery_date): bool
    {
        $db = $this->db;
        $order_id = Uuid::uuid4();
        $jsonProducts = json_encode($products);

        $user_id = $db->real_escape_string($user_id);
        $address_id = $db->real_escape_string($address_id);
        $total_price = $db->real_escape_string($total_price);
        $status = $db->real_escape_string($status);
        $delivery_date = $db->real_escape_string($delivery_date);

        $sql = "INSERT INTO orders (id, user_id, address_id, products, total_price, status, delivery_date, createdAt) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('ssssiss', $order_id, $user_id, $address_id, $jsonProducts, $total_price, $status, $delivery_date);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }

    public function getOrderById(string $userId, string $orderId): ?Order
    {

        $db = $this->db;

        $userId = $db->real_escape_string($userId);
        $orderId = $db->real_escape_string($orderId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? AND orders.id = ?";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('ss', $userId, $orderId);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $result = $stmt->get_result()->fetch_assoc();

        $products = [];

        $decodedProducts = json_decode($result['products'], true);

        foreach ($decodedProducts as $product) {
            $products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
        }

        $order = new Order($result['user_id'], new AddressData($result['street'], $result['city'], $result['postal'], $result['address_id']), $products, (float) $result['total_price'], $result['delivery_date'], $result['status'], $result['created_at'], $result['id']);

        $stmt->close();

        return $order;
    }


    public function getOrdersByUserId(string $userId): ?array
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? ORDER BY created_at";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('s', $userId);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $products = [];

        foreach ($orders as $key => $order) {
            $decodedProducts = json_decode($order['products'], true);

            foreach ($decodedProducts as $product) {
                $products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
            }



            $orders[$key] = new Order($order['user_id'], new AddressData($order['street'], $order['city'], $order['postal'], $order['address_id']), $products, (float) $order['total_price'], $order['delivery_date'], $order['status'], $order['created_at'], $order['id']);
        }

        $stmt->close();


        return $orders;
    }

    public function getOrdersByUserIdAndStatus(string $userId, $status)
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? AND status = ? ORDER BY created_at";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss', $userId, $status);
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $products = [];

        foreach ($orders as $key => $order) {
            $decodedProducts = json_decode($order['products'], true);

            foreach ($decodedProducts as $product) {
                $products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
            }


            foreach ($orders as $key => $order) {
                $products = json_decode($order['products'], true);
                $orders[$key] = new Order($order['user_id'], new AddressData($order['street'], $order['city'], $order['postal'], $order['address_id']), $products, (float) $order['total_price'], $order['delivery_date'], $order['status'], $order['created_at'], $order['id']);
            }


            $stmt->close();

            return $orders;
        }
    }
}