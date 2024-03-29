<?php

namespace App\Seed;

require_once __DIR__ . '/seed-data.php';

use App\DB;
use Ramsey\Uuid\Uuid;

class SeedController
{
    /**
     * Seeds the database with products and users.
     */
    public function seedDatabase()
    {

        $products = createProductSeedArray();

        try {

            $dbInstace = DB::getInstance();
            $db = $dbInstace->getDb();

            seedProductsTable($products, $db);

            seedUsersTable($db);


            $db->close();

            $_SESSION['success'] = 'Database seeded successfully!';
            header('Location: /menu');
            exit();
        } catch (\Exception $e) {
            $_SESSION['error'] = 'Error: ' . $e->getMessage();
            header('Location: /');
            exit();
        }
    }
}

/**
 * Seeds the users table in the database.
 *
 * @param $db The database connection.
 */
function seedUsersTable($db)
{
      // Common password for all users
    $password = password_hash('12345678', PASSWORD_BCRYPT, ['cost' => 12]);

    // Define user data
    $owner = ['email' => 'owner@owner.com', 'password' => $password, 'name' => 'Owner name', 'role' => 'owner'];
    $admin = ['email' => 'admin@admin.com', 'password' => $password, 'name' => 'Admin name', 'role' => 'admin'];
    $user = ['email' => 'user@user.com', 'password' => $password, 'name' => 'User name'];

    // Generate UUID for each user
    $owner_id = Uuid::uuid4()->toString();
    $admin_id = Uuid::uuid4()->toString();
    $user_id = Uuid::uuid4()->toString();

    // Construct and execute queries
    $db->query("INSERT INTO users (id, name, email, password, role) VALUES ('$owner_id', '{$owner['name']}', '{$owner['email']}', '{$owner['password']}', '{$owner['role']}')");
    $db->query("INSERT INTO users (id, name, email, password, role) VALUES ('$admin_id', '{$admin['name']}', '{$admin['email']}', '{$admin['password']}', '{$admin['role']}')");
    $db->query("INSERT INTO users (id, name, email, password) VALUES ('$user_id', '{$user['name']}', '{$user['email']}', '{$user['password']}')");
}


/**
 * Seeds the products table in the database.
 *
 * @param $products The array of products to be seeded.
 * @param $db The database connection.
 */
function seedProductsTable($products, $db)
{

    $name = null;
    $description = null;
    $min_servings = null;
    $price = null;
    $type = null;
    $image_url = null;

    for ($i = 0; $i < count($products); $i++) {
        $p = $products[$i]->getAllData();
        $id = Uuid::uuid4();
        $name = $p['name'];
        $description = $p['description'];
        $min_servings = $p['min_servings'];
        $price = $p['price'];
        $type = $p['type'];
        $image_url = $p['image_url'];

        $sql = "INSERT INTO products (id, name, description, min_servings, price, type, image_url) VALUES ('$id','$name', '$description', $min_servings, $price, '$type', '$image_url')";

        $db->query($sql);
    }
}
