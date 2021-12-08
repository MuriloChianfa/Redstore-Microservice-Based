<?php $v->layout("theme/_theme"); ?>

<!------------ CART ITEMS DETAILS ------------->

<div class="small-container cart-page" style="margin-top: 15vh; margin-bottom: 8vh;">
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>

    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td>
                    <div class="cart-info">
                        <img src="
                            <?php if (empty($product->ProductImage)) {
                                echo asset("/images/no-product-image.png");
                            } else {
                                echo asset($product->ProductImage);
                            } ?>
                        ">
                        <div>
                            <p><?= $product->name; ?></p>
                            <small>Price: $<?= $product->value; ?></small>
                            <br>
                            <a href="">Remove</a>
                        </div>
                    </div>
                </td>
                <td><input type="number" value="1" /></td>
                <td>$<?= $product->value; ?></td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php else: ?></table>
        <div class="row">
            <h2 class="title" style="margin-top: 15vh; margin-bottom: 17vh;">Your cart is empty!</h2>
        </div>
        </table>
    <?php endif; ?>

    <div class="total-price">
        <table class="frete-class">
            <tr>
                <td>CEP:</td>
                <td>
                    <input type="text" name="frete" id="frete" style="width: 100%;">
                </td>
                <td>
                    <a href="" class="btn">Calcular</a>
                </td>
            </tr>
        </table>
        <table class="total-price-class">
            <tr>
                <td>Subtotal</td>
                <td>$200.00</td>
            </tr>
            <tr>
                <td>Frete</td>
                <td>$0</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$200.00</td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 170px;">
        <a href="<?= $router->route('checkout.selectAddress'); ?>" class="btn checkout-btn">Checkout</a>
    </div>    
</div>
