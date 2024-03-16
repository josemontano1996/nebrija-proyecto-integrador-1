<?php

namespace App\DAO;

use App\DB;
use mysqli;

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
     * Registers a new user in the database.
     *
     * @param string $username The username of the new user.
     * @param string $email The email of the new user.
     * @param string $password The password of the new user.
     * @return bool True if the user was successfully registered, false otherwise.
     */
    public function registerUser(string $username, string $email, string $password): bool
    {

        $db = $this->db;

        // Prepare the SQL query with placeholders
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

        // Prepare the statement
        $statement = $db->prepare($query);
        if (!$statement) {
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Bind the parameters
        $statement->bind_param('sss', $username, $email, $hashedPassword);

        // Execute the statement
        $result = $statement->execute();

        // Close the statement
        $statement->close();


        return $result;
    }
}
