<?php

use App\Models\ProductModel as Product;

/**
 * Creates an array of product seed data.
 *
 * @return array The array of product seed data.
 */
function createProductSeedArray(): array
{
    $products[] = new Product('Bruscetta', 'Toasted bread slices topped with diced tomatoes, garlic, fresh basil, and drizzled with olive oil.', 5.99, 'appetizer', '/public/assets/storage/demo-bruscetta.webp');
    $products[] = new Product('Bacon Roll', 'A delicious roll stuffed with crispy bacon, lettuce, and tomatoes.', 1, 'appetizer', '/public/assets/storage/demo-bacon-roll.webp', 8);
    $products[] = new Product('Caprese Salad', 'A classic Italian salad made with fresh tomatoes, mozzarella cheese, basil leaves, and balsamic glaze.', 8.99, 'appetizer', '/public/assets/storage/demo-caprese.webp');

    $products[] = new Product('Cheesecake', 'A rich and creamy dessert made with a buttery graham cracker crust and topped with a decadent cream cheese filling.', 9.99, 'dessert', '/public/assets/storage/demo-cheese-cake.webp');

    $products[] = new Product('Chicken Parmesan', 'Crispy breaded chicken breast topped with marinara sauce and melted mozzarella cheese, served with spaghetti.', 12.99, 'main', '/public/assets/storage/demo-chicken-parmesan.webp');

    $products[] = new Product('Coca-Cola 50cL', 'A refreshing cola drink made with carbonated water, high fructose corn syrup, caramel color, phosphoric acid, natural flavors, and caffeine.', 2.49, 'drink', '/public/assets/storage/demo-coca-cola.webp');

    $products[] = new Product('Filet Mignon', 'A tender and juicy steak cut from the beef tenderloin, known for its exceptional tenderness and flavor.', 24.99, 'main', '/public/assets/storage/demo-filet-mignon.webp');

    $products[] = new Product('Garlic Shrimp', 'Fresh shrimp cooked in garlic, butter, and white wine, served with a side of rice or pasta.', 18.99, 'main', '/public/assets/storage/demo-garlic-shrimp.webp');

    $products[] = new Product('Lobster Thermidor', 'A classic French dish made with cooked lobster meat in a creamy mixture of egg yolks, brandy, and mustard, topped with breadcrumbs and cheese.', 29.99, 'main', '/public/assets/storage/demo-lobster-thermidor.webp');

    $products[] = new Product('Salmon with Dill Sauce', 'Grilled salmon served with a creamy dill sauce, garnished with fresh dill and lemon wedges.', 22.99, 'main', '/public/assets/storage/demo-salmon-dill.webp');

    $products[] = new Product('Tiramisu', 'A classic Italian dessert made with layers of coffee-soaked ladyfingers, mascarpone cheese, and cocoa powder.', 7.99, 'dessert', '/public/assets/storage/demo-tiramisu.webp');

    $products[] = new Product('Vermouth', 'Aromatic fortified wine infused with herbs, spices, and roots.', 7.99, 'drink', '/public/assets/storage/demo-vermouth.webp');
    $products[] = new Product('Vegetable Stir Fry', 'A delicious stir-fried dish made with a variety of fresh vegetables, seasoned with soy sauce, garlic, and ginger.', 13.99, 'entree', '/public/assets/storage/demo-vegetable-stir-fry.webp');

    return $products;
}
