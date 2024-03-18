<?php

declare(strict_types=1);

namespace App\Models\Cart;

/**
 * Class Cart
 * Represents a shopping cart, only for display and parsing purposes.
 * For working with the cart cookie or saving the cart in the DB use the CartCookie class.
 */
class CartDataInitializer
{
    protected array $products = [];
    protected float $totalPrice = 0;

    /**
     * Cart constructor.
     *
     * @param array $fetchedProducts An array of fetched products.
     * @param CartCookie $cookieCart An array representing the cookie cart.
     */
    public function __construct(array $fetchedProducts, CartCookie $cookieCart)
    {
        $this->initializeCart($fetchedProducts, $cookieCart);
        $this->calculateTotalPrice();
    }

    /**
     * Initializes the products in the cart by merging fetched products with cookie cart items.
     *
     * @param array $fetchedProducts An array of fetched products.
     * @param CartCookie $cookieCart An array representing the cookie cart.
     */
    private function initializeCart(array $fetchedProducts, CartCookie $cookieCart): void
    {
        $cookieCartData = $cookieCart->getCart();
       
        foreach ($fetchedProducts as $product) {
            $found = false;
            $index = 0;
            do {
                $cookieItem = $cookieCartData[$index];
                $cookieId =  $cookieItem['id'];
                $productId =  $product['id'];
                if ($cookieId === $productId) {
                    $product['quantity'] = $cookieItem['quantity'];
                    $found = true;
                }
                $index++;
            } while (!$found && $index < count($cookieCartData));

            if ($found) {
                $this->products[] = new CartProductData($product['id'], $product['name'], $product['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
            }
        }
    }

    /**
     * Calculates the total price of all products in the cart.
     */
    private function calculateTotalPrice(): void
    {
        $totalPrice = 0;

        foreach ($this->products as $product) {
            $totalPrice += $product->getPrice() * $product->getQuantity();
        }

        $this->totalPrice = (float) number_format($totalPrice, 2, '.', '');
    }

    /**
     * Retrieves the products in the cart.
     *
     * @return array The products in the cart.
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Retrieves the total price of all products in the cart.
     *
     * @return float The total price of all products in the cart.
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}
