<?php $v->layout("theme/_theme"); ?>

<!------------ SELECT CHECKOUT ADDRESS ------------->

<div class="small-container cart-page">
    <h4>Select address:</h4>

    <div class="row">
        <?php if (is_null($userData->address)): ?>
            <div class="col-12 bordered bordered-line-both bordered-border">
                <div class="bordered-content bordered-align-left">
                    <h4 class="modal-text noselect">Adicionar endereço:</h4>

                    <label for="addAddressCity" class="address-label">Cidade:</label>
                    <select class="alter-input" name="addAddressCity" id="addAddressCity">
                        <option value="1" selected>Acrelandia, AC</option>
                        <option value="2">Assis Brasil, AC</option>
                    </select>
                    <label for="addAddressStreet" class="address-label">Rua:</label>
                    <input type="text" class="alter-input" name="addAddressStreet" id="addAddressStreet">
                    <label for="addAddressNumber" class="address-label">Numero:</label>
                    <input type="number" class="alter-input" name="addAddressNumber" id="addAddressNumber">
                    <label for="addAddressComplement" class="address-label">Complemento:</label>
                    <input type="text" class="alter-input" name="addAddressComplement" id="addAddressComplement">
                    <label for="addAddressCEP" class="address-label">CEP:</label>
                    <input type="text" class="alter-input" name="addAddressCEP" id="addAddressCEP">

                    <div class="modal-options-buttons noselect">
                        <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
                        <button type="button" class="modal-button save-button" id="addAddressSave" onclick="
                            if (newAddress({
                                'city_id': document.getElementById('addAddressCity').value,
                                'street': document.getElementById('addAddressStreet').value,
                                'complement': document.getElementById('addAddressNumber').value,
                                'cep': document.getElementById('addAddressComplement').value,
                                'number': document.getElementById('addAddressCEP').value
                            })) {
                                window.location.reload();
                            }
                        ">Adicionar</button>
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
            <div class="col-12 bordered bordered-line-bottom bordered-border-top">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered noselect" onclick="clearNewAddressInputs(); showModal('addAddress');">Adicionar endereço...</h2>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div style="margin-bottom: 170px;">
        <a href="" class="btn checkout-btn">Continue</a>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
async function newAddress(data) {
	try {
        await $.ajax({
            type: 'POST',
            url: '<?= $mainURL ?>/me/address',
            cache: false,
            async: false,
            headers: { 
                'Authorization': `Bearer <?= $userJWT ?? '' ?>`,
                'Accept': 'application/json',
            },
            data: data,
            success: (data, textStatus, jqXHR) => {
                switch (jqXHR.statusCode().status) {
                    case 200:
                        if (!data) {
                            throw '';
                        }

                        customAlert('Endereço adicionado com sucesso!', 'success');
                        break;
                    case 206:
                        if (!data) {
                            throw '';
                        }

                        customAlert(data.message, 'warning');
                        break;
                    default: throw ''; break;
                }

                setTimeout(() => { closeModal(); }, 25);
                return true;
            },
            error: () => { throw ''; }
        });
    }
    catch (err) {
        customAlert('Ocorreu algum erro ao tentar cadastrar o endereço!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}
</script>
<?php $v->end(); ?>
