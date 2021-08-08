<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <h2 class="title">Boleto</h2>

    <label>CPF:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Data de nascimento:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Telefone:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">

    <div style="margin-bottom: 150px;">
        <a href="<?= $router->route('checkout.success'); ?>" style="float: right;" class="btn">Continue</a>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
//
</script>
<?php $v->end(); ?>
