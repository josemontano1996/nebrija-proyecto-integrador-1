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

    public function deleteAddressData(string $addressId): bool
    {
        $addressDAO = new AddressDAO();
        $result = $addressDAO->deleteAddressData($addressId);

        return $result;
    }

    static public function getAddressesByIds(array $addressesIds): ?array
    {
        $addressDAO = new AddressDAO();
        $addresses = $addressDAO->getAddressesByIds($addressesIds);

        return $addresses;
    }
}
