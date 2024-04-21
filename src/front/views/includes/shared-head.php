<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/src/front/assets/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/src/front/css/normalization.css">
    <link rel="stylesheet" href="/src/front/css/header.css">
    <link rel="stylesheet" href="/src/front/css/components.css">
    <link rel="stylesheet" href="/src/front/css/footer.css">
    <link rel="stylesheet" href="/src/front/css/side-menu.css">
    <script src="/src/front/scripts/side-menu-toggle.js" defer></script>

    <!-- The requires come here, they will be appended to the body by PHP -->
    <?php require_once ROOT_PATH . '/src/front/components/headerComponent.php'; ?>
    <?php require_once __DIR__ . '/side-menu.php'; ?>
    <?php require_once __DIR__ . '/success-popup.php'; ?>
    <?php require_once __DIR__ . '/error-popup.php'; ?>