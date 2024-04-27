<?php

declare(strict_types=1);

namespace App\Models;

require_once __DIR__ . '/../../const/consts.php';

use App\DAO\ProductDAO;
use App\Models\Classes\Product;

/**
 * Class ProductModel
 * 
 * Represents a model for managing products in the application.
 */
class ProductModel extends Product
{

    /**
     * ProductModel constructor.
     *
     * @param string      $name          The name of the product.
     * @param string      $description   The description of the product.
     * @param float       $price         The price of the product.
     * @param string      $type          The type of the product.
     * @param string|null $image_url     The URL of the product image (optional).
     * @param int|null    $min_servings  The minimum servings of the product (optional).
     * @param string|null $id            The ID of the product (optional).
     */
    public function __construct(
        string $name,
        string $description,
        float $price,
        string $type,
        ?string $image_url = null,
        ?int $min_servings = 0,
        ?string $id = null
    ) {
        parent::__construct($name, $description, $price, $type, $image_url, $min_servings, $id);
    }

    /**
     * Updates the product in the database.
     *
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(): bool
    {
        $productDAO = new ProductDAO();

        $result = $productDAO->updateProduct($this->id, $this->name, $this->description, $this->min_servings, $this->price, $this->type, $this->image_url);

        return $result;
    }

    /**
     * Retrieves multiple products by their IDs.
     *
     * @param array<string> $ids An array of product IDs.
     * @return  array{products: Product[], not_found: bool} An array containing the products and a boolean indicating if any product was not found.
     */
    static public function getProductsByIds(array $ids): array
    {

        $productDAO = new ProductDAO();

        $result = $productDAO->getProductsByIds($ids);

        return $result;
    }

    /**
     * Retrieves a product by its ID.
     *
     * @param string $productId The ID of the product.
     * @return array|null The retrieved product or null if not found.
     */
    static public function getProductById(string $productId): ?Product
    {
        $productDAO = new ProductDAO();
        $product = $productDAO->getProductById($productId);
        
        return $product;
    }

    /**
     * Retrieves all products sorted by type.
     *
     * @return array An array containing the products sorted by type.
     */
    static public function getAllByType(): array
    {
        $productDAO = new ProductDAO();
        $products = $productDAO->getAllProducts();

        $sortedByType = [];

        foreach (DISHES_TYPES as $type) {
            $typeProducts = array_filter($products, fn ($product) => $product->getType() === $type);
            $sortedByType[$type] = $typeProducts;
        }

        return $sortedByType;
    }

    /**
     * Retrieves all products.
     *
     * @return array An array containing all the products.
     */
    static public function getAll(): array
    {
        $productDAO = new ProductDAO();
        $products = $productDAO->getAllProducts();

        return $products;
    }

    /**
     * Adds a new product to the database.
     *
     * @return bool True if the product was added successfully, false otherwise.
     */
    public function add(): bool
    {
        $productDAO = new ProductDAO();
        $result = $productDAO->addNewProduct($this->name, $this->description, $this->min_servings, $this->price, $this->type, $this->image_url);

        return $result;
    }

    /**
     * Deletes a product from the database.
     *
     * @param string $product_id The ID of the product to delete.
     * @return bool True if the product was deleted successfully, false otherwise.
     */
    static public function delete(string $product_id): bool
    {
        $productDAO = new ProductDAO();
        $result = $productDAO->deleteProduct($product_id);

        return $result;
    }

    /**
     * Retrieves all data of the product.
     *
     * @return array An array containing all the data of the product.
     */
    public function getAllData(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'min_servings' => $this->min_servings,
            'price' => $this->price,
            'type' => $this->type,
            'image_url' => $this->image_url,
            'id' => $this->id
        ];
    }
}
