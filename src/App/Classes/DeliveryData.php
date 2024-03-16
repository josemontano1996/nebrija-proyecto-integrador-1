<?php

namespace App\Classes;

/**
 * The DeliveryData class is an abstract class that represents delivery data.
 */
abstract class DeliveryData
{
    /**
     * The user ID.
     *
     * @var string
     */
    protected string $user_id;

    /**
     * The street address.
     *
     * @var string
     */
    protected string $street;

    /**
     * The city.
     *
     * @var string
     */
    protected string $city;

    /**
     * The postal code.
     *
     * @var string
     */
    protected string $postal;

    /**
     * The phone number.
     *
     * @var string
     */
    protected string $phone;

    /**
     * Create a new DeliveryData instance.
     *
     * @param string $user_id The user ID.
     * @param string $street The street address.
     * @param string $city The city.
     * @param string $postal The postal code.
     * @param string $phone The phone number.
     */
    protected function __construct(string $user_id, string $street, string $city, string $postal, string $phone)
    {
        $this->user_id = $user_id;
        $this->street = $street;
        $this->city = $city;
        $this->postal = $postal;
        $this->phone = $phone;
    }
}
