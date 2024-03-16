<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/public/css/menu.css">
<script type="module" src="/public/scripts/menu/add-to-cart.js" defer></script>

<title>Menu page</title>
</head>

<body>
    <?php
    echo createHeader();
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
                                <form class="add-form">
                                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="min_servings" value="<?= $product['min_servings'] ?>">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" min="0" required>

                                    <button class="btn-primary">Add</button>
                                </form>
                            </footer>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
