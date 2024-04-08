<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/public/css/home.css">
<script type="module" src="/public/scripts/home/buttons-scroll.js" defer></script>

<title>Chef Manuelle Webpage</title>
</head>

<body>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php echo $params[0]; ?>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
