<?php

declare(strict_types=1);

namespace App\Models\Classes;


/**
 * The AddressData class is an Classes class that represents delivery data.
 */
class AddressData 
{
    /**
     * @var string $street The street address for the delivery.
     * @var string $city The city for the delivery.
     * @var string $postal The postal code for the delivery.
     * @var string | null $address_id The address ID.
     */
    public function __construct(protected string $street, protected string $city, protected string $postal, protected ?string $address_id = null)
    {
        $this->street = $street;
        $this->city = $city;
        $this->postal = $postal;
        $this->address_id = $address_id;
    }



    /**
     * Get the street address for the delivery.
     *
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * Get the city for the delivery.
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get the postal code for the delivery.
     *
     * @return string
     */
    public function getPostal(): string
    {
        return $this->postal;
    }

    public function getId(): ?string
    {
        return $this->address_id;
    }
}
