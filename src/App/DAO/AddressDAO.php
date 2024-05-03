<?php

namespace App\DAO;

use App\DB;
use App\Models\Classes\AddressData;
use mysqli;
use Ramsey\Uuid\Uuid;

/**
 * The AddressDAO class is responsible for interacting with the addresses table in the database.
 */
class AddressDAO
{
    private mysqli $db;

    /**
     * Constructs a new AddressDAO instance.
     */
    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    /**
     * Inserts address data into the addresses table.
     *
     * @param string $street The street address.
     * @param string $city The city.
     * @param string $postal The postal code.
     * @return string|null The ID of the inserted address data, or null if the insertion failed.
     */
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

        $address_id = $result ? $id : null;

        return $address_id;
    }

    /**
     * Deletes address data from the addresses table.
     *
     * @param string $addressId The ID of the address data to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
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

    /**
     * Retrieves address data from the addresses table based on the given IDs.
     *
     * @param array $ids An array of address IDs.
     * @return array|null An array of AddressData objects representing the retrieved address data, or null if no addresses were found.
     */
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
