<?php

declare(strict_types=1);

namespace App\Classes\Cart;

use App\Classes\Cart\Cart;

/**
 * Class CartCookie
 * 
 * Represents a cart stored in a cookie.
 */
class CartCookie
{
    private array $cart = [];

    /**
     * CartCookie constructor.
     * 
     * Initializes a new instance of the CartCookie class.
     * If a Cart object is provided, it retrieves the products from the cart and stores them in the cookie.
     * If no Cart object is provided, it retrieves the cart data from the cookie.
     *
     * @param Cart|null $cart The Cart object to retrieve the products from.
     */
    public function __construct(?Cart $cart = null) 
    {
        if ($cart !== null) {
            $cartData = $cart->getProducts();

            foreach ($cartData as $product) {
                $productData = [
                    'id' => $product->getId(),
                    'quantity' => $product->getQuantity()
                ];
                $this->cart[] = $productData;
            }
        } else {
            $this->cart = self::getCartFromCookie();
        }
    }

    /**
     * Saves the cart data to a cookie.
     */
    public function saveCart(): void
    {
        $cartData = json_encode($this->cart);
        setcookie('cart', $cartData, time() + 7 * 3600, '/');
    }

    /**
     * Fetches the IDs of the products in the cart.
     *
     * @return array The array of product IDs.
     */
    public function fetchIds(): array
    {
        $ids = [];
        foreach ($this->cart as $item) {
            $ids[] = $item['id'];
        }
        return $ids;
    }

    /**
     * Retrieves the cart data stored in the cookie.
     *
     * @return array The cart data stored in the cookie.
     */
    public function getCart(): array
    {
        return $this->cart;
    }

    /**
     * Retrieves the cart data from the cookie.
     *
     * @return array The cart data stored in the cookie.
     */
    static function getCartFromCookie(): array
    {
        $cart = [];

        if (isset($_COOKIE['cart'])) {
            $cart = json_decode($_COOKIE['cart'], true);
        }

        return $cart;
    }
}
