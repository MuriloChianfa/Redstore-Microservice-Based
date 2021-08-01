<?php $v->layout("theme/_theme"); ?>

<!------------ SINGLE PRODUCT DETAILS ------------->

<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="<?= asset($product->ProductImage[0]->url_slug); ?>" width="100%" id="ProductImg">

            <div class="small-img-row">
                <div class="small-img-col"><img src="<?= asset($product->ProductImage[1]->url_slug ?? $product->ProductImage[0]->url_slug); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= asset($product->ProductImage[2]->url_slug ?? $product->ProductImage[0]->url_slug); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= asset($product->ProductImage[3]->url_slug ?? $product->ProductImage[0]->url_slug); ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= asset($product->ProductImage[4]->url_slug ?? $product->ProductImage[0]->url_slug); ?>" class="small-img" width="100%"></div>
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
            <a href="<?= $router->route("web.productsDetails"); ?>"><img src="<?= asset($product->ProductImage[0]->url_slug); ?>" alt="produto1"></a>
            <a href="<?= $router->route("web.productsDetails"); ?>"><h4><?= $product->name ?></h4></a>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>$<?= $product->value ?></p>
        </div>
    <?php endforeach; ?>
</div>

</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/product-details.js"); ?>"></script>
<?php $v->end(); ?>
