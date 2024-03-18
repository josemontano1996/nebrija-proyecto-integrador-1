<?php

declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\ProductModel;

/**
 * Class CartDataInitializer
 * Prepares the cart data for display, including merging cookie data with fetched products and calculating totals.
 * For working with the cart cookie use CartCookie.
 * For making database operation use  CartDb .
 */

class CartDataInitializer
{
    private array $products = [];
    private float $totalPrice = 0;

    private bool $notFoundProduct = false;

    /**
     * CartDataInitializer constructor.
     * Initializes the cart data by merging fetched products with cookie cart items and calculating the total price.
     */
    public function __construct()
    {
        $this->initializeCartData();
        $this->calculateTotalPrice();
    }

    /**
     * Initializes the products in the cart by merging fetched products with cookie cart items.
     */
    public function initializeCartData(): void
    {
        // Get the cart from the cookie
        $cookieCart = new CartCookie();

        $cookieCartData = $cookieCart->getCart();

        // Get the ids of the products in the cart
        $id_list = $cookieCart->getIds();

        // If the cart is empty, redirect to the menu page
        if (count($id_list) === 0) {
            $_SESSION['error'] = 'Your cart is empty, add some items to it first.';
            http_response_code(500);
            header('Location: /menu');
            exit();
        }

        // Get the products from the database
        [$fetchedProducts, $notFoundProduct] = ProductModel::getProductsByIds($id_list);

        $this->notFoundProduct = $notFoundProduct;

        $mergedProducts = $this->mergeProducts($fetchedProducts, $cookieCartData);

        $this->products = $mergedProducts;


        if ($notFoundProduct) {
            $cartCookie = new CartCookie($this);
            $cartCookie->saveCart();

            $_SESSION['error'] = 'Some of your cart products were modified or deleted, your cart has been updated.';
        }
    }

    private function mergeProducts(array $fetchedProducts, array $cookieCartData): array
    {
        $products = [];

        foreach ($fetchedProducts as $product) {
            $found = false;
            $index = 0;
            do {

                $cookieItem = $cookieCartData[$index];
                $cookieId =  $cookieItem['id'];
                $productId =  $product['id'];

                if ($cookieId === $productId) {

                    $products[] = new CartProductData($product['id'], $product['name'], $cookieItem['quantity'], $product['price'], $product['type'], $product['image_url'], $product['description'], $product['min_servings']);
                    $found = true;
                }

                $index++;
            } while (!$found && $index < count($cookieCartData));
        }

        return $products;
    }

    /**
     * Calculates the total price of all products in the cart.
     */
    public function calculateTotalPrice(): void
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

    /**
     * Checks if any product in the cart was not found.
     *
     * @return bool True if a product was not found, false otherwise.
     */
    public function getNotFoundProduct(): bool
    {
        return $this->notFoundProduct;
    }
}
