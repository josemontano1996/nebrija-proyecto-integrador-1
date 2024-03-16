<?php if (isset($_SESSION['error'])) : ?>

    <div class="error-popup">
        <div class="error-popup-content">
            <h2>Oops! Something went wrong</h2>

            <p><?= $_SESSION['error'] ?></p>

            <button class="btn-primary" id="close-button">Close</button>
        </div>
    </div>

    <script defer>
        const closeButton = document.querySelector('.error-popup #close-button');

        closeButton.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('.error-popup').style.display = 'none';
        })
    </script>

    <?php unset($_SESSION['error']) ?>

<?php endif; ?>