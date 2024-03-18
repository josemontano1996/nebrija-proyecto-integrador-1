<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\ProductModel;

/**
 * The BaseController class is responsible for handling the main functionalities of the application.
 */
class BaseController
{

    /**
     * Retrieves the home page view.
     *
     * @return string The rendered home page view.
     */
    public function getHomePage(): string
    {
        return (new View('home'))->render();
    }

    /**
     * Retrieves the menu view.
     *
     * @return string The rendered menu view.
     */
    public function getMenu(): ?string
    {
        try {

            $products = ProductModel::getAllByType();

            if (empty($products)) {
                $_SESSION['error'] = 'No products found.';
                http_response_code(404);
                header('Location: /');
            }

            return (new View('menu', $products))->render();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error while loading the menu. Please try again later.';
            http_response_code(500);
            header('Location: /');
        }
    }
}
