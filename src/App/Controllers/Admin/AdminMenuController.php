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

class AdminMenuController
{
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
            http_response_code(400);
            echo json_encode($isInvalidData);
            exit();
        }

        $new_image_url = $old_image_url;
       
        //if there is a new image, we upload it and delete the old one
        if ($new_image) {
            $new_image_url = uploadImage($new_image);
            unlink(ROOT_PATH . $old_image_url);
        }

        try {

            $productInstance = new ProductModel($name, $description, $price, $type, $new_image_url, $min_servings, $id);

            $success = $productInstance->update();

            if (!$success) {
                http_response_code(500);
                echo json_encode("Error while updating the product.");
                exit();
            }

            echo json_encode('/admin/menu');
            exit();
        } catch (\Exception $e) {

            if (isset($new_image_url)) {
                unlink(__DIR__ . '/../../..' . $new_image_url);
            }

            if ($e->getCode() === 1062) {
                http_response_code(409);
                echo json_encode("There is a product with the same name. Please enter a different name.");
                exit();
            } else {
                http_response_code(500);
                echo json_encode("Something went wrong");
                exit();
            }
        }
    }

    public function getNewProduct(): string
    {
        return (new View('admin/product/new'))->render();
    }

    public function postNewProduct(): void
    {

        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $min_servings = $_POST['min_servings'] ? (int) $_POST['min_servings'] : 0;
        $price = (float) $_POST['price'];
        $type = $_POST['type'];
        $image = $_FILES['image'];

        $isInvalidData = isInvalidProductData($name, $description, $min_servings, $price, $type, $image);

        if ($isInvalidData) {
            http_response_code(400);
            echo json_encode($isInvalidData);
            exit();
        }

        $image_url = uploadImage($image);

        try {
            $productInstance = new ProductModel($name, $description, $price, $type, $image_url, $min_servings);

            $success = $productInstance->add();

            if (!$success) {
                http_response_code(500);
                echo json_encode("Error while adding the product.");
                exit();
            }

            echo json_encode('/admin/menu');
            exit();
        } catch (\Exception $e) {

            //deleting the image in case of error
            unlink(ROOT_PATH .  $image_url);

            if ($e->getCode() === 1062) {
                http_response_code(409);
                echo json_encode("There is a product with the same name. Please enter a different name");
                exit();
            } else {
                http_response_code(500);
                echo json_encode("Something went wrong");
                exit();
            }
        }
    }

    public function deleteProduct(): void
    {
        try {
            $product_id = $_GET['productId'];

            //decoding the url parameter for image url
            $image_url = urldecode($_GET['imageUrl']);

            $isDeleted = ProductModel::delete($product_id);

            if ($isDeleted) {
                unlink(ROOT_PATH . $image_url);
            } else {
                echo json_encode("Error while deleting.");
                exit();
            }


            echo json_encode("Success deleting the product.");
            exit();
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode("Something went wrong");
            exit();
        }
    }
}
