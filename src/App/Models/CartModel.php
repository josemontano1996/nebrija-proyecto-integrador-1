<?php

declare(strict_types=1);

namespace App\Models;

use App\Classes\Cart\CartCookie;
use App\DB;
use mysqli_result;

class CartModel
{
    private string $user_id;
    private array $items;

    public function __construct(string $user_id,  CartCookie $items)
    {
        $this->user_id = $user_id;
        $this->items = $items->getCart();
    }

    public function saveCart(): mysqli_result | bool
    {
        $dbInstance = DB::getInstance();
        $db = $dbInstance->getDb();

        $items = json_encode($this->items);

        $sql = "INSERT INTO carts (user_id, items) VALUES ('$this->user_id', '$items') ON DUPLICATE KEY UPDATE items = '$items'";

        $result = $db->query($sql);

        return $result;
    }
}
