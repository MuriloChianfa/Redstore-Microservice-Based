<?php $v->layout("theme/_theme"); ?>

<!------------ FEATURED PRODUCTS ------------->

<div class="small-container">

    <div class="row row-2">
        <h2>All Products</h2>
        <?php if (!empty($user) && in_array($user->access_level_id->name, [ 'Administrador', 'Gerente', 'Vendedor' ])): ?>
            <button class="btn" onclick="window.location.href='<?= $router->route('web.productInsert'); ?>';">Adicionar produto</button>
        <?php endif; ?>
        <select>
            <option>Default Shorting</option>
            <option>Default by price</option>
            <option>Default by popularity</option>
            <option>Default raging</option>
            <option>Default sale</option>
        </select>
    </div>
    
    <?php if (empty($products)): ?>
        <div class="row">
            <h2 class="title" style="margin-top: 50px; margin-bottom: 120px;">No products available!</h2>
        </div>
    <?php else: ?>
        <?php $productCounter = 0; ?>
        <?php for ($i = 0; $i < count($products); $i++): ?>
            <?php if ($i === 0 || ($i % 4) === 0): ?>
                <?php $productCounter += 1; ?>
                <div class="row">
            <?php endif; ?>
                    <div class="col-4">
                        <a href="<?= url("/product/{$products[$i]->id}"); ?>"><img src="<?= asset($products[$i]->ProductImage[0]->url_slug); ?>" alt="produto1"></a>
                        <a href="<?= url("/product/{$products[$i]->id}"); ?>"><h4><?= $products[$i]->name; ?></h4></a>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <p>$<?= $products[$i]->value; ?></p>
                    </div>
            <?php if ($productCounter === 4 || $i === count($products) - 1): ?>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
    
        <div class="page-btn">
            <?php if ($productsCount < 12): ?>
                <span>1</span>
            <?php else: ?>
                <?php for ($i = 1; $i <= ceil($productsCount / 12); $i++): ?>
                    <?php if ($i == $currentPage): ?>
                        <span style="color: #ff2400;"><?= $i; ?></span>
                    <?php else: ?>
                        <a href="<?= url("/products/{$i}"); ?>"><span style="color: #000;"><?= $i; ?></span></a>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>
            <a href="<?= url("/products/{$lastPage}"); ?>"><span style="color: #000;">&#8594;</span></a>
        </div>
    <?php endif; ?>

</div>
