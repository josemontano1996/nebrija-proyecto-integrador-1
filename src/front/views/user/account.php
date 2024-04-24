<?php require_once __DIR__ . '/../includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/user/account.css">
<script src="/src/front/scripts/home/buttons-scroll.js" defer></script>

<?php echo generateSEOTags('Account page', 'Account page'); ?>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/shared-components.php'; ?>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php $user = $params[0]; ?>
        <?php if (isset($_GET['success'])) : ?>
            <div class="success-display"><?php echo $_GET['success'] ?></div>
        <?php endif; ?>
        <h1>Your Account Data</h1>
        <div id="forms">
            <section>
                <form class="form" method="POST" action="/user/account">
                    <h1>Update Data </h1>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="username" name="username" minlength="2" value="<?= $user->getName() ?>" required>
                    </div>
                    <div>
                        <label for="email-2">Email</label>
                        <input type="email" id="email-2" name="email" value="<?= $user->getEmail() ?>" required>
                    </div>
                    <div class="divider"></div>
                    <h4>Update password &lpar; optional &rpar;</h4>

                    <div>
                        <label for="password-2">Password</label>
                        <input type="password" id="password-2" name="password" minlength="8">
                    </div>
                    <div>
                        <label for="confirm-password">Confirm Passord</label>
                        <input type="password" id="confirm-password" name="confirm_password" minlength=" 8">
                    </div>

                    <button type="submit" class="btn-primary centered">Update</button>

                </form>
            </section>


        </div>


        </form>
    </main>
    <?php require_once __DIR__ . '/../includes/footer.php';
