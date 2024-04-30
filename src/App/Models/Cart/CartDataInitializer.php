<?php

declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\ProductModel;
use App\Models\Classes\Product;
use App\ResponseStatus;

/**
 * Class CartDataInitializer
 * Prepares the cart the complete cart data, including merging cookie data with fetched products and calculating totals.
 * For working with the cart cookie use CartCookie.
 * For making database operation use  CartDb .
 */
class CartDataInitializer
{

    /**
     * @var CartProductData[] $products An array of CartProductData objects representing the products in the cart.
     * @var float $totalPrice The total price of all products in the cart.
     */
    private array $products = [];
    private float $totalPrice = 0;

    /**
     * CartDataInitializer constructor.
     * Initializes the cart data (primarily for display) by merging fetched products with cookie cart items and calculating the total price.
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
        //I know that this is not the best way to handle this, but I don't have time to implement a better solution
        if (count($id_list) === 0) {
            ResponseStatus::sendResponseStatus(500, 'Your cart is empty, add some items to it first.', '/menu');
        }

        // Get the products from the database
        $result = ProductModel::getProductsByIds($id_list);

        $products = $result['products'];
        $productNotFound = $result['not_found'];

        $mergedProducts = $this->mergeProducts($products, $cookieCartData);

        $this->products = $mergedProducts;

        if ($productNotFound) {
            $cartCookie = new CartCookie($this);
            $cartCookie->saveCart();

            $_SESSION['error'] = 'Some of your cart products were modified or deleted, your cart has been updated.';
        }
    }

    /**
     * Merges fetched products with cookie cart items.
     *
     * @param Product[] $fetchedProducts The fetched products from the database.
     * @param array $cookieCartData The cart items from the cookie.
     * @return CartProductData[] The merged products.
     */
    private function mergeProducts(array $fetchedProducts, array $cookieCartData): array
    {
        $products = [];

        foreach ($fetchedProducts as $product) {
            $found = false;
            $index = 0;
            do {
                $cookieItem = $cookieCartData[$index];
                $cookieId =  $cookieItem['id'];
                $productId =  $product->getId();


                if ($cookieId === $productId) {

                    // If the quantity of the product in the cart is less than the minimum servings, set it to the minimum servings
                    if ($product->getMinServings() > $cookieItem['quantity']) {
                        $cookieItem['quantity'] = $product->getMinServings();
                    }

                    $products[] = new CartProductData($productId, $product->getName(), $cookieItem['quantity'], $product->getPrice(), $product->getType(), $product->getImageUrl(), $product->getDescription(), $product->getMinServings());
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
     * Generates an array of data objects representing the products in the cart.
     *
     * @return array The array of data objects representing the products in the cart.
     */
    public function generateProductsDataObject(): array
    {
        $cartData = [];

        foreach ($this->products as $product) {
            $cartData[] = $product->generateDataObject();
        }

        return $cartData;
    }
}
