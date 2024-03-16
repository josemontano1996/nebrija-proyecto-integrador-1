<?php

namespace App\Classes;

/**
 * The abstract Product class represents a generic product.
 */
abstract class Product
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
    protected function __construct(
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
}
