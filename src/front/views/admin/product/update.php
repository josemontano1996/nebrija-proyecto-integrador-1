<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>

<link rel="stylesheet" href="/src/front/css/admin/update-product.css">
<script src="/src/front/scripts/admin/update-product.js" defer></script>

<title>Chef Manuelle Webpage</title>
</head>

<body>
   <?php require_once __DIR__ . '/../../includes/shared-components.php'; ?>
   <?php
   echo createHeader();
   ?>
   <main>
      <section>
         <form id="update-product-form" class="form centered">
            <input type="hidden" name="id" value="<?= $params->getId() ?>">
            <input type="hidden" name="old_image_url" value="<?= $params->getImageUrl() ?>">
            <h1>Update Product</h1>
            <div>
               <label for="name">Product Name</label>
               <input type="text" id="name" name="name" value="<?= $params->getName() ?>" required>
            </div>
            <div id="image-container">
               <h3>Current Image</h3>
               <img src="<?= $params->getImageUrl() ?>" alt="">
            </div>
            <div>
               <label for="new_image">New Image</label>
               <input type="file" accept=".jpg, .jpeg, .png, .webp" id="new_image" name="new_image">
            </div>
            <div>
               <label for="description">Description</label>
               <textarea type="text" id="description" name="description" rows="5" cols="75" required><?= $params->getDescription() ?></textarea>
            </div>

            <div>
               <label for="servings">Min. servings</label>
               <input type="number" id="servings" name="min_servings" min="0" value="<?= $params->getMinServings() ?>">
            </div>
            <div>
               <label for="price">Price</label>
               <input type="number" id="price" name="price" required min="0" step="0.01" value="<?= $params->getPrice() ?>">
            </div>
            <div>
               <label for="type">Dish Type</label>
               <select id="type" name="type" required>
                  <?php foreach (DISHES_TYPES as $type) : ?>
                     <option value="<?= $type ?>" <?= $params->getType() === $type ? 'selected' : '' ?>><?= ucfirst($type) ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <button class="btn-primary centered">Submit</button>
      </section>

      </form>
   </main>
   <?php require_once __DIR__ . '/../../includes/footer.php';
