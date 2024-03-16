<?php

declare(strict_types=1);
function createHeader(?string $midHeader = null, ?string $rightHeader = null)
{
    if (!isset($rightHeader)) {
        if (isset($_SESSION['user']) && isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'owner')) {
            $rightHeader = '<li><a href="/admin/orders"> <img class="icon" src="/public/assets/icons/read-book-icon.svg" alt="menu-icon"></a></li>
                <li><a href="/admin/menu"> <img class="icon" src="/public/assets/icons/bag-icon.svg" alt="menu-icon"></a></li>';
        } else {
            $rightHeader = '<li><a href="/menu"> <img class="icon" src="/public/assets/icons/read-book-icon.svg" alt="menu-icon"></a></li>
                <li><a href="/cart"> <img class="icon" src="/public/assets/icons/bag-icon.svg" alt="menu-icon"></a></li>';
        }
    }
    return <<<HTML
     <header id="header">
        <div>
            <h1><a href="/">IB</a></h1>
        </div>
        <nav>
            <ul id="mid-header">
             $midHeader 
            </ul>
        </nav>
        <nav>
            <ul id="right-header">
               $rightHeader
                <li id="hamburger-button"><span></span><span></span><span></span></li>
            </ul>
        </nav>
    </header>
HTML;
}
