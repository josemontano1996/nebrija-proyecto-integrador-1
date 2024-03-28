<?php require_once __DIR__ . '/../includes/shared-head.php'; ?>
<link rel="stylesheet" href="/public/css/owner/users/allUsers.css">


<title>Menu page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php $users = $params[0]; ?>
        <?php $page = isset($params[1]) ? $params[1] : null; ?>
        <div class="heading">
            <h1 id="page-title">User management</h1>
            <?php require_once __DIR__ . '/../includes/owner/user-page-selector.php'; ?>

            <form action="user/search" method="GET">
               <label for="email">User Email:</label>
               <input type="text" id="email" name ="email" required>
               <button class="btn-primary">Search User</button>
            </form>

        </div>

        <section class="body-container">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>User ID</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getName() ?></td>
                            <td><?= $user->getId() ?></td>
                            <td class="<?= $user->getRole() === 'owner' ? 'owner' : ($user->getRole() === 'admin' ? 'admin' : '') ?>"><?= $user->getRole() ?></td>

                            <td class="user-info-a"><a class="btn-secondary" href="/owner/user/search?email=<?= $user->getEmail(); ?>">More info</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    </main>
    <?php require_once __DIR__ . '/../includes/footer.php';
