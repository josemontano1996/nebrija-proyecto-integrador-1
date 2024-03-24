<?php

declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\Classes\CartCookieItem;

/**
 * Class CartCookie
 * 
 * Represents a cart stored in a cookie.
 */
class CartCookie
{

    /**
     * @var CartCookieItem[] $cart The cart data.
     */
    private array $cart = [];


    /**
     * CartCookie constructor.
     *
     * @param CartDataInitializer|null $cart The cart data initializer.
     * if null, the cart will be fetched from the cookie.
     * if not null, the cart will be initialized from the cart data initializer.
     */
    public function __construct(?CartDataInitializer $cart = null)
    {
        if ($cart !== null) {
            $cartData = $cart->getProducts();

            foreach ($cartData as $product) {
                $productData = new CartCookieItem($product->getId(), $product->getQuantity());
                $this->cart[] = $productData;
            }
        } else {
            $this->cart = self::getCartFromCookie();
        }
    }

    /**
     * Saves the cart data to a cookie.
     *
     * @return void
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
    public function getIds(): array
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
     * @return CartCookieItem[] The cart data stored in the cookie.
     */
    public function getCart(): array
    {
        return $this->cart;
    }

    public function getIndex(int $index): CartCookieItem
    {
        return $this->cart[$index];
    }

    public function getArrayLength(): int
    {
        return count($this->cart);
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
