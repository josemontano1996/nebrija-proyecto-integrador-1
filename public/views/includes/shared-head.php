<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/assets/icons/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/public/css/normalization.css">
    <link rel="stylesheet" href="/public/css/header.css">
    <link rel="stylesheet" href="/public/css/components.css">
    <link rel="stylesheet" href="/public/css/footer.css">
    <link rel="stylesheet" href="/public/css/side-menu.css">
    <script src="/public/scripts/side-menu-toggle.js" defer></script>

    <!-- The requires come here, they will be appended to the body by PHP -->
    <?php require_once __DIR__ . '/../../../public/components/headerComponent.php'; ?>
    <?php require_once __DIR__ . '/side-menu.php'; ?>
    <?php require_once __DIR__ . '/success-popup.php'; ?>
    <?php require_once __DIR__ . '/error-popup.php'; ?>