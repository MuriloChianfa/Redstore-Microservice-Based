<?php $v->layout("theme/_theme"); ?>

<!------------ SINGLE PRODUCT DETAILS ------------->

<div class="small-container single-product">

    <div class="row">
        <div class="col-2">
            <img src="<?= productImage($product); ?>" width="100%" id="ProductImg">

            <div class="small-img-row">
                <div class="small-img-col"><img src="<?= productImage($product); ?>" id="<?= $product->ProductImage[0]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 1); ?>" id="<?= $product->ProductImage[1]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 2); ?>" id="<?= $product->ProductImage[2]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 3); ?>" id="<?= $product->ProductImage[3]->id ?? 0 ?>" class="small-img" width="100%"></div>
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
<script>

var ProductImg = document.getElementById('ProductImg');
var SmallImg = document.getElementsByClassName('small-img');

for (let i = 0; i < 4; i++) {
    SmallImg[i].onclick = () => { ProductImg.src = SmallImg[i].src }
}

<?php if (!empty($user) && in_array($user->access_level_id->name, [ 'Administrador', 'Gerente', 'Vendedor' ])): ?>

Array.from(SmallImg).forEach(element => {
    if (element.src.includes('no-product-image.png')) {
        return;
    }

    let excludeIcon = document.createElement('img');
    excludeIcon.className = 'exclude-product-icon';
    excludeIcon.src = '<?= asset("/images/incorrect.png"); ?>';
    excludeIcon.onmouseover = () => { excludeIcon.style.display = 'flex'; }
    excludeIcon.onclick = component => {
        $.ajax({
            url: `<?= BASE_API; ?>/product-image/${component.target.parentNode.getElementsByClassName('small-img')[0].id}`,
            type: 'DELETE',
            dataType: 'json',
            headers: { 'Authorization': `Bearer <?= $token ?? ''; ?>` },
            beforeSend: function (load) {
                ajax_load('open');
            },
            success: function (su) {
                ajax_load('close');

                if (su.message) {
                    var view = '<div class="message ' + su.message.type + '">' + su.message.message + '</div>';
                    $('.login_form_callback').html(view);
                    $('.message').effect('bounce');
                    return;
                }

                document.location.reload(true);
            }
        });
    }

    element.parentElement.appendChild(excludeIcon);

    element.onmouseover = () => { excludeIcon.style.display = 'flex'; }
    element.onmouseout = () => { excludeIcon.style.display = 'none'; }
});

function ajax_load(action) {
    ajax_load_div = $('.ajax_load');

    if (action === 'open') {
        ajax_load_div.fadeIn(200).css('display', 'flex');
    }

    if (action === 'close') {
        ajax_load_div.fadeOut(200);
    }
}

<?php endif; ?>
</script>
<?php $v->end(); ?>
