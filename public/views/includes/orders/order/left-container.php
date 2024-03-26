    <ul class="items-container">
        <?php foreach ($order->getProducts() as $product) : ?>
            <li class="item-li">
                <div>
                    <img src="<?= $product->getImageUrl() ?>" alt="<?= $product->getName() ?>">
                </div>

                <div>
                    <header>

                        <h2><?= $product->getName() ?></h2>


                        <p><?= $product->getDescription() ?></p>
                    </header>
                    <p>Price: <?= $product->getPrice() ?> &euro;</p>
                    <p>Quantity: <?= $product->getQuantity() ?></p>
                    <p>Subtotal: <span class="item-subtotal-price"><?= $product->getSubtotal()  ?> </span> &euro;</p>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>