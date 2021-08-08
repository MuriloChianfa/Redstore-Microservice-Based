<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <h2 class="title">Débito</h2>

    <label>CPF:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Data de nascimento:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">
    <label>Telefone:</label>
    <input type="text" class="alter-input" name="" id="" style="width: 100%;">

    <div class="row">
        <div class="col-12">
            <input type="radio" name="asd" id="">
            <img src="<?= asset('/images/bank-bb.webp'); ?>" class="bank-img" alt="">
            <label for="">Banco do brasil</label>
        </div>
        <div class="col-12">
            <input type="radio" name="asd" id="">
            <img src="<?= asset('/images/bank-banrisul.png'); ?>" class="bank-img" alt="">
            <label for="">Banco Banrisul</label>
        </div>
        <div class="col-12">
            <input type="radio" name="asd" id="">
            <img src="<?= asset('/images/bank-bradesco.png'); ?>" class="bank-img" alt="">
            <label for="">Banco Bradesco</label>
        </div>
        <div class="col-12">
            <input type="radio" name="asd" id="">
            <img src="<?= asset('/images/bank-itau.png'); ?>" class="bank-img" alt="">
            <label for="">Banco Itaú</label>
        </div>
    </div>

    <div style="margin-bottom: 30px;">
        <a href="<?= $router->route('checkout.success'); ?>" class="btn">Continue</a>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
//
</script>
<?php $v->end(); ?>
