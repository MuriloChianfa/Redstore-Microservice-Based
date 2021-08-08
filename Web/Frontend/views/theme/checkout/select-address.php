<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <?php if (is_null($userData->address)): ?>
        <h2 class="title">Informe-nos ou cadastre seu endereço de entrega: </h2>

        <div class="row select-address-block-display">
            <div class="auto-margin">
                <div class="select-address-row">
                    <label>CEP:</label>
                    <input type="text" class="alter-input" name="addAddressCEP" id="addAddressCEP" style="width: 30%;">
                </div>
                <a href="" class="btn">Preencher</a>
            </div>
        </div>

        <div class="row select-address-block-display">
            <div class="auto-margin">
                <div class="select-address-row">
                    <label>Cidade:</label>
                    <select class="alter-input" name="addAddressCity" id="addAddressCity" style="width: 100%;">
                        <option value="1" selected>Acrelandia, AC</option>
                        <option value="2">Assis Brasil, AC</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-2 select-address-block-display" style="flex-basis: 68%;">
                <div class="auto-margin">
                    <div class="select-address-row">
                        <label>Rua:</label>
                        <input type="text" class="alter-input" name="addAddressStreet" id="addAddressStreet" style="width: 100%;">
                    </div>
                </div>
            </div>
            <div class="col-2 select-address-block-display" style="flex-basis: 30%;">
                <div class="auto-margin">
                    <div class="select-address-row">
                        <label>Numero:</label>
                        <input type="number" class="alter-input" name="addAddressNumber" id="addAddressNumber" style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>

        <div class="row select-address-block-display">
            <div class="auto-margin">
                <div class="select-address-row">
                    <label>Complemento:</label>
                    <input type="text" class="alter-input" name="addAddressComplement" id="addAddressComplement" style="width: 100%;">
                </div>
            </div>
        </div>

    <?php else: ?>
        <?php foreach ($userData->address as $key => $value): ?>
            <div class="col-12 bordered bordered-line-top pointered" id="addressRow" onclick="changeAlterAddressInputs(<?= $value->id ?>); showModal('alterAddress');">
                <div class="bordered-content bordered-align-left">
                    <h2><strong>Endereço <?= ($key + 1); ?></strong></h2>
                    <h2>Cidade, Estado</h2>
                    <h2>CEP</h2>
                    <h2>Rua</h2>
                    <h2>Número</h2>
                    <h2>Complemento</h2>
                </div>
                <div class="bordered-data-address">
                    <h2 style="margin-top: 26px;"></h2>
                    <h2><?= $value->city_id ?></h2>
                    <h2><?= $value->cep ?></h2>
                    <h2><?= $value->street ?></h2>
                    <h2><?= $value->number ?></h2>
                    <h2><?= $value->complement ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div style="margin-bottom: 150px;">
        <a href="<?= $router->route('checkout.paymentMethod'); ?>" style="float: right;" class="btn">Continue</a>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
//
</script>
<?php $v->end(); ?>
