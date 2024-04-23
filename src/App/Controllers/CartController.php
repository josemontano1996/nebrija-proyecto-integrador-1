<?php

declare(strict_types=1);

namespace App\Controllers;

use App\AuthSession;
use App\Models\Cart\CartDataInitializer;
use App\ResponseStatus;
use App\ServerErrorLog;
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
            // Get the products from the cart
            $cart = new CartDataInitializer();
            $cartProducts = $cart->getProducts();
            $totalPrice = $cart->getTotalPrice();

            // Get the user name from the session
            $user_name = AuthSession::getUserName();

            // Render the view with the cart products and total price
            return (new View('cart', ['products' => $cartProducts, 'totalPrice' => $totalPrice, 'user_name' => $user_name]))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the cart. Please try again later.');
        }
    }
}
