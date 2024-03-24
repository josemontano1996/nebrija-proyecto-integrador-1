<?php

namespace App\Models;

use App\DAO\AddressDAO;
use App\Models\Classes\AddressData;

class AddressModel extends AddressData
{
    public function __construct(
        string $street,
        string $city,
        string $postal,
    ) {
        parent::__construct($street, $city, $postal);
    }

    public function saveAddressData(): string
    {

        $addressDAO = new AddressDAO();
        $addressId = $addressDAO->insertAddressData($this->street, $this->city, $this->postal);

        return $addressId;
    }
}
