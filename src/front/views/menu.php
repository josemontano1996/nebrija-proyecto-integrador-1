<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/menu.css">
<script type="module" src="/src/front/scripts/menu/add-to-cart.js" defer></script>
<script type="module" src="/src/front/scripts/menu/button-scroll-menu-page.js" defer></script>
<script type="module" src="/src/front/scripts/menu/x-draggable-container.js" defer></script>

<title>Menu page</title>
</head>

<body>
    <?php
    $midHeader = '<li class="italic"><a id="menu-scroll">The Menu</a></li>';
    echo createHeader($midHeader);
    ?>
    <main>
        <header id='menu-page-header'>
            <div>
                <div id='text-content'>
                    <h1>You are what you eat, so</h1>
                    <h2>Don't be Fast, Cheap, Easy or Fake</h2>
                </div>
                <div>
                    <img src="/src/front/assets/imgs/menu-header.webp" alt="header image">
                </div>
            </div>
        </header>
        <section id='advantages-section'>
            <h2>Satisfaction Guaranteed</h2>
            <ul>
                <li>
                    <img src="/src/front/assets/icons/chef-hat.png" alt="chef hat">
                    <h4>Experience</h4>
                    <p>Over 30 years professional experience as a Chef</p>
                </li>
                <li>
                    <img src="/src/front/assets/icons/cooking-pot.png" alt="cooking pot">
                    <h4>Eat slow, cook slow</h4>
                    <p>Enjoy the best slow cooked traditional food</p>
                </li>
                <li>
                    <img src="/src/front/assets/icons/badge-check.png" alt="badge check">
                    <h4>Eat fresh</h4>
                    <p>We only use the best quality fresh ingredients</p>
                </li>
                <li id='4th-li'>
                    <img src="/src/front/assets/icons/map-pinned.png" alt="local icon">
                    <h4>Support local produce</h4>
                    <p>We only supply from the best local producer</p>
                </li>
            </ul>
        </section>
        <div class='divider' style='margin-top: 6rem' ;></div>
        <section id="menu">
            <?php foreach ($params as $type => $categoryProducts) : ?>
                <div class="menu-section">
                    <h2><?= ucfirst($type) ?></h2>
                    <ul class="menu-list dragable">
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
                                        <input class='quantity-input' type="number" id="quantity" name="quantity" min="0" required>

                                        <button class="btn-primary">Add</button>
                                    </form>
                                </footer>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
