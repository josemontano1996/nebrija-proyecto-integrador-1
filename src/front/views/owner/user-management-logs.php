<?php require_once __DIR__ . '/../includes/shared-head.php'; ?>
<link rel="stylesheet" href="/src/front/css/owner/logs/allLogs.css">


<?php echo generateSEOTags('User logs page', 'User logs page'); ?>
</head>

<body>
    <?php require_once __DIR__ . '/../includes/shared-components.php'; ?>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php $logs = $params[0]; ?>
        <?php $page = isset($params[1]) ? $params[1] : null; ?>
        <div class="heading">
            <h1 id="page-title">User Management Logs</h1>
            <?php require_once __DIR__ . '/../includes/owner/users-logs-page-selector.php'; ?>

            <form action="/owner/user/management/search" method="GET">
                <label for="email">User Email:</label>
                <input type="text" id="email" name="email" required>
                <button class="btn-primary">Search User</button>
            </form>

        </div>

        <section class="body-container">
            <table>
                <thead>
                    <tr>
                        <th>Owner Email</th>
                        <th>Owner Name</th>
                        <th>User Email</th>
                        <th>User Name</th>
                        <th>Previous Role</th>
                        <th>New Role</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log) : ?>
                        <tr>
                            <td><?= $log->getOwnerEmail() ?></td>
                            <td><?= $log->getOwnerName() ?></td>
                            <td><?= $log->getUserEmail() ?></td>
                            <td><?= $log->getUserName() ?></td>
                            <td><?= $log->getPreviousRole() ?></td>
                            <td><?= $log->getNewRole() ?></td>
                            <td><?= $log->getDate() ?></td>

                            <td class="user-info-a"><a class="btn-secondary" href="/owner/user/management/search?email=<?= urlencode($log->getUserEmail()); ?>">More info</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    </main>
    <?php require_once __DIR__ . '/../includes/footer.php';
