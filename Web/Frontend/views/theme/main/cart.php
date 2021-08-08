<?php $v->layout("theme/_theme"); ?>

<!------------ CART ITEMS DETAILS ------------->

<div class="small-container cart-page">
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <tr>
            <td>
                <div class="cart-info">
                    <img src="<?= asset("/images/buy-1.jpg"); ?>">
                    <div>
                        <p>Printed Tshirt</p>
                        <small>Price: $50.00</small>
                        <br>
                        <a href="">Remove</a>
                    </div>
                </div>
            </td>
            <td><input type="number" value="1" /></td>
            <td>$50.00</td>
        </tr>
        <tr>
            <td>
                <div class="cart-info">
                    <img src="<?= asset("/images/buy-2.jpg"); ?>">
                    <div>
                        <p>Printed Tshirt</p>
                        <small>Price: $75.00</small>
                        <br>
                        <a href="">Remove</a>
                    </div>
                </div>
            </td>
            <td><input type="number" value="1" /></td>
            <td>$75.00</td>
        </tr>
        <tr>
            <td>
                <div class="cart-info">
                    <img src="<?= asset("/images/buy-3.jpg"); ?>">
                    <div>
                        <p>Printed Tshirt</p>
                        <small>Price: $75.00</small>
                        <br>
                        <a href="">Remove</a>
                    </div>
                </div>
            </td>
            <td><input type="number" value="1" /></td>
            <td>$75.00</td>
        </tr>
    </table>

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
