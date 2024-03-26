<?php

namespace App\Models\Classes;

class Order
{
    /**
     * Order constructor.
     *
     * @param string $user_id The ID of the user who placed the order.
     * @param AddressData $address_id The address data associated with the order.
     * @param array $products The array of products included in the order.
     * @param float $total_price The total price of the order.
     * @param string $delivery_date The delivery date of the order.
     * @param string|null $status The status of the order (optional).
     * @param string|null $createdAt The creation date of the order (optional).
     * @param string|null $id The ID of the order (optional).
     */
    public function __construct(
        protected string $user_id,
        protected string $user_name,
        protected AddressData $address_id,
        protected array $products,
        protected float $total_price,
        protected string $delivery_date,
        protected ?string $status = null,
        protected ?string $createdAt = null,
        protected ?string $id = null
    ) {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->address_id = $address_id;
        $this->products = $products;
        $this->total_price = $total_price;
        $this->delivery_date = $delivery_date;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->id = $id;
    }

    /**
     * Get the ID of the order.
     *
     * @return string The ID of the order.
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }
    /**
     * Get the ID of the user who placed the order.
     *
     * @return string The ID of the user.
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * Get the array of products included in the order.
     *
     * @return array The array of products.
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * Get the total price of the order.
     *
     * @return float The total price.
     */
    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    /**
     * Get the delivery date of the order.
     *
     * @return string The delivery date.
     */
    public function getDeliveryDate(): string
    {
        return $this->delivery_date;
    }

    /**
     * Get the creation date of the order.
     *
     * @return string|null The creation date, or null if not set.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Get the status of the order.
     *
     * @return string The status.
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    public function getAddress(): AddressData
    {
        return $this->address_id;
    }
}
