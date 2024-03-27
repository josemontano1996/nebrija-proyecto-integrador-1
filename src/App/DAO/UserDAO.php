<?php

declare(strict_types=1);

namespace App\DAO;

use App\DB;
use mysqli;
use Ramsey\Uuid\Uuid;

class UserDAO
{
    private mysqli $db;

    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    /**
     * Retrieves a user from the database by email.
     *
     * @param string $email The email of the user to retrieve.
     * @return array|null The user data as an associative array, or null if no user is found.
     */
    public function getUserByEmail(string $email): ?array
    {

        $db = $this->db;

        // Sanitize the email input
        $email = $db->real_escape_string($email);

        // Construct the query using a prepared statement
        $query = "SELECT * FROM users WHERE email = ?";
        $statement = $db->prepare($query);

        // Bind parameters and execute the query
        $statement->bind_param('s', $email);
        $statement->execute();

        // Get the result
        $result = $statement->get_result();

        // Check if any rows were returned
        if ($result->num_rows === 0) {
            return null; // No user found
        }

        // Fetch the user data
        $user = $result->fetch_assoc();

        // Close the result set and statement
        $result->close();
        $statement->close();

        return $user;
    }

    /**
     * Retrieves a user from the database by user ID.
     *
     * @param string $user_id The ID of the user to retrieve.
     * @return array|null The user data as an associative array, or null if no user is found.
     */
    public function getUserById(string $user_id): ?array
    {

        $db = $this->db;

        // Sanitize the user_id input
        $user_id = $db->real_escape_string($user_id);

        // Construct the query using a prepared statement
        $query = "SELECT * FROM users WHERE id = ?";
        $statement = $db->prepare($query);

        // Bind parameters and execute the query
        $statement->bind_param('s', $user_id);
        $statement->execute();

        // Get the result
        $result = $statement->get_result();

        // Check if any rows were returned
        if ($result->num_rows === 0) {
            return null; // No user found
        }

        // Fetch the user data
        $user = $result->fetch_assoc();

        // Close the result set and statement
        $result->close();
        $statement->close();

        return $user;
    }

    /**
     * Registers a new user in the database.
     *
     * @param string $name The name of the new user.
     * @param string $email The email of the new user.
     * @param string $password The password of the new user.
     * @return bool True if the user was successfully registered, false otherwise.
     */
    public function registerUser(string $name, string $email, string $password): bool
    {

        $db = $this->db;

        $id = Uuid::uuid4();
        // Prepare the SQL query with placeholders
        $query = "INSERT INTO users (id, name, email, password) VALUES (? , ?, ?, ?)";

        // Prepare the statement
        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Bind the parameters
        $statement->bind_param('ssss', $id, $name, $email, $hashedPassword);

        // Execute the statement
        $result = $statement->execute();

        // Close the statement
        $statement->close();

        return $result;
    }

    /**
     * Updates an existing user in the database.
     *
     * @param string $user_id The ID of the user to update.
     * @param string $name The new name of the user.
     * @param string $email The new email of the user.
     * @param string|null $password The new password of the user, or null to keep the existing password.
     * @return bool True if the user was successfully updated, false otherwise.
     */
    public function updateUser(string $user_id, string $name, string $email, ?string $password): bool
    {

        $db = $this->db;

        // Prepare the SQL query with placeholders
        $query = "UPDATE users SET name = ?, email = ?";

        // Check if the password is set
        if (isset($password)) {
            $query .= ", password = ?";
        }

        $query .= " WHERE id = ?";

        // Prepare the statement
        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        // Hash the password
        if (isset($password)) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
            // Bind the parameters
            $statement->bind_param('ssss', $name, $email, $hashedPassword, $user_id);
        } else {
            // Bind the parameters
            $statement->bind_param('sss', $name, $email, $user_id);
        }

        // Execute the statement
        $result = $statement->execute();

        // Close the statement
        $statement->close();

        return $result;
    }
}
