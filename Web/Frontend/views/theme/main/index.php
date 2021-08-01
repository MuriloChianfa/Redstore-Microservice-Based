<?php $v->layout("theme/_theme"); ?>

<div class="account-page">
    <div class="cointainer">
        <div class="row">
            <div class="col-2">
                <img src="<?= asset("/images/image1.png"); ?>" width="100%">
            </div>
            <div class="col-2">
                <h1>Give your workout <br> A new style!</h1>
                <p>Success isn't alwayes about greatness. It's aboute consistency. Consistent <br> hard work gains
                    success. Greatness will come2.</p>
                <a href="" class="btn">Explore Now &#8594;</a>
            </div>
        </div>
    </div>
</div>

<!------------ FEATURED CATEGORIES ------------->

<div class="categories">
    <div class="small-container">
        <div class="row">
            <div class="col-3">
                <img src="<?= asset("/images/category-1.jpg"); ?>" alt="categoria">
            </div>
            <div class="col-3">
                <img src="<?= asset("/images/category-2.jpg"); ?>" alt="categoria">
            </div>
            <div class="col-3">
                <img src="<?= asset("/images/category-3.jpg"); ?>" alt="categoria">
            </div>
        </div>
    </div>
</div>

<!------------ FEATURED PRODUCTS ------------->

<div class="small-container">

    <?php if (empty($featuredProducts) && empty($latestProducts)): ?>
        <h2 class="title">No products available!</h2>
    <?php endif; ?>

    <?php if (!empty($featuredProducts)): ?>
        <h2 class="title">Featured Products</h2>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-4">
                <a href="<?= url("/product/{$product->id}"); ?>"><img src="<?= asset($product->ProductImage[0]->url_slug); ?>" alt="produto1"></a>
                <a href="<?= url("/product/{$product->id}"); ?>"><h4><?= $product->name ?></h4></a>
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
    
    <?php if (!empty($latestProducts)): ?>
        <h2 class="title">Latest Products</h2>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($latestProducts as $product): ?>
            <div class="col-4">
                <a href="<?= url("/product/{$product->id}"); ?>"><img src="<?= asset($product->ProductImage[0]->url_slug); ?>" alt="produto1"></a>
                <a href="<?= url("/product/{$product->id}"); ?>"><h4><?= $product->name ?></h4></a>
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

    <div class="row">
        <?php foreach ($latestProducts2 as $product): ?>
            <div class="col-4">
                <a href="<?= url("/product/{$product->id}"); ?>"><img src="<?= asset($product->ProductImage[0]->url_slug); ?>" alt="produto1"></a>
                <a href="<?= url("/product/{$product->id}"); ?>"><h4><?= $product->name ?></h4></a>
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

<!----------------- OFFER --------------------->

<div class="offer">
    <div class="small-container">
        <div class="row">
            <div class="col-2">
                <img src="<?= asset("/images/exclusive.png"); ?>" alt="exclusivos" class="offer-img">
            </div>
            <div class="col-2">
                <p>Exclusively Available on RedStore</p>
                <h1>Smart Band 4</h1>
                <small>The Mi Smart Band 4 features a 39.9% larger (than Mi Band 3) AMOLED color full-touch display
                    with adjustable brightness, clear as can be.</small>
                <a href="" class="btn">Buy Now &#8594;</a>
            </div>
        </div>
    </div>
</div>

<!----------------- TESTIMONIAL --------------------->

<div class="testimonial">
    <div class="small-container">

        <div class="row">
            <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="<?= asset("/images/user-1.png"); ?>" alt="Sean Parker">
                <h3>Sean Parker</h3>
            </div>
            <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="<?= asset("/images/user-2.png"); ?>" alt="Sean Parker">
                <h3>Mike Smith</h3>
            </div>
            <div class="col-3">
                <i class="fa fa-quote-left"></i>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                    labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                    laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <div class="rating">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-o"></i>
                    <i class="fa fa-star-o"></i>
                </div>
                <img src="<?= asset("/images/user-3.png"); ?>" alt="Sean Parker">
                <h3>Mabel Jhoe</h3>
            </div>
        </div>

    </div>
</div>

<!----------------- BRANDS --------------------->

<div class="brands">
    <div class="small-container">
        <div class="row">
            <div class="col-5">
                <img src="<?= asset("/images/logo-godrej.png"); ?>" alt="">
            </div>
            <div class="col-5">
                <img src="<?= asset("/images/logo-oppo.png"); ?>" alt="">
            </div>
            <div class="col-5">
                <img src="<?= asset("/images/logo-coca-cola.png"); ?>" alt="">
            </div>
            <div class="col-5">
                <img src="<?= asset("/images/logo-paypal.png"); ?>" alt="">
            </div>
            <div class="col-5">
                <img src="<?= asset("/images/logo-philips.png"); ?>" alt="">
            </div>
        </div>
    </div>
</div>
