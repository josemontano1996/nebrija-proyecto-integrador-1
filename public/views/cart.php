<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/public/css/cart.css">
<script type="module" src="/public/scripts/cart/add-one.js" defer></script>
<script type="module" src="/public/scripts/cart/remove-from-cart.js" defer></script>
<script type="module" src="/public/scripts/cart/remove-one.js" defer></script>

<title>Menu page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <h1 id="page-title">Cart</h1>
        <div class="body-container">
            <ul class="cart-container">
                <?php foreach ($params['products'] as $cartItem) : ?>
                    <li class="cart-item-li">
                        <div>
                            <img src="<?= $cartItem->getImageUrl() ?>" alt="<?= $cartItem->getName() ?>">
                        </div>

                        <div>
                            <header>
                                <div>
                                    <h2><?= $cartItem->getName() ?></h2>
                                    <span class="remove-button" data-productid="<?= $cartItem->getId() ?>">remove</span>
                                </div>
                                <p><?= $cartItem->getDescription() ?></p>
                            </header>
                            <p>Price: <?= $cartItem->getPrice() ?> &euro;</p>
                            <?php $minServings = $cartItem->getMinServings();
                            if (isset($minServings) && $minServings > 0) : ?>
                                <p>Min quantity: <?= $cartItem->getMinServings() ?> </p>
                            <?php endif; ?>
                            <p>Quantity: <span class="quantity-modifier-container">

                                    <button class="reduce-button" data-productid="<?= $cartItem->getId() ?>" data-minservings="<?= $cartItem->getMinServings() ?>" data-productprice=" <?= $cartItem->getPrice() ?>">-</button>

                                    <span class="quantity-span"><?= $cartItem->getQuantity() ?></span>

                                    <button class="add-button" data-productid="<?= $cartItem->getId() ?>" data-productprice="<?= $cartItem->getPrice() ?>">+</button>
                                </span></p>
                            <p>Subtotal: <span class="item-subtotal-price"><?= $cartItem->getSubtotal()  ?> </span> &euro;</p>
                        </div>
                    </li>

                <?php endforeach; ?>

            </ul>
            <div id="rigth-container">
                <p>Total price: <span class="total-price"> <?= $params['totalPrice'] ?></span> &euro;</p>
                <a href="/user/checkout" class="btn-primary">Proceed to Checkout</a>
            </div>
        </div>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
