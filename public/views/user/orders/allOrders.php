<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>
<?php require_once ROOT_PATH . '/src/const/consts.php'; ?>
<link rel="stylesheet" href="/public/css/orders/orders.css">

<title>Orders page</title>
</head>

<body>
    <?php
    $midHeader =  '<a href="/user/orders" class="italic bold">All</a>';

    foreach (ORDER_STATUS as $status) {
        $element = "<a " . (isset($_GET['status']) && ($status === $_GET['status']) ? "class='italic bold'" : "") . " href=\"/user/orders?status=$status\">" . ucfirst($status) . "</a>";

        $midHeader = $midHeader . $element;
    }
    echo createHeader($midHeader);
    ?>
    <main>
        <h1>Your Orders</h1>
        <div>


        </div>
        <ul id="orders-container">
            <?php foreach ($params[0] as $order) : ?>
                <li>
                    <h3>Order ID: <?= $order['id'] ?></h3>
                    <div class="flex">

                        <div>
                            <p>Order Status:<strong> <?= $order['status'] ?></strong></p>
                            <p>Order created in: <?= $order['created_at'] ?></p>
                            <p>Delivery Date: <?= $order['delivery_date'] ?></p>
                            <p>Total Price: <?= $order['total_price'] ?> &euro;</p>

                        </div>
                        <div>
                            <h5>Delivery Address</h5>
                            <p>Street: <?= $order['street'] ?></p>
                            <p>Postal Code: <?= $order['postal'] ?></p>
                            <p>City: <?= $order['city'] ?></p>
                        </div>
                        <div>
                            <a class="btn-primary" href="/users/order?orderid=<?= $order['id'] ?>">More info</a>

                        </div>
                    </div>
                </li>
                <div class="divider"></div>
            <?php endforeach; ?>

        </ul>

    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php'; ?>
</body>