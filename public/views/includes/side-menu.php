<nav id="side-menu" class="hidden">
    <?php if (!isset($_SESSION['user']['role'])) : ?>
        <div>
            <h4>User section</h4>
            <ul>
                <li>
                    <a href="/cart">
                        <img class="icon" src="/public/assets/icons/bag-icon.svg" alt="cart icon">
                        <span>Cart</span>
                        </img>
                    </a>
                </li>
                <li>
                    <a href="/user/account">
                        <img class="icon" src="/public/assets/icons/user-icon.svg" alt="account icon">
                        <span>Account</span>
                        </img>
                    </a>
                </li>
                <li>
                    <a href="/user/orders">
                        <img class="icon" src="/public/assets/icons/orders-icon.svg" alt="orders icon">
                        <span>Orders</span>
                        </img>
                    </a>
                </li>
                <?php if (!isset($_SESSION['user'])) : ?>
                    <li>
                        <a href="/login">
                            <img class="icon" src="/public/assets/icons/login-icon.svg" alt="log in icon">
                            <span>Credentials</span>
                            </img>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])) : ?>
                    <li>
                        <a href="/logout">
                            <img class="icon" src="/public/assets/icons/log-out.svg" alt="log out icon">
                            <span>Log out</span>
                            </img>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] === 'admin' || $_SESSION['user']['role'] === 'owner')) : ?>
        <div>
            <h4>Admin section</h4>
            <ul>
                <li>
                    <a href="/admin/orders">
                        <img class="icon" src="/public/assets/icons/bag-icon.svg" alt="cart icon">
                        <span>Orders</span>
                        </img>
                    </a>
                </li>
                <li>
                    <a href="/admin/menu">
                        <img class="icon" src="/public/assets/icons/orders-icon.svg" alt="orders icon">
                        <span>Menu</span>
                        </img>
                    </a>
                </li>
                <?php if ($_SESSION['user']['role'] === 'owner') : ?>
                    <li>
                        <a href="/owner/users">
                            <img class="icon" src="/public/assets/icons/user-icon.svg" alt="account icon">
                            <span>Users</span>
                            </img>
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="/logout">
                        <img class="icon" src="/public/assets/icons/log-out.svg" alt="log out icon">
                        <span>Log out</span>
                        </img>
                    </a>
                </li>
            </ul>
        </div>
    <?php endif; ?>
</nav>