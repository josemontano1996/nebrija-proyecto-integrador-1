<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/admin/admin-menu.css">
<script defer src="/src/front/scripts/admin/delete-product.js"></script>

<?php echo generateSEOTags('Admin Menu', 'Admin Menu'); ?>
</head>

<body>
    <?php require_once __DIR__ . '/../../includes/shared-components.php'; ?>
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
                        <li class="menu-list-item" id="<?= $product->getId() ?>">
                            <header>
                                <h3><?= ucfirst($product->getName()) ?></h3>
                                <img src=" <?= $product->getImageUrl() ?>" loading="lazy" alt=<?= $product->getImageUrl() ?>>
                                <p><?= ucfirst($product->getDescription()) ?></p>
                            </header>
                            <footer>

                                <p>Price: <span class="price-tag"><?= $product->getPrice() ?> &euro;</span></p>
                                <?php if ($product->getMinServings() > 0) : ?>
                                    <p>Minimum servings: <?= $product->getMinServings() ?></p>
                                <?php endif; ?>
                                <div class="action-buttons">
                                    <a href="/admin/product/update?productId=<?= $product->getId() ?>" class="btn-secondary">Edit</a>
                                    <button id="delete-button" data-productid="<?= $product->getId() ?>" data-imageurl="<?= $product->getImageUrl() ?>" class="btn-primary">Delete</button>
                                </div>
                            </footer>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php';
