<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <h2 class="title">Cartão de Crédito</h2>

    <label>CPF:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Data de nascimento:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Telefone:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Nome impresso no cartão:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Número do cartão:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Código de segurança: (cvv)</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Validade:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Parcelamento:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">

    <div style="margin-bottom: 110px;">
        <a href="<?= $router->route('checkout.success'); ?>" style="float: right;" class="btn">Continue</a>
    </div>

    <div class="brands">
        <div class="small-container">
            <h3 class="title">Bandeiras aceitas</h3>

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
</div>

<?php $v->start("scripts"); ?>
<script>
//
</script>
<?php $v->end(); ?>
