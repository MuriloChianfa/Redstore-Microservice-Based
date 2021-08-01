<?php $v->layout("theme/_theme"); ?>

<!------------ SINGLE PRODUCT DETAILS ------------->

<div class="small-container single-product">
    <div class="row">
        <?php if (!empty($user) && in_array($user->access_level_id->name, [ 'Administrador', 'Gerente', 'Vendedor' ])): ?>
            <div class="form-message">
                <div class="login_form_callback">
                    <?= flash(); ?>
                </div>
            </div>
    </div>
    <div class="row">
            <form action="<?= $router->route('products.image'); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $product->id; ?>">
                <input type="hidden" name="image" id="image">
                <input type="file" class="btn" onchange="getBaseUrl()" />

                <input type="submit" class="btn" value="Adicionar" />
            </form>
            <script>
                function getBaseUrl ()  {
                    var reader = new FileReader();

                    reader.onloadend = function () {
                        let baseString = reader.result;
                        document.getElementById('image').value = baseString;
                    };

                    reader.readAsDataURL(document.querySelector('input[type=file]')['files'][0]);
                }
            </script>
        <?php endif; ?>
    </div>
    
    <div class="row">
        <div class="col-2">
            <img src="<?= productImage($product); ?>" width="100%" id="ProductImg">

            <div class="small-img-row">
                <div class="small-img-col"><img src="<?= productImage($product); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 1); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 2); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 3); ?>" class="small-img" width="100%"></div>
            </div>

        </div>
        <div class="col-2">
            <p>Home / T-Shirt</p>
            <h1><?= $product->name; ?></h1>
            <h4>$<?= $product->value; ?></h4>
            <select>
                <option>Select Size</option>
                <option>XXL</option>
                <option>XL</option>
                <option>Large</option>
                <option>Medium</option>
                <option>Small</option>
            </select>
            <input type="number" value="1" />
            <a href="" class="btn">Add To Cart</a>
            <h3>Product Details <i class="fa fa-indent"></i></h3>
            <br>
            <p><?= $product->description; ?></p>
        </div>
    </div>
</div>

<!------------ TITLE ------------->

<div class="small-container">
    <div class="row row-2">
        <h2>Related Products</h2>
        <p>View More</p>
    </div>
</div>

<!------------ PRODUCTS ------------->

<div class="small-container">

<div class="row">
    <?php foreach ($relatedProducts as $product): ?>
        <div class="col-4">
            <a href="<?= url("/product/{$product->id}"); ?>"><img src="<?= productImage($product); ?>" alt="produto1"></a>
            <a href="<?= url("/product/{$product->id}"); ?>"><h4><?= $product->name ?></h4></a>
            <div class="rating">
                <?= starRate($product->rate); ?>
            </div>
            <p>$<?= $product->value ?></p>
        </div>
    <?php endforeach; ?>
</div>

</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/product-details.js"); ?>"></script>
<?php $v->end(); ?>
