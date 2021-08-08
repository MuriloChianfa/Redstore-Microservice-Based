<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <h2 class="title">Selecione um método de pagamento: </h2>

    <div class="brands">
        <div class="small-container">
            <div class="row">
                <div class="col-5">
                    <a href="<?= $router->route('checkout.boleto'); ?>"><img src="<?= asset("/images/boleto.png"); ?>" alt=""></a>
                </div>
                <div class="col-5">
                    <a href="<?= $router->route('checkout.credit'); ?>"><img src="<?= asset("/images/credit-card.png"); ?>" alt=""></a>
                </div>
                <div class="col-5">
                    <a href="<?= $router->route('checkout.debit'); ?>"><img src="<?= asset("/images/debit-card.png"); ?>" alt=""></a>
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
