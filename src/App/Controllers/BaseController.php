<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\ServerErrorLog;
use App\Models\ProductModel;
use App\ResponseStatus;

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
        // Render the home page view
        return (new View('home'))->render();
    }

    /**
     * Retrieves the menu view.
     *
     * @return string |null The rendered menu view.
     */
    public function getMenu(): ?string
    {
        try {
            // Get all products from the database
            $products = ProductModel::getAllByType();

            if (empty($products)) {
                // If no products are found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'No products found.');
            }

            // Render the view with the products
            return (new View('menu', $products))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the menu. Please try again later.');
        }
    }
}
