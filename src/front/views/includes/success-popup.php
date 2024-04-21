<?php if (isset($_SESSION['success'])) : ?>

    <div class="success-popup">
        <div class="success-popup-content">
            <h2>Success</h2>

            <p><?= $_SESSION['success'] ?></p>

            <button class="btn-primary" id="close-button">Close</button>
        </div>
    </div>

    <script defer>
        const closeButton = document.querySelector('.success-popup #close-button');

        closeButton.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.success-popup').style.display = 'none';
        })
    </script>

    <?php unset($_SESSION['success']) ?>

<?php endif; ?>