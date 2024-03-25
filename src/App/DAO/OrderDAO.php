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

    public function saveOrderData(string $user_id, string $address_id, array $products, float $total_price, string $delivery_date): bool
    {
        $db = $this->db;
            $order_id = Uuid::uuid4();
        $jsonProducts = json_encode($products);

        $sql = "INSERT INTO orders (id, user_id, address_id, products, total_price, delivery_date, createdAt) VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $db->prepare($sql);

        $stmt->bind_param('ssssis', $order_id, $user_id, $address_id, $jsonProducts, $total_price, $delivery_date);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }
}
