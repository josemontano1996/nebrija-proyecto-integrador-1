<?php

namespace App\DAO;

use App\DB;
use App\Models\Classes\AddressData;
use mysqli;
use Ramsey\Uuid\Uuid;

class AddressDAO
{
    private mysqli $db;

    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    public function insertAddressData(string $street, string $city, string $postal): ?string
    {
        $db = $this->db;

        $id = Uuid::uuid4();
        $street = $db->real_escape_string($street);
        $city = $db->real_escape_string($city);
        $postal = $db->real_escape_string($postal);


        $query = "INSERT INTO addresses (id, street, postal, city) VALUES (?, ?, ?, ?)";

        $statement = $db->prepare($query);

        if (!$statement) {
            return null;
        }

        $statement->bind_param('ssss', $id, $street, $postal, $city);

        $result = $statement->execute();

        $statement->close();

        if ($result) {
            return $id;
        } else {
            return null;
        }
    }

    public function deleteAddressData(string $addressId): bool
    {

        $db = $this->db;

        $query = "DELETE FROM addresses WHERE id = ?";

        $statement = $db->prepare($query);

        if (!$statement) {
            return false;
        }

        $statement->bind_param('s', $addressId);

        $result = $statement->execute();

        $statement->close();

        return $result;
    }

    public function getAddressesByIds(array $ids): ?array
    {
        $db = $this->db;

        // Implode the IDs without wrapping them
        $placeholders = implode("', '", $ids);

        $query = "SELECT * FROM addresses WHERE id IN ('$placeholders')";

        $result = $db->query($query);
        $addresses = $result->fetch_all(MYSQLI_ASSOC);

        if (count($addresses) === 0) {
            return null;
        }

        foreach ($addresses as $key => $address) {
            $addresses[$key] = new AddressData($address['street'], $address['city'], $address['postal'], $address['id']);
        }

        return $addresses;
    }
}
