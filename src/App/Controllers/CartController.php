<?php

namespace App\Controllers;

use App\Classes\Cart\Cart;
use App\Classes\Cart\CartCookie;
use App\View;
use App\Models\ProductModel as Product;

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
    public function getCart()
    {
        try {
            $cookieCart = new CartCookie();

            // Get the ids of the products in the cart
            $id_list = $cookieCart->fetchIds();

            if (count($id_list) === 0) {
                $_SESSION['error'] = 'Your cart is empty, add some items to it first.';
                http_response_code(500);
                header('Location: /menu');
                exit();
            }

            [$products, $notFoundProduct] = Product::getProductsByIds($id_list);

            $cart = new Cart($products, $cookieCart);

            $cartProducts = $cart->getProducts();
            $totalPrice = $cart->getTotalPrice();

            if ($notFoundProduct) {
                $cartCookie = new CartCookie($cart);
                $cartCookie->saveCart();
                $_SESSION['error'] = 'Some of your cart products were modified or deleted, your cart has been updated.';
            }

            return (new View('cart', ['products' => $cartProducts, 'totalPrice' => $totalPrice]))->render();
            
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error while loading the cart. Please try again later.';
            http_response_code(500);
            header('Location: /menu');
        }
    }
}
