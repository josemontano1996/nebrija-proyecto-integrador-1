<div class="page-selector">
    <a href="/owner/users" class="btn-primary">User list</a>
    <?php if (isset($page) && $page > 1) : ?> <a href="/owner/user/management?page=<?= $page - 1 ?>" class="btn-secondary">Previous page</a>
    <?php endif; ?>

    <a href="/owner/user/management?page=<?= isset($page) ? $page + 1 : 2 ?>" class="btn-secondary">Next page</a>
</div>