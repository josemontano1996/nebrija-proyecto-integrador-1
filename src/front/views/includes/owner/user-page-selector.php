<div class="page-selector">
   <a href="/owner/user/management" class="btn-primary">Management Log</a>
   <?php if (isset($page) && $page > 1) : ?> <a href="/owner/users?page=<?= $page - 1 ?>" class="btn-secondary">Previous page</a>
   <?php endif; ?>

   <a href="/owner/users?page=<?= isset($page) ? $page + 1 : 2 ?>" class="btn-secondary">Next page</a>
</div>