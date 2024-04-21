<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/admin/admin-menu.css">
<script defer src="/src/front/scripts/admin/delete-product.js"></script>

<title>Manage Menu</title>
</head>

<body>
    <?php
    $midHeader = '<li class="btn-primary"><a href="/admin/product/new">New Dish</a></li>';
    echo createHeader($midHeader);
    ?>
    <main>
        <?php foreach ($params as $type => $categoryProducts) : ?>
            <section class="menu-section">
                <h2><?= ucfirst($type) ?></h2>
                <ul class="menu-list">
                    <?php foreach ($categoryProducts as $product) : ?>
                        <li class="menu-list-item" id="<?= $product['id'] ?>">
                            <header>
                                <h3><?= ucfirst($product['name']) ?></h3>
                                <img src=" <?= $product['image_url'] ?>" loading="lazy" alt="guacamole">
                                <p><?= ucfirst($product['description']) ?></p>
                            </header>
                            <footer>

                                <p>Price: <span class="price-tag"><?= $product['price'] ?> &euro;</span></p>
                                <?php if ($product['min_servings'] > 0) : ?>
                                    <p>Minimum servings: <?= $product['min_servings'] ?></p>
                                <?php endif; ?>
                                <div class="action-buttons">
                                    <a href="/admin/product/update?productId=<?= $product['id'] ?>" class="btn-secondary">Edit</a>
                                    <button id="delete-button" data-productid="<?= $product['id'] ?>" data-imageurl="<?= $product['image_url'] ?>" class="btn-primary">Delete</button>
                                </div>
                            </footer>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php';
