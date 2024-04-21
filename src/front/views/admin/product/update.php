<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>

<link rel="stylesheet" href="/public/css/admin/update-product.css">
<script src="/public/scripts/admin/update-product.js" defer></script>

<title>Chef Manuelle Webpage</title>
</head>

<body>
   <?php
   echo createHeader();
   ?>
   <main>
      <section>
         <form id="update-product-form" class="form centered">
            <input type="hidden" name="id" value="<?= $params['id'] ?>">
            <input type="hidden" name="old_image_url" value="<?= $params['image_url'] ?>">
            <h1>Update Product</h1>
            <div>
               <label for="name">Product Name</label>
               <input type="text" id="name" name="name" value="<?= $params['name'] ?>" required>
            </div>
            <div id="image-container">
               <h3>Current Image</h3>
               <img src="<?= $params['image_url'] ?>" alt="">
            </div>
            <div>
               <label for="new_image">New Image</label>
               <input type="file" accept=".jpg, .jpeg, .png, .webp" id="new_image" name="new_image">
            </div>
            <div>
               <label for="description">Description</label>
               <textarea type="text" id="description" name="description" rows="5" cols="75" required><?= $params['description'] ?></textarea>
            </div>
            <div>
               <label for="servings">Min. servings</label>
               <input type="number" id="servings" name="min_servings" min="0" value="<?= isset($params['min_servings']) ? $params['min_servings'] : 0 ?>">
            </div>
            <div>
               <label for="price">Price</label>
               <input type="number" id="price" name="price" required min="0" step="0.01" value="<?= $params['price'] ?>">
            </div>
            <div>
               <label for="type">Dish Type</label>
               <select id="type" name="type" required>
                  <?php foreach (DISHES_TYPES as $type) : ?>
                     <option value="<?= $type ?>" <?= $params['type'] === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <button class="btn-primary centered">Submit</button>
      </section>

      </form>
   </main>
   <?php require_once __DIR__ . '/../../includes/footer.php';
