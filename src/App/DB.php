<?php

declare(strict_types=1);

namespace App;

use mysqli;
use App\Exceptions\ErrorDbException;

/**
 * Class DB
 * 
 * Represents a database connection.
 */
class DB
{
    private static $instance;
    private mysqli $db;

    /**
     * DB constructor.
     * 
     * Creates a new database connection instance.
     * 
     * @throws ErrorDbException if the database connection fails.
     */
    private function __construct()
    {
        $this->db = new mysqli($_ENV['DB_HOST_URL'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_SCHEMA']);
        $this->db->set_charset("utf8");

        if (!isset($this->db)) {
            throw new ErrorDbException('Could not connect to the database');
        }
    }

    /**
     * Get the singleton instance of the database connection.
     * 
     * @return self The database connection instance.
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get the underlying mysqli object representing the database connection.
     * 
     * @return mysqli The mysqli object.
     */
    public function getDb(): mysqli
    {
        return $this->db;
    }
}
