<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>
<?php require_once ROOT_PATH . '/src/const/consts.php'; ?>
<link rel="stylesheet" href="/src/front/css/admin/order/adminOrders.css">

<title>Orders page</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../includes/shared-components.php'; ?>
    <?php
    $midHeader =  "<a href='/admin/orders'" . (!isset($_GET['status']) ? "class='italic bold underline'" : "") . ">All</a>";

    foreach (ORDER_STATUS as $status) {
        $element = "<a " . (isset($_GET['status']) && ($status === $_GET['status']) ? "class='italic bold underline'" : "") . " href=\"/admin/orders?status=$status\">" . ucfirst($status) . "</a>";

        $midHeader = $midHeader . $element;
    }
    echo createHeader($midHeader);
    ?>
    <main>
        <?php $orders = $params[0];
        $page = isset($params[1]) ? $params[1] : null; ?>
        <div class="heading">
            <h1>Your Orders</h1>
            <?php require_once __DIR__ . '/../../includes/admin/orders/page-selector.php'; ?>

        </div>

        <form action="/admin/order" method="GET">
            <label for="orderid">Order Id:</label>
            <input type="text" id="orderid" name="orderid" required>
            <button class="btn-primary">Search Order</button>
        </form>

        <ul id="orders-container">
            <?php foreach ($orders as $order) : ?>
                <li>
                    <h3>Order ID: <?= $order->getId() ?></h3>
                    <div class="flex">

                        <div>
                            <p>Order Status:<strong> <?= $order->getStatus() ?></strong></p>
                            <p>Order created in: <?= $order->getCreatedAt() ?></p>
                            <p>Delivery Date: <?= $order->getDeliveryDate() ?></p>
                            <p>Total Price: <?= $order->getTotalPrice(); ?> &euro;</p>

                        </div>
                        <div>
                            <h5>Delivery Address</h5>
                            <p>User: <?= $order->getUserName(); ?></p>
                            <p>Street: <?= $order->getAddress()->getStreet(); ?></p>
                            <p>Postal Code: <?= $order->getAddress()->getPostal(); ?></p>
                            <p>City: <?= $order->getAddress()->getCity(); ?></p>
                        </div>
                        <div>
                            <a class="btn-primary" href="/admin/order?orderid=<?= $order->getId(); ?>">More info</a>

                        </div>
                    </div>
                </li>
                <div class="divider"></div>
            <?php endforeach; ?>

        </ul>

    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>