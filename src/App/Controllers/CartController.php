<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Cart\CartCookie;
use App\Models\Cart\CartDataInitializer;
use App\View;

/**
 * The CartController class is responsible for handling the main cart functionalities of the application.
 */
class CartController
{

    /**
     * Retrieves the cart view.
     *
     * @return string The rendered cart view.
     */
    public function getCart(): ?string
    {
        try {
            $cart = new CartDataInitializer();

            $cartProducts = $cart->getProducts();
            $totalPrice = $cart->getTotalPrice();

            return (new View('cart', ['products' => $cartProducts, 'totalPrice' => $totalPrice]))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error while loading the cart. Please try again later.';
            http_response_code(500);
            header('Location: /menu');
        }
    }
}
