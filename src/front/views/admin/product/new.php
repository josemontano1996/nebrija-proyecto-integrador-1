<?php require_once __DIR__ . '/../../includes/shared-head.php'; ?>

<script src="/src/front/scripts/admin/post-new-product.js" defer></script>

<?php echo generateSEOTags('New Product', 'New Product'); ?>
</head>

<body>
    <?php require_once __DIR__ . '/../../includes/shared-components.php'; ?>
    <?php
    echo createHeader();
    ?>
    <main>
        <section>
            <form id="upload-product-form" class="form centered">
                <h1>New Product</h1>
                <div>
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="image">Image</label>
                    <input type="file" accept=".jpg, .jpeg, .png, .webp" id="image" name="image" required>
                </div>
                <div>
                    <label for="description">Description</label>
                    <textarea type="text" id="description" name="description" rows="5" cols="75" required></textarea>
                </div>
                <div>
                    <label for="servings">Min. servings</label>
                    <input type="number" id="servings" name="min_servings" min="0">
                </div>
                <div>
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" required min="0">
                </div>
                <div>
                    <label for="type">Dish Type</label>
                    <select id="type" name="type" required>
                        <?php foreach (DISHES_TYPES as $type) : ?>
                            <option value="<?= $type ?>"><?= ucfirst($type) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn-primary centered">Submit</button>
        </section>

        </form>
    </main>
    <?php require_once __DIR__ . '/../../includes/footer.php';
