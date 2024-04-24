<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>
<?php require_once ROOT_PATH . '/src/const/consts.php'; ?>
<link rel="stylesheet" href="/src/front/css/orders/order.css">

<title>Orders page</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../includes/shared-components.php'; ?>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php $order = $params[0]; ?>
        <div class="page-header">
            <h1>Your Order</h1>
            <h2>
                ID: <?= $order->getId() ?>
            </h2>
        </div>
        <div class="body-container">

            <?php require_once __DIR__ . '/../../includes/orders/order/left-container.php'; ?>


            <section id="right-container">
                <h3>Order summary</h3>
                <div class="divider"></div>
                <p>Order Status:<strong> <?= $order->getStatus() ?></strong></p>
                <p>Order created in: <?= $order->getCreatedAt() ?></p>
                <p>Delivery Date: <?= $order->getDeliveryDate() ?></p>
                <p>Total Price: <?= $order->getTotalPrice(); ?> &euro;</p>
                <div class="divider"></div>
                <h5>Delivery Address</h5>
                <p>Street: <?= $order->getAddress()->getStreet(); ?></p>
                <p>Postal Code: <?= $order->getAddress()->getPostal(); ?></p>
                <p>City: <?= $order->getAddress()->getCity(); ?></p>
                <div id="footer-right-container">
                    <a href="/user/orders" class="btn-secondary">Back to Orders</a>
                    <?php if ($order->getStatus() === 'pending') : ?>
                        <a href="/user/order/cancel?orderid=<?= $order->getId() ?>" class="btn-error">Cancel Order</a>
                    <?php endif; ?>
                </div>
            </section>
        </div>

    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>