<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/public/css/cart.css">
<script type="module" src="/public/scripts/cart/add-one.js" defer></script>
<script type="module" src="/public/scripts/cart/remove-from-cart.js" defer></script>
<script type="module" src="/public/scripts/cart/remove-one.js" defer></script>
<script type="module" src="/public/scripts/cart/create-order.js" defer></script>

<title>Menu page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <h1 id="page-title">Cart</h1>
        <div class="body-container">
            <?php include_once __DIR__ . '/includes/cart/left-container.php' ?>
            <?php include_once __DIR__ . '/includes/cart/right-container.php' ?>
        </div>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
