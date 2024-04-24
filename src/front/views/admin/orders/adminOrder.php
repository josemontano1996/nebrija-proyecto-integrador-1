<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>
<?php require_once ROOT_PATH . '/src/const/consts.php'; ?>
<link rel="stylesheet" href="/src/front/css/admin/order/adminOrder.css">

<?php echo generateSEOTags('Order', 'Order'); ?>
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

                <?php if ($order->getStatus() === 'cancelled' || $order->getStatus() === 'fulfilled') : ?>
                    <p>Order Status:<strong> <?= $order->getStatus() ?></strong></p>
                <?php else : ?>
                    <form class="change-status-form" action="/admin/order/status" method="POST">
                        <input type="hidden" name="orderid" value="<?= $order->getId() ?>">
                        <label for="status">Status:</label>
                        <select name="status" id="status" required>
                            <?php foreach (ORDER_STATUS as $status) : ?>
                                <option value="<?= $status ?>" <?= $order->getStatus() === $status ? 'selected' : ''; ?>><?= ucfirst($status) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button class="btn-primary change-button">Change</button>
                    </form>
                <?php endif; ?>

                <p>Order created in: <?= $order->getCreatedAt() ?></p>
                <p>Delivery Date: <?= $order->getDeliveryDate() ?></p>
                <p>Total Price: <?= $order->getTotalPrice(); ?> &euro;</p>
                <div class="divider"></div>
                <h5>Delivery Address</h5>
                <p>User: <?= $order->getUserName(); ?></p>
                <p>Street: <?= $order->getAddress()->getStreet(); ?></p>
                <p>Postal Code: <?= $order->getAddress()->getPostal(); ?></p>
                <p>City: <?= $order->getAddress()->getCity(); ?></p>
                <div id="footer-right-container">
                    <a href="/admin/orders" class="btn-secondary">Back to Orders</a>
                </div>
            </section>
        </div>

    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>