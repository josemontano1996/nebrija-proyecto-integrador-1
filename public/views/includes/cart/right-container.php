<div id="rigth-container">
    <?php if (isset($_SESSION['user'])) : ?>
        <h2>Order summary</h2>
        <p>Total price: <span class="total-price"> <?= $params['totalPrice'] ?></span> &euro;</p>

        <form id="create-order-form">
            <h4>Delivery Data</h4>
            <div>
                <label for="street">Street</label>
                <input type="text" id="street" name="street" required>
            </div>
            <div>
                <label for="postal">Postal Code</label>
                <input type="text" id="postal" name="postal" required>
            </div>
            <div>
                <label for="city">City</label>
                <input type="text" id="city" name="city" required>
            </div>
            <div id="delivery-date">
                <label for="delivery_date">Delivery Date </label>
                <input type="datetime-local" id="delivery_date" name="delivery_date" min="<?= date('Y-m-d\TH:i'); ?>" required>
            </div>
            <button class="btn-primary">Place order</button>
        </form>
    <?php else : ?>
        <p>Please log in to proceed to create an order.</p>
        <a href="/login" class="btn-primary">To log in</a>
    <?php endif; ?>
</div>