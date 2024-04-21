<?php require_once __DIR__ . '/../includes/shared-head.php'; ?>
<?php require_once __DIR__ . '/../../../src/const/consts.php'; ?>
<link rel="stylesheet" href="/src/front/css/owner/users/user.css">


<title>Menu page</title>
</head>

<body>
    <?php
    $midHeader = "<li><a class='btn-secondary' href='/owner/users'>Back to Users</a></li>";
    echo createHeader($midHeader);
    ?>
    <main>
        <?php $user = $params[0]; ?>

        <section class="body-container">
            <h2>User information</h2>
            <p>Email: <?= $user->getEmail(); ?></p>
            <p>Name: <?= $user->getName(); ?></p>
            <p>User ID: <?= $user->getId(); ?></p>
            <form action="/owner/user/role" method="POST">
                <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">
                <input type="hidden" name="email" value="<?= $user->getEmail(); ?>">
                <label for="role">Role: </label>
                <select name="role" id="role">
                    <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="owner" <?= $user->getRole() === 'owner' ? 'selected' : '' ?>>Owner</option>
                    <option value="" <?= !$user->getRole() ? 'selected' : '' ?>>None</option>
                </select>
                <button type="submit" class="btn-primary">Update role</button>
            </form>

        </section>
    </main>
    <?php require_once __DIR__ . '/../includes/footer.php';
