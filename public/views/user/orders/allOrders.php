<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>
<title>Orders page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <ul class="cart-container">
            <?php foreach ($params[0] as $order) : ?>
                <li>
                    <h2>Order ID: <?= $order['id'] ?></h2>
                    <p>Order Status: <?= $order['status'] ?></p>
                    <div>
                        <h5>Delivery Address:</h5>
                        <p>Street: <?= $order['street'] ?></p>
                        <p>Postal Code: <?= $order['postal'] ?></p>
                        <p>City: <?= $order['city'] ?></p>
                    </div>
                    <p>Order created in: <?= $order['createdAt'] ?></p>
                    <p>Delivery Date: <?= $order['delivery_date'] ?></p>
                    <p>Total Price: <?= $order['total_price'] ?></p>
                    <a class="btn-primary" href="/users/order?orderid=<?= $order['id'] ?>">More info</a>
                </li>
            <?php endforeach; ?>

        </ul>

    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>