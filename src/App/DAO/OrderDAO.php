<?php

namespace App\DAO;

use App\DB;
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

        $user_id  = $db->real_escape_string($user_id);
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

    public function getOrdersByUserId(string $userId): ?array
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);

        $sql = "SELECT * FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? ORDER BY created_at";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('s', $userId);

        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($orders as $key => $order) {
            $orders[$key]['total_price'] = (float) $order['total_price'];
            $orders[$key]['products'] = json_decode($order['products'], true);
        }

        $stmt->close();

        return $orders;
    }

    public function getOrdersByUserIdAndStatus(string $userId, $status)
    {
        $db = $this->db;

        $userId = $db->real_escape_string($userId);

        $sql = "SELECT * FROM orders INNER JOIN addresses ON orders.address_id = addresses.id WHERE user_id = ? AND status = ? ORDER BY created_at";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('ss', $userId, $status);
        $result = $stmt->execute();

        if (!$result) {
            return null;
        }

        $orders = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($orders as $key => $order) {
            $orders[$key]['total_price'] = (float) $order['total_price'];
            $orders[$key]['products'] = json_decode($order['products'], true);
        }

        $stmt->close();

        return $orders;
    }
}
