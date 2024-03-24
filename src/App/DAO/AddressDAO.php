<?php

namespace App\DAO;

use App\DB;
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
}
