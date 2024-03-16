<?php

function checkAuth()
{

    $route = explode('?', $_SERVER['REQUEST_URI'])[0];

    if (strpos($route, 'user') && !isset($_SESSION['user'])) {
        http_response_code(403);
        header('Location: /login');
        exit();
    }

    if (strpos($route, 'admin')) {
        if (!isset($_SESSION['user']['role']) || ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['role'] !== 'owner')) {

            http_response_code(403);
            header('Location: /');
            exit();
        }
    }
}
