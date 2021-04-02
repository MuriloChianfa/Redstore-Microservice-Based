<?php $v->layout("theme/_theme"); ?>

<!------------ SINGLE PRODUCT DETAILS ------------->

<div class="small-container single-product">
    <div class="row">
        <div class="col-2">
            <img src="<?= asset("/images/gallery-1.jpg"); ?>" width="100%" id="ProductImg">

            <div class="small-img-row">
                <div class="small-img-col">
                    <img src="<?= asset("/images/gallery-1.jpg"); ?>" class="small-img" width="100%">
                </div>
                <div class="small-img-col">
                    <img src="<?= asset("/images/gallery-2.jpg"); ?>" class="small-img" width="100%">
                </div>
                <div class="small-img-col">
                    <img src="<?= asset("/images/gallery-3.jpg"); ?>" class="small-img" width="100%">
                </div>
                <div class="small-img-col">
                    <img src="<?= asset("/images/gallery-4.jpg"); ?>" class="small-img" width="100%">
                </div>
            </div>

        </div>
        <div class="col-2">
            <p>Home / T-Shirt</p>
            <h1>Red Printed T-Shirt by HRX</h1>
            <h4>$50.00</h4>
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
            <p>Give your summer wardrobe a style upgrade with the HRX Men's Active T-shirt. 
                Team it with a pair of shorts for your morning workout 
                or a denims for an evening out with  the guys.</p>
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
        <div class="col-4">
            <img src="<?= asset("/images/product-1.jpg"); ?>" alt="produto1">
            <h4>Red Printed T-shirt</h4>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>$50.00</p>
        </div>

        <div class="col-4">
            <img src="<?= asset("/images/product-2.jpg"); ?>" alt="produto1">
            <h4>Red Printed T-shirt</h4>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
            </div>
            <p>$50.00</p>
        </div>

        <div class="col-4">
            <img src="<?= asset("/images/product-3.jpg"); ?>" alt="produto1">
            <h4>Red Printed T-shirt</h4>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
            </div>
            <p>$50.00</p>
        </div>

        <div class="col-4">
            <img src="<?= asset("/images/product-4.jpg"); ?>" alt="produto1">
            <h4>Red Printed T-shirt</h4>
            <div class="rating">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
            </div>
            <p>$50.00</p>
        </div>
    </div>

</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/product-details.js"); ?>"></script>
<?php $v->end(); ?>
