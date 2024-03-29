<?php require_once __DIR__ . '/../includes/shared-head.php'; ?>
<link rel="stylesheet" href="/public/css/owner/logs/user-logs.css">


<title>Menu page</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php $logs = $params[0]; ?>
        <?php $email = $params[1] ?>
        <div class="heading">
            <h1 id="page-title">User: <?= $email ?> logs</h1>
            <div class="page-selector">
                <a href="/owner/user/management" class="btn-primary">Back All Logs</a>
                <a href="/owner/users" class="btn-primary">User Management</a>
            </div>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    </main>
    <?php require_once __DIR__ . '/../includes/footer.php';
