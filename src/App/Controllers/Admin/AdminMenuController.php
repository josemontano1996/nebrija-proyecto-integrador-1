<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

require_once __DIR__ .  '/../../../../src/lib/upload.php';
require_once __DIR__ .  '/../../../const/consts.php';
require_once __DIR__ .  '/../../../lib/data-validation.php';

use App\ResponseStatus;
use App\View;
use App\Models\ProductModel;
use App\ServerErrorLog;

/**
 *
 * The AdminMenuController class is responsible for handling the admin menu functionality.
 */
class AdminMenuController
{
    /**
     * Retrieves the menu and renders the view with the products.
     *
     * @return string|null The rendered view with the products, or null if an error occurs.
     */
    public function getMenu(): ?string
    {
        try {
            // Get all products from the database
            $products = ProductModel::getAllByType();
            // Render the view with the products
            return (new View('admin/menu/adminMenu', $products))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the menu. Please try again later.', '/admin/menu');
        }
    }

    /**
     * Retrieves the product to be updated and renders the update view.
     *
     * @return string|null The rendered update view with the product, or null if an error occurs.
     */
    public function getUpdateProduct(): ?string
    {
        try {
            // Get the product id from the GET request
            $productId = $_GET['productId'];

            // Get the product by id
            $product = ProductModel::getProductById($productId);

            if (!$product) {
                // If no product is found, return a 404 error
                ResponseStatus::sendResponseStatus(404, 'Product not found', '/admin/menu');
            }
            // Render the view with the product
            return (new View('admin/product/update', $product))->render();
        } catch (\Exception $e) {
            // Log the error and return a 500 error
            ServerErrorLog::logError($e);
            ResponseStatus::sendResponseStatus(500, 'Error while loading the product. Please try again later.', '/admin/menu');
        }
    }

    /**
     * Updates the product data based on the POST request.
     *
     * @return void
     */
    public function postUpdateProductAjax(): void
    {
        // Get the product data from the POST request
        $id =  $_POST['id'];
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        (int)  $min_servings = $_POST['min_servings'] ?  $_POST['min_servings'] : 0;
        $price = (float) $_POST['price'];
        $type = $_POST['type'];
        $old_image_url = $_POST['old_image_url'];
        $new_image = ($_FILES['new_image']['size'] > 0) ? $_FILES['new_image'] : null;

        // Validate the product data
        $isInvalidData = isInvalidProductData($name, $description, $min_servings, $price, $type, $new_image);

        if ($isInvalidData) {
            // If the data is invalid, return a 400 error
            ResponseStatus::sendResponseStatus(400, $isInvalidData, null, true);
        }

        $new_image_url = $old_image_url;

        //if there is a new image, we upload it and delete the old one
        if ($new_image) {
            //upload the new image and delete old one
            $new_image_url = uploadImage($new_image);
            unlink(ROOT_PATH . $old_image_url);
        }

        try {

            // Update the product in the database
            $productInstance = new ProductModel($name, $description, $price, $type, $new_image_url, $min_servings, $id);
            $success = $productInstance->update();

            if (!$success) {
                ResponseStatus::sendResponseStatus(500, 'Error while updating the product.', null, true);
            }

            ResponseStatus::sendResponseStatus(200, null, '/admin/menu', true);
        } catch (\Exception $e) {
            // Log the error
            ServerErrorLog::logError($e);

            if (isset($new_image_url)) {
                //delete the new image in case of error
                unlink(ROOT_PATH . $new_image_url);
            }

            if ($e->getCode() === 1062) {
                ResponseStatus::sendResponseStatus(409, 'There is a product with the same name. Please enter a different name.', null, true);
            } else {
                ResponseStatus::sendResponseStatus(500, 'Something went wrong', null, true);
            }
        }
    }

    /**
     * Retrieves the view for adding a new product.
     *
     * @return string The rendered view for adding a new product.
     */
    public function getNewProduct(): string
    {
        // Render the view for adding a new product
        return (new View('admin/product/new'))->render();
    }

    /**
     * Adds a new product based on the POST request.
     *
     * @return void
     */
    public function postNewProductAjax(): void
    {

        // Get the product data from the POST request
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $min_servings = $_POST['min_servings'] ? (int) $_POST['min_servings'] : 0;
        $price = (float) $_POST['price'];
        $type = $_POST['type'];
        $image = $_FILES['image'];

        // Validate the product data
        $isInvalidData = isInvalidProductData($name, $description, $min_servings, $price, $type, $image);

        if ($isInvalidData) {
            // If the data is invalid, return a 400 error
            ResponseStatus::sendResponseStatus(400, $isInvalidData, null, true);
        }

        // Upload the image
        $image_url = uploadImage($image);

        try {
            // Add the product to the database
            $productInstance = new ProductModel($name, $description, $price, $type, $image_url, $min_servings);
            $success = $productInstance->add();

            if (!$success) {
                // If the product was not added, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Error while adding the product.', null, true);
            }

            ResponseStatus::sendResponseStatus(200, null, '/admin/menu', true);
        } catch (\Exception $e) {
            // Log the error
            ServerErrorLog::logError($e);

            //deleting the image in case of error
            unlink(ROOT_PATH .  $image_url);

            if ($e->getCode() === 1062) {
                // If there is a product with the same name, return a 409 error
                ResponseStatus::sendResponseStatus(409, 'There is a product with the same name. Please enter a different name.', null, true);
            } else {
                // If there is an error, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Something went wrong', null, true);
            }
        }
    }

    /**
     * Deletes a product based on the GET request.
     *
     * @return void
     */
    public function deleteProductAjax(): void
    {
        try {
            // Get the product id and image url from the GET request
            $product_id = $_GET['productId'];

            //decoding the url parameter for image url
            $image_url = urldecode($_GET['imageUrl']);

            // Delete the product from the database
            $isDeleted = ProductModel::delete($product_id);

            if ($isDeleted) {
                // If the product was deleted, delete the image
                unlink(ROOT_PATH . $image_url);
            } else {
                // If the product was not deleted, return a 500 error
                ResponseStatus::sendResponseStatus(500, 'Error while deleting the product.', null, true);
            }

            ResponseStatus::sendResponseStatus(200, 'Success deleting the product.', null, true);
        } catch (\Exception $e) {
            // Log the error
            ServerErrorLog::logError($e);

            // If there is an error, return a 500 error
            ResponseStatus::sendResponseStatus(500, 'Something went wrong', null, true);
        }
    }
}
