<?php

declare(strict_types=1);

namespace App\DAO;

use App\DB;
use mysqli;
use Ramsey\Uuid\Uuid;
use App\Models\Classes\Product;

/**
 * Class ProductDAO
 * 
 * This class represents the Data Access Object (DAO) for the products table.
 * It provides methods to interact with the products table in the database.
 */
class ProductDAO
{
    private mysqli $db;

    /**
     * ProductDAO constructor.
     * 
     * Initializes a new instance of the ProductDAO class.
     * It establishes a connection to the database.
     */
    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    /**
     * Retrieves all products from the database.
     * 
     * @return array An array of products.
     */
    public function getAllProducts(): array
    {
        $db = $this->db;

        $result = $db->query("SELECT * FROM products");

        $products = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($products as $key => $product) {
            $products[$key]['price'] = (float) $product['price'];
            $products[$key]['min_servings'] = (int) $product['min_servings'];
        }

        return $products;
    }

    /**
     * Adds a new product to the database.
     * 
     * @param string $name The name of the product.
     * @param string $description The description of the product.
     * @param int $min_servings The minimum servings of the product.
     * @param float $price The price of the product.
     * @param string $type The type of the product.
     * @param string $image_url The URL of the product image.
     * 
     * @return bool True if the product was added successfully, false otherwise.
     */
    public function addNewProduct(string $name, string $description, int $min_servings, float $price, string $type, string $image_url): bool
    {
        $db = $this->db;

        $name = $db->real_escape_string($name);
        $description = $db->real_escape_string($description);
        $min_servings = filter_var($min_servings, FILTER_VALIDATE_INT);
        $price = filter_var($price, FILTER_VALIDATE_FLOAT);
        $type = $db->real_escape_string($type);
        $image_url = $db->real_escape_string($image_url);

        $query = "INSERT INTO products (name, description, min_servings, price, type, image_url) VALUES ( ?, ?, ?, ?, ?, ?)";

        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        $statement->bind_param('ssidss',  $name, $description, $min_servings, $price, $type, $image_url);

        $result = $statement->execute();

        // Close the statement
        $statement->close();

        return $result;
    }

    /**
     * Retrieves a product by its ID from the database.
     * 
     * @param string $productId The ID of the product.
     * 
     * @return array|null The product data as an associative array, or null if the product is not found.
     */
    public function getProductById(string $productId): ?array
    {
        $db = $this->db;

        $query = "SELECT * FROM products WHERE id = ?";

        $statement = $db->prepare($query);

        if (!$statement) {
            return null;
        }

        $statement->bind_param('s', $productId);

        $statement->execute();

        // Get the result
        $result = $statement->get_result();

        // Fetch the product data
        $product = $result->fetch_assoc();

        // Close the result set and statement
        $result->close();
        $statement->close();

        $product['price'] = (float) $product['price'];
        $product['min_servings'] = (int) $product['min_servings'];

        return $product;
    }

    /**
     * Updates a product in the database.
     * 
     * @param string $id The ID of the product to update.
     * @param string $name The new name of the product.
     * @param string $description The new description of the product.
     * @param int $min_servings The new minimum servings of the product.
     * @param float $price The new price of the product.
     * @param string $type The new type of the product.
     * @param string $image_url The new URL of the product image.
     * 
     * @return bool True if the product was updated successfully, false otherwise.
     */
    public function updateProduct(string $id, string $name, string $description, int $min_servings, float $price, string $type, string $image_url): bool
    {
        $db = $this->db;

        $name = $db->real_escape_string($name);
        $description = $db->real_escape_string($description);
        $min_servings = filter_var($min_servings, FILTER_VALIDATE_INT);
        $price = filter_var($price, FILTER_VALIDATE_FLOAT);
        $type = $db->real_escape_string($type);
        $new_image_url = $image_url ? $db->real_escape_string($image_url) : null;

        $query = "UPDATE products SET name = ?, description = ?, min_servings = ?, price = ?, type = ? , image_url = ? WHERE id = ?";

        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        $statement->bind_param('ssidsss', $name, $description, $min_servings, $price, $type, $new_image_url, $id);

        $result = $statement->execute();

        // Close the statement
        $statement->close();

        return $result;
    }

    /**
     * Retrieves multiple products by their IDs from the database.
     * 
     * @param array $ids An array of product IDs.
     * 
     * @return [ ?Product[], bool ] : An array containing the products and a boolean indicating if any product was not found.
     */
    public function getProductsByIds(array $ids): array
    {
        $db = $this->db;

        // Implode the IDs without wrapping them
        $placeholders = implode("', '", $ids);

        $query = "SELECT * FROM products WHERE id IN ('$placeholders')";

        $result = $db->query($query);
        $products = $result->fetch_all(MYSQLI_ASSOC);


        foreach ($products as $key => $product) {
            $products[$key] = new Product($product['name'], $product['description'], (float)$product['price'], $product['type'], $product['image_url'], (int) $product['min_servings'], $product['id']);
        }

        $productNotFound = count($products) !== count($ids);

        return [$products,  $productNotFound];
    }

    /**
     * Deletes a product from the database.
     * 
     * @param string $id The ID of the product to delete.
     * 
     * @return bool True if the product was deleted successfully, false otherwise.
     */
    public function deleteProduct(string $id): bool
    {
        $db = $this->db;

        $query = "DELETE FROM products WHERE id = ?";

        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        $statement->bind_param('s', $id);

        $result = $statement->execute();

        // Close the statement
        $statement->close();

        return $result;
    }
}
