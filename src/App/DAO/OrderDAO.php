<?php

namespace App\DAO;

use App\DB;
use App\Models\Classes\Order;
use App\Models\OrderModel;
use mysqli;
use Ramsey\Uuid\Uuid;

class OrderDAO
{
    private mysqli $db;

    /**
     * OrderDAO constructor.
     */
    public function __construct()
    {
        $this->db = DB::getInstance()->getDb();
    }

    /**
     * Saves order data to the database.
     *
     * @param string $user_id The ID of the user placing the order.
     * @param string $address_id The ID of the address associated with the order.
     * @param array $products An array of products in the order.
     * @param float $total_price The total price of the order.
     * @param string $status The status of the order.
     * @param string $delivery_date The delivery date of the order.
     * @return bool Returns true if the order data is successfully saved, false otherwise.
     */
    public function saveOrderData(string $user_id, string $user_name, string $address_id, array $products, float $total_price, string $status, string $delivery_date): bool
    {
        $db = $this->db;
        $order_id = Uuid::uuid4();
        $jsonProducts = json_encode($products);

        $user_id = $db->real_escape_string($user_id);
        $user_name = $db->real_escape_string($user_name);
        $address_id = $db->real_escape_string($address_id);
        $status = $db->real_escape_string($status);
        $delivery_date = $db->real_escape_string($delivery_date);

        $sql = "INSERT INTO orders (id,  user_id, user_name, address_id, products, total_price, status, delivery_date, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('sssssdss', $order_id, $user_id, $user_name, $address_id, $jsonProducts, $total_price, $status, $delivery_date);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }

    public function getAllOrders(?int $page = null, ?int $limit = 5): ?array
    {
        $db = $this->db;

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id ORDER BY delivery_date DESC";

        if (isset($page)) {
            $start = 0;
            if ($page > 0) {
                $start = ($page - 1) * $limit;
            }
            $sql = $sql . " LIMIT $start, $limit";
        }


        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $orders = OrderModel::generateMultipleOrderDataFromDb($orders);

        $stmt->close();

        return $orders;
    }

    public function changeOrderStatus(string $orderId, string $status): bool
    {

        $db = $this->db;

        $orderId = $db->real_escape_string($orderId);
        $status = $db->real_escape_string($status);

        $sql = "UPDATE orders SET status = ? WHERE id = ?";

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ss', $status, $orderId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }

    /**
     * Retrieves an order by user ID and order ID.
     *
     * @param string $userId The ID of the user.
     * @param string $orderId The ID of the order.
     * @return Order|null Returns the Order object if found, null otherwise.
     */
    public function getUserOrderById(string $userId, string $orderId): ?Order
    {

        $db = $this->db;

        $userId = $db->real_escape_string($userId);
        $orderId = $db->real_escape_string($orderId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? AND orders.id = ?";

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('ss', $userId, $orderId);

        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result()->fetch_assoc();

        $order = OrderModel::generateOneOrderDataFromDb($result);

        $stmt->close();

        return $order;
    }
    public function getOrderById(string $orderId): ?Order
    {

        $db = $this->db;

        $orderId = $db->real_escape_string($orderId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE orders.id = ?";

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $orderId);

        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result()->fetch_assoc();

        if (!$result) {
            $stmt->close();
            return null;
        }
        $order = OrderModel::generateOneOrderDataFromDb($result);

        $stmt->close();

        return $order;
    }

    /**
     * Retrieves orders by user ID.
     *
     * @param string $userId The ID of the user.
     * @return Order[]|null Returns an array of Order objects if found, null otherwise.
     */
    public function getOrdersByUserId(string $userId, ?int $page = null, ?int $limit = 5): ?array
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? ORDER BY created_at DESC";

        if (isset($page)) {
            $start = 0;
            if ($page > 0) {
                $start = ($page - 1) * $limit;
            }
            $sql = $sql . " LIMIT $start, $limit";
        }

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $userId);

        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $orders = OrderModel::generateMultipleOrderDataFromDb($orders);

        $stmt->close();

        return $orders;
    }

    /**
     * Retrieves orders by user ID and status.
     *
     * @param string $userId The ID of the user.
     * @param mixed $status The status of the orders.
     * @return Order[]|null Returns an array of Order objects if found, null otherwise.
     */
    public function getOrdersByUserIdAndStatus(string $userId, string $status, ?int $page = null, ?int $limit = 5): ?array
    {

        $db = $this->db;

        $userId = $db->real_escape_string($userId);
        $status = $db->real_escape_string($status);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? AND status = ? ORDER BY created_at";
        if (isset($page)) {
            $start = 0;
            if ($page > 0) {
                $start = ($page - 1) * $limit;
            }
            $sql = $sql . " LIMIT $start, $limit";
        }

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('ss', $userId, $status);
        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $orders = OrderModel::generateMultipleOrderDataFromDb($orders);

        $stmt->close();

        return $orders;
    }
    public function getAllOrdersByStatus(string $status, ?int $page = null, ?int $limit = 5): ?array
    {
        $db = $this->db;

        $status = $db->real_escape_string($status);

        $sql = "SELECT orders.*, addresses.street, addresses.city, addresses.postal FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE status = ? ORDER BY delivery_date DESC";

        if (isset($page)) {
            $start = 0;
            if ($page > 0) {
                $start = ($page - 1) * $limit;
            }
            $sql = $sql . " LIMIT $start, $limit";
        }


        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s',  $status);
        $result = $stmt->execute();

        if (!$result) {
            $stmt->close();
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $orders = OrderModel::generateMultipleOrderDataFromDb($orders);

        $stmt->close();

        return $orders;
    }

    /**
     * Cancels an order.
     *
     * @param string $userId The ID of the user.
     * @param string $orderId The ID of the order.
     * @return bool Returns true if the order is successfully cancelled, false otherwise.
     */
    public function cancelOrder(string $userId, string $orderId): bool
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);
        $orderId = $db->real_escape_string($orderId);

        $sql = "UPDATE orders SET status = 'cancelled' WHERE user_id = ? AND id = ?";

        $stmt = $db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param('ss', $userId, $orderId);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
}
