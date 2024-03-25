<?php

declare(strict_types=1);

namespace App\Models\Classes;

/**
 * The Product class represents a generic product.
 */
class Product
{
    /**
     * Create a new Product instance.
     *
     * @param string $name The name of the product.
     * @param string $description The description of the product.
     * @param float $price The price of the product.
     * @param string $type The type of the product.
     * @param string|null $image_url The URL of the product's image (optional).
     * @param int|null $min_servings The minimum number of servings (optional, default is 0).
     * @param int|null $id The ID of the product (optional).
     */
    public function __construct(
        protected string $name,
        protected string $description,
        protected float $price,
        protected string $type,
        protected ?string $image_url,
        protected ?int $min_servings = 0,
        protected ?string $id = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->type = $type;
        $this->image_url = $image_url;
        $this->min_servings = $min_servings;
        $this->id = $id;
    }
    
    /**
     * Get the name of the product.
     *
     * @return string The name of the product.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the description of the product.
     *
     * @return string The description of the product.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the price of the product.
     *
     * @return float The price of the product.
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get the type of the product.
     *
     * @return string The type of the product.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get the URL of the product's image.
     *
     * @return string|null The URL of the product's image, or null if not set.
     */
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    /**
     * Get the minimum number of servings.
     *
     * @return int|null The minimum number of servings, or null if not set.
     */
    public function getMinServings(): ?int
    {
        return $this->min_servings;
    }

    /**
     * Get the ID of the product.
     *
     * @return string|null The ID of the product, or null if not set.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    public function generateDataObject(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'type' => $this->type,
            'image_url' => $this->image_url,
            'min_servings' => $this->min_servings,
            'id' => $this->id
        ];
    }
}
