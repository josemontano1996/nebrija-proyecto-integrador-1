<?php

declare(strict_types=1);

namespace App\Models\Cart;

use App\Models\Abstract\Product;

/**
 * Class CartProductData
 * 
 * Represents a product in the cart.
 */
class CartProductData extends Product
{
    protected float $subtotal;
    protected int $quantity;

    /**
     * CartProductData constructor.
     *
     * @param string $id The ID of the cart product.
     * @param string $name The name of the cart product.
     * @param int $quantity The quantity of the cart product.
     * @param float $price The price of the cart product.
     * @param string $type The type of the cart product.
     * @param string $image_url The image URL of the cart product.
     * @param string $description The description of the cart product.
     * @param int $min_servings The minimum servings of the cart product.
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
     * Calculates the subtotal of the cart product.
     *
     * @return float The subtotal of the cart product.
     */
    public function calculateSubtotal(): float
    {
        $subtotal = $this->price * $this->quantity;
        return (float) number_format($subtotal, 2, '.', '');
    }

    /**
     * Get the subtotal of the cart product.
     *
     * @return float The subtotal of the cart product.
     */
    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    /**
     * Get the quantity of the cart product.
     *
     * @return int The quantity of the cart product.
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Get the ID of the cart product.
     *
     * @return string|null The ID of the cart product.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Get the name of the cart product.
     *
     * @return string The name of the cart product.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the price of the cart product.
     *
     * @return float The price of the cart product.
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the type of the cart product.
     *
     * @return string The type of the cart product.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the image URL of the cart product.
     *
     * @return string The image URL of the cart product.
     */
    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    /**
     * Get the description of the cart product.
     *
     * @return string The description of the cart product.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the minimum servings of the cart product.
     *
     * @return int The minimum servings of the cart product.
     */
    public function getMinServings(): int
    {
        return $this->min_servings;
    }
}
