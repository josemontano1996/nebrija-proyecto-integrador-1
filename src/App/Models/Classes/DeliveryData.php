<?php

declare(strict_types=1);

namespace App\Models\Classes;


/**
 * The DeliveryData class is an Classes class that represents delivery data.
 */
class DeliveryData
{
    /**
     * @var string $user_id The user ID associated with the delivery data.
     * @var string $street The street address for the delivery.
     * @var string $city The city for the delivery.
     * @var string $postal The postal code for the delivery.
     * @var string $phone The phone number for the delivery.
     */
    public function __construct(protected string $user_id, protected string $street, protected string $city, protected string $postal, protected string $phone)
    {
        $this->user_id = $user_id;
        $this->street = $street;
        $this->city = $city;
        $this->postal = $postal;
        $this->phone = $phone;
    }
}
