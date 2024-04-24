<?php require_once __DIR__ . '/includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/home.css">
<script type="module" src="/src/front/scripts/home/buttons-scroll.js" defer></script>

<title>Chef Manuelle Webpage</title>
</head>

<body>
    <?php require_once __DIR__ . '/includes/shared-components.php'; ?>
    <?php
    echo createHeader();
    ?>
    <main>
        <?php echo $params[0]; ?>
    </main>
    <?php require_once __DIR__ . '/includes/footer.php';
