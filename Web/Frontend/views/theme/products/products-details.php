<?php $v->layout("theme/_theme"); ?>

<!------------ SINGLE PRODUCT DETAILS ------------->

<div class="small-container single-product">

    <div class="row">
        <div class="col-2">
            <img src="<?= productImage($product); ?>" class="featured-img" width="100%" id="ProductImg">

            <div class="small-img-row">
                <div class="small-img-col"><img src="<?= productImage($product); ?>" id="<?= $product->ProductImage[0]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 1); ?>" id="<?= $product->ProductImage[1]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 2); ?>" id="<?= $product->ProductImage[2]->id ?? 0 ?>" class="small-img" width="100%"></div>
                <div class="small-img-col"><img src="<?= productImage($product, 3); ?>" id="<?= $product->ProductImage[3]->id ?? 0 ?>" class="small-img" width="100%"></div>
            </div>

            <div class="row">
                <?php if (!empty($user) && in_array($user->access_level_id->name, ['Administrador', 'Gerente', 'Vendedor'])): ?>
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
                        <input type="file" class="inputfile inputfile-1" id="custom-file-input" onchange="getBaseUrl()" />
                        <label for="custom-file-input"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg> <span>Upload de imagem&hellip;</label>

                        <input type="submit" class="custom-button-2" value="Adicionar" />
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
        </div>
        <div class="col-2">
            <p style="">Home / T-Shirt</p>
            <h1><?= str_limit_chars($product->name, 120); ?></h1>
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

<?php if (empty($relatedProducts)): ?>
    <div class="row">
        <h2 class="title" style="margin-top: 50px; margin-bottom: 120px;">No products related!</h2>
    </div>
<?php else: ?>
    <div class="small-container">
        <div class="row">
            <?php foreach ($relatedProducts as $product): ?>
                <div class="col-4">
                    <a href="<?= url("/product/{$product->id}"); ?>"><img src="<?= productImage($product); ?>" class="big-img" alt="produto1"></a>
                    <a href="<?= url("/product/{$product->id}"); ?>"><h4><?= str_limit_chars($product->name, 30); ?></h4></a>
                    <div class="rating">
                        <?= starRate($product->rate); ?>
                    </div>
                    <p>$<?= $product->value ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/fileInput/custom-file-input.js"); ?>"></script>
<script src="<?= asset("/js/fileInput/jquery.custom-file-input.js"); ?>"></script>
<script>

var ProductImg = document.getElementById('ProductImg');
var SmallImg = document.getElementsByClassName('small-img');

for (let i = 0; i < 4; i++) {
    SmallImg[i].onclick = () => { ProductImg.src = SmallImg[i].src }
}

<?php if (!empty($user) && in_array($user->access_level_id->name, ['Administrador', 'Gerente', 'Vendedor'])): ?>

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
