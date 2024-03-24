<?php

declare(strict_types=1);

namespace App\DAO;

use mysqli;
use App\DB;
use App\Models\Classes\CartCookieItem;

/**
 * The CartDAO class provides methods to interact with the carts table in the database.
 */
class CartDAO
{
    private mysqli $db;

    /**
     * Constructs a new CartDAO instance.
     */
    public function __construct()
    {
        $dbInstance = DB::getInstance();
        $this->db = $dbInstance->getDb();
    }

    /**
     * Retrieves the cart for a given user ID.
     *
     * @param string $user_id The ID of the user.
     * @return array<CartCookieItem>|null The cart data as an associative array, or null if no cart is found.
     */
    public function getCart(string $user_id): ?array
    {
        $db = $this->db;

        // Prepare the statement with a placeholder
        $sql = "SELECT * FROM carts WHERE user_id = ?";

        $stmt = $db->prepare($sql);

        // Bind the user ID parameter securely
        $stmt->bind_param('s', $user_id);

        // Execute the statement
        $stmt->execute();

        // Get the result (if any)
        $result = $stmt->get_result();

        // Check if a cart was found
        if ($result->num_rows === 0) {
            $stmt->close();
            return null;
        }

        // Fetch the cart data as associative array
        $cart = $result->fetch_assoc();

        // Close the statement
        $stmt->close();

        // Decode the products JSON (if present)
        return isset($cart['products']) ? json_decode($cart['products'], true) : null;
    }

    /**
     * Updates the cart for a given user ID with the provided products.
     *
     * @param string $user_id The ID of the user.
     * @param array<CartCookieItem> $products The products to be updated in the cart.
     * @return bool True if the cart was successfully updated, false otherwise.
     */
    public function updateCart(string $user_id, array $products): bool
    {
        $db = $this->db;

        $products = json_encode($products);

        // Prepare the statement with placeholders
        $sql = "INSERT INTO carts (user_id, products) VALUES (?, ?) ON DUPLICATE KEY UPDATE products = ?";

        $stmt = $db->prepare($sql);

        // Bind the parameters securely
        $stmt->bind_param('sss', $user_id, $products, $products);

        // Execute the statement
        $stmt->execute();

        // Check for success (insertion or update)
        $updated = $stmt->affected_rows > 0;

        // Close the statement
        $stmt->close();

        return $updated;
    }

    /**
     * Deletes the cart for a given user ID.
     *
     * @param string $user_id The ID of the user.
     * @return bool True if the cart was successfully deleted, false otherwise.
     */
    public function deleteCart(string $user_id): bool
    {
        $db = $this->db;

        // Prepare the statement with placeholder
        $sql = "DELETE FROM carts WHERE id = ?";

        $stmt = $db->prepare($sql);

        // Bind the user ID parameter securely
        $stmt->bind_param('s', $user_id);

        // Execute the statement
        $stmt->execute();

        // Check if any rows were affected (deleted)
        $deleted = $stmt->affected_rows > 0;

        // Close the statement 
        $stmt->close();

        return $deleted;
    }
}
