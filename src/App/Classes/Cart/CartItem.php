<?php

declare(strict_types=1);

namespace App\Classes\Cart;

use App\Classes\Product;

/**
 * Class CartItem
 * 
 * Represents an item in the Cart.
 */

class CartItem extends Product
{
    protected float $subtotal;
    protected int $quantity;

    /**
     * CartItem constructor.
     *
     * @param string $id The ID of the cart item.
     * @param string $name The name of the cart item.
     * @param int $quantity The quantity of the cart item.
     * @param float $price The price of the cart item.
     * @param string $type The type of the cart item.
     * @param string $image_url The image URL of the cart item.
     * @param string $description The description of the cart item.
     * @param int $min_servings The minimum servings of the cart item.
     */
    public function __construct(
        string $id,
        string $name,
        int $quantity,
        float $price,
        string $type,
        string $image_url,
        string $description,
        int $min_servings = 0,
    ) {
        parent::__construct($name, $description, $price, $type, $image_url, $min_servings, $id);
        $this->quantity = $quantity;
        $this->subtotal = $this->calculateSubtotal();
    }

    /**
     * Calculates the subtotal of the item.
     *
     * @return float The subtotal of the item.
     */
    public function calculateSubtotal(): float
    {
        $subtotal = $this->price * $this->quantity;
        return number_format($subtotal, 2, '.', '');
    }

    /**
     * Get the subtotal of the cart item.
     *
     * @return float The subtotal of the cart item.
     */
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    /**
     * Get the quantity of the cart item.
     *
     * @return int The quantity of the cart item.
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Get the ID of the cart item.
     *
     * @return string The ID of the cart item.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the name of the cart item.
     *
     * @return string The name of the cart item.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the price of the cart item.
     *
     * @return float The price of the cart item.
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the type of the cart item.
     *
     * @return string The type of the cart item.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the image URL of the cart item.
     *
     * @return string The image URL of the cart item.
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * Get the description of the cart item.
     *
     * @return string The description of the cart item.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the minimum servings of the cart item.
     *
     * @return int The minimum servings of the cart item.
     */
    public function getMinServings(): int
    {
        return $this->min_servings;
    }

    /**
     * Get all data of the cart item.
     *
     * @return CartItem The cart item object.
     */
    public function getAllData(): CartItem
    {
        return $this;
    }
}
