<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/login.css">
<script src="/src/front/scripts/home/buttons-scroll.js" defer></script>

<title>Login page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>

        <?php if (isset($_GET['success'])) : ?>
            <div class="success-display"><?php echo $_GET['success'] ?></div>
        <?php endif; ?>

        <div id="forms">
            <section>
                <form class="form" id="login-form" method="POST" action="/login">
                    <h1>Log in</h1>
                    <div>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="example@example.com" required>
                    </div>
                    <div>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" minlength="8">
                    </div>

                    <button type="submit" class="btn-primary centered">Submit</button>

                </form>
            </section>


            <section>

                <form class="form" method="POST" action="/register">
                    <h1>Register</h1>
                    <div>
                        <label for="name">Name</label>
                        <input type="text" id="username" name="username" minlength="2" placeholder="Antonio" required>
                    </div>
                    <div>
                        <label for="email-2">Email</label>
                        <input type="email" id="email-2" name="email" placeholder="example@example.com" required>
                    </div>
                    <div>
                        <label for="password-2">Password</label>
                        <input type="password" id="password-2" name="password" minlength="8" required>
                    </div>
                    <div>
                        <label for="confirm-password">Confirm Passord</label>
                        <input type="password" id="confirm-password" name="confirm_password" minlength=" 8" required>
                    </div>

                    <button type="submit" class="btn-primary centered">Submit</button>

                </form>
            </section>


        </div>


        </form>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
