<?php

declare(strict_types=1);

namespace App\Models\Cart;

use App\DAO\CartDAO;
use App\Models\Cart\CartCookie;
use App\Models\Classes\CartCookieItem;

/**
 * Class CartDb
 * 
 * Represents a database for storing and retrieving cart information.
 */
class CartDb
{
    private string $user_id;
    private array $products;

    /**
     * CartDb constructor.
     * 
     * @param string $user_id The ID of the user associated with the cart.
     * @param CartCookie $cartCookie The cart cookie object used to retrieve the cart products.
     */
    public function __construct(string $user_id,  CartCookie $cartCookie)
    {
        $this->user_id = $user_id;
        $this->products = $cartCookie->getCart();
    }

    /**
     * Saves the cart to the database.
     * 
     * @return bool Returns true if the cart was successfully saved, false otherwise.
     */
    public function saveCart(): bool
    {
        $cartDAO = new CartDAO();

        $result = false;

        if (count($this->products) === 0) {
            $result = $cartDAO->deleteCart($this->user_id);
        } else {
            $result = $cartDAO->updateCart($this->user_id, $this->products);
        }

        return $result;
    }

    /**
     * Loads the cart from the database.
     * 
     * @return array<CartCookieItem>|null Returns an array containing the cart products, or null if the cart is empty.
     */
    public function loadCart(): ?array
    {
        $cartDAO = new CartDAO();
        return $cartDAO->getCart($this->user_id);
    }
}
