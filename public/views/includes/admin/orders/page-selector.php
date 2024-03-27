 <?php if (isset($page)) : ?>
     <div class="page-selector">
         <?php if (isset($page) && $page > 1) : ?>
             <?php if (isset($_GET['status'])) : ?>
                 <a href="/admin/orders<?= isset($_GET['status']) ? "?status=" . $_GET['status'] : "" ?>&page=<?= $page - 1 ?>" class="btn-secondary">Previous page</a>
             <?php else : ?>
                 <a href="/admin/orders?page=<?= $page - 1 ?>" class="btn-secondary">Previous page</a>
             <?php endif; ?>
         <?php endif; ?>
         <?php if (isset($_GET['status'])) : ?>
             <a href="/admin/orders<?= isset($_GET['status']) ? "?status=" . $_GET['status'] : "" ?>&page=<?= $page + 1 ?>" class="btn-secondary">Next page</a>
         <?php else : ?>
             <a href="/admin/orders?page=<?= $page + 1 ?>" class="btn-secondary">Next page</a>
         <?php endif; ?>
     <?php endif; ?>