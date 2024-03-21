<?php

namespace App\Models\Classes;

class CartCookieItem {
    private string $id;
    private int $quantity;

    /**
     * CartCookieItem constructor.
     *
     * @param string $id The ID of the cart item.
     * @param int $quantity The quantity of the cart item.
     */
    public function __construct(string $id, int $quantity) {
        $this->id = $id;
        $this->quantity = $quantity;
    }

    /**
     * Get the ID of the cart item.
     *
     * @return string The ID of the cart item.
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * Get the quantity of the cart item.
     *
     * @return int The quantity of the cart item.
     */
    public function getQuantity(): int {
        return $this->quantity;
    }
}