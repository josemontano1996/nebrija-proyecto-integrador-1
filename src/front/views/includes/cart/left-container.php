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