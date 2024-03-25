<?php

namespace App\Models\Classes;

class Order
{
    public function __construct(protected string $user_id, protected string $address_id, protected array $products,   protected float $total_price, protected string $delivery_date,   protected ?string $createdAt = null)
    {
        $this->user_id = $user_id;
        $this->address_id = $address_id;
        $this->products = $products;
        $this->total_price = $total_price;
        $this->delivery_date = $delivery_date;
        $this->createdAt = $createdAt;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getAddressId(): string
    {
        return $this->address_id;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    public function getDeliveryDate(): string
    {
        return $this->delivery_date;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }
}
