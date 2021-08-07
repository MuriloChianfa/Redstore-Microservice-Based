<?php $v->layout("theme/_theme"); ?>

<!------------ PROFILE PAGE ------------->

<div class="minimal-container">
    <div class="row row-account-img"></div>

    <div class="row">
        <div class="small-user-img user-img">
            <img src="<?= asset("/images/user-2.png"); ?>" class="small-img noselect" width="100%">
        </div>
    </div>

    <div class="row row-account">
        <h2 class="noselect">Dados da conta</h2>
        <a class="noselect">Status da conta: &nbsp;&nbsp;<small class="noselect">Não confirmada</small></a>
    </div>

    <div class="row">
        <div class="col-12 bordered bordered-line-top pointered" onclick="showModal('alterFirstName');">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">Primeiro nome</h2>
            </div>
            <div class="bordered-data">
                <h2 id="userFirstName"><?= $userData->first_name ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line pointered" onclick="showModal('alterLastName');">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">Segundo nome</h2>
            </div>
            <div class="bordered-data">
                <h2 id="userLastName"><?= $userData->last_name ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line default-cursor">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">E-mail</h2>
            </div>
            <div class="bordered-data">
                <h2 id="userEmail"><?= $userData->email ?></h2>
            </div>
        </div>
        <div class="col-12 bordered bordered-line-bottom bordered-border-top default-cursor">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">Senha</h2>
            </div>
            <div class="bordered-data">
                <h2>************</h2>
            </div>
        </div>
    </div>

    <div class="row row-account-continous">
        <h2 class="noselect">Dados pessoais</h2>
    </div>

    <div class="row">
        <div class="col-12 bordered bordered-line-top pointered" onclick="showModal('alterBirthDate');">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">Data de nascimento</h2>
            </div>
            <div class="bordered-data">
                <h2 id="userBirthDate"><?= date_fmt($userData->birth_date ?? '0000-00-00 00:00:00'); ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line pointered" onclick="showModal('alterCPF');">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">CPF</h2>
            </div>
            <div class="bordered-data">
                <h2 id="userCPF"><?= $userData->cpf ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line-bottom bordered-border-top">
            <div class="bordered-content bordered-align-left">
                <h2 class="noselect">Promoções via E-mail</h2>
            </div>
            <div class="bordered-data">
                <label class="switch">
                    <input type="checkbox" id="receive_promotion" onclick="alert('swited receive promotion para = ' + this.checked)" 
                        <?php 
                            if ($userData->receive_promotion == 1) {
                                echo 'checked="checked"';
                            }
                        ?>
                    >
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <div class="row row-account-continous">
        <h2 class="noselect">Telefone(s)</h2>
    </div>

    <div class="row">
        <?php if (is_null($userData->phone)): ?>
            <div class="col-12 bordered bordered-line-both bordered-border">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered noselect" onclick="clearNewFoneInput(); showModal('addNumber');">Adicionar telefone...</h2>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($userData->phone as $key => $value): ?>
                <div class="col-12 bordered bordered-line-top pointered" id="foneRow" onclick="changeFoneInput('<?= $value->number; ?>', <?= $value->id; ?>); showModal('alterNumber');">
                    <div class="bordered-content bordered-align-left" id="foneHeader">
                        <h2>Telefone <span id="foneIndex"><?= ($key + 1); ?></span></h2>
                    </div>
                    <div class="bordered-data" id="foneData">
                        <h2 id="foneNumber"><?= $value->number; ?></h2>
                    </div>
                    <span class="editable">></span>
                </div>
            <?php endforeach; ?>
            <div class="col-12 bordered bordered-line-bottom bordered-border-top">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered" onclick="clearNewFoneInput(); showModal('addNumber');">Adicionar telefone...</h2>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row row-account-continous">
        <h2 class="noselect">Endereço(s)</h2>
    </div>

    <div class="row">
        <?php if (is_null($userData->address)): ?>
            <div class="col-12 bordered bordered-line-both bordered-border">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered noselect" onclick="clearNewAddressInputs(); showModal('addAddress');">Adicionar endereço...</h2>
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

    <div class="row row-account"></div>
</div>

<div class="bg-modalbg" id="alterFirstName">
	<div class="modal-container">
		<div class="closebutton pointered noselect">+</div>
		
		<h4 class="modal-text noselect">Alterar primeiro nome:</h4>
		
		<input type="text" class="alter-input" id="alterFirstNameInput" value="<?= $userData->first_name ?>">
	
		<div class="modal-options-buttons noselect">
			<button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
			<button type="button" class="modal-button save-button" id="alterFirstNameSave" onclick="
				if (updateAccount({
					'first_name': document.getElementById('alterFirstNameInput').value
				})) {
                    document.getElementById('userFirstName').innerHTML = document.getElementById('alterFirstNameInput').value;
                }
			">Salvar</button>
		</div>
	</div>
</div>

<div class="bg-modalbg" id="alterLastName">
    <div class="modal-container">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Alterar segundo nome:</h4>

        <input type="text" class="alter-input" id="alterLastNameInput" value="<?= $userData->last_name ?>">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="alterLastNameSave" onclick="
				if (updateAccount({
					'last_name': document.getElementById('alterLastNameInput').value
				})) {
                    document.getElementById('userLastName').innerHTML = document.getElementById('alterLastNameInput').value;
                }
			">Salvar</button>
        </div>
    </div>
</div>

<div class="bg-modalbg" id="alterBirthDate">
    <div class="modal-container">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Alterar data de nascimento:</h4>

        <input type="text" class="alter-input" id="alterBirthDateInput" value="<?= $userData->birth_date ?>">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="alterBirthDateSave" onclick="
				if (updateAccount({
					'birth_date': document.getElementById('alterBirthDateInput').value
				})) {
                    document.getElementById('userBirthDate').innerHTML = document.getElementById('alterBirthDateInput').value;
                }
			">Salvar</button>
        </div>
    </div>
</div>

<div class="bg-modalbg" id="alterCPF">
    <div class="modal-container">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Alterar CPF:</h4>

        <input type="text" class="alter-input" id="alterCPFInput" value="<?= $userData->cpf ?>">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="alterCPFSave" onclick="
                if (updateAccount({
					'cpf': document.getElementById('alterCPFInput').value
				})) {
                    document.getElementById('userCPF').innerHTML = document.getElementById('alterCPFInput').value;
                }
			">Salvar</button>
        </div>
    </div>
</div>

<div class="bg-modalbg" id="addNumber">
    <div class="modal-container">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Adicionar telefone:</h4>

        <input type="text" class="alter-input" id="newFoneInput" value="">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="newFoneSave" onclick="
            	if (newFone({
					'number': document.getElementById('newFoneInput').value
				})) {
                    // document.getElementById('userCPF').innerHTML = document.getElementById('newFoneInput').value;
                }
			">Adicionar</button>
        </div>
    </div>
</div>

<div class="bg-modalbg" id="alterNumber">
    <div class="modal-container">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Alterar telefone:</h4>

		<input type="hidden" id="alterFoneIdInput" value="">
        <input type="text" class="alter-input" id="alterFoneInput" value="">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="alterFoneSave" onclick="
                if (changeFone({
					'id': document.getElementById('alterFoneIdInput').value,
					'number': document.getElementById('alterFoneInput').value
				})) {
                    // document.getElementById('userCPF').innerHTML = document.getElementById('alterFoneInput').value;
                }
            ">Alterar</button>
        </div>
    </div>
</div>

<div class="bg-modalbg" id="addAddress">
    <div class="modal-container-address">
        <div class="closebutton pointered noselect">+</div>

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

<div class="bg-modalbg" id="alterAddress">
    <div class="modal-container-address">
        <div class="closebutton pointered noselect">+</div>

        <h4 class="modal-text noselect">Alterar endereço:</h4>

        <input type="hidden" id="alterAddressIdInput" value="">
        <label for="alterAddressCity" class="address-label">Cidade:</label>
        <select class="alter-input" name="alterAddressCity" id="alterAddressCity">
            <option value="1" selected>Acrelandia, AC</option>
            <option value="2">Assis Brasil, AC</option>
        </select>
        <label for="alterAddressStreet" class="address-label">Rua:</label>
        <input type="text" class="alter-input" name="alterAddressStreet" id="alterAddressStreet">
        <label for="alterAddressNumber" class="address-label">Numero:</label>
        <input type="number" class="alter-input" name="alterAddressNumber" id="alterAddressNumber">
        <label for="alterAddressComplement" class="address-label">Complemento:</label>
        <input type="text" class="alter-input" name="alterAddressComplement" id="alterAddressComplement">
        <label for="alterAddressCEP" class="address-label">CEP:</label>
        <input type="text" class="alter-input" name="alterAddressCEP" id="alterAddressCEP">

        <div class="modal-options-buttons noselect">
            <button type="button" class="modal-button cancel-button cancelModal">Cancelar</button>
            <button type="button" class="modal-button save-button" id="alterAddressSave" onclick="
                if (changeAddress({
					'city_id': document.getElementById('alterAddressCity').value,
					'street': document.getElementById('alterAddressStreet').value,
					'complement': document.getElementById('alterAddressNumber').value,
					'cep': document.getElementById('alterAddressComplement').value,
					'number': document.getElementById('alterAddressCEP').value
				})) {
                    window.location.reload();
                }
            ">Alterar</button>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script>
function showModal(id) {
	document.querySelector(`#${id}`).classList.add("show-modal");
};

function closeModal() {
	Array.from(document.getElementsByClassName('bg-modalbg')).forEach(modal => {
		if (!modal.classList.contains('show-modal')) {
			return;
		}

		modal.classList.remove("show-modal");
	});
}

Array.from(document.getElementsByClassName('closebutton')).concat(Array.from(document.getElementsByClassName('cancelModal'))).forEach(element => {
	element.addEventListener('click', closeModal);
});

async function updateAccount(data) {
	try {
        await $.ajax({
            type: 'PATCH',
            url: '<?= $mainURL ?>/me/update',
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

                        customAlert('Alterações salvas com sucesso!', 'success');
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
        customAlert('Ocorreu algum erro ao tentar atualizar suas informações!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}

function clearNewFoneInput() {
	document.getElementById('newFoneInput').value = '';
}

async function newFone(data) {
	try {
        await $.ajax({
            type: 'POST',
            url: '<?= $mainURL ?>/me/phone',
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

                        customAlert('Telefone adicionado com sucesso!', 'success');
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
        customAlert('Ocorreu algum erro ao tentar cadastrar o telefone!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}

function changeFoneInput(number, foneId = 0) {
	document.getElementById('alterFoneInput').value = number;
	document.getElementById('alterFoneIdInput').value = foneId;
}

async function changeFone(data) {
	try {
        await $.ajax({
            type: 'PATCH',
            url: '<?= $mainURL ?>/me/phone',
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

                        customAlert('Telefone atualizado com sucesso!', 'success');
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
        customAlert('Ocorreu algum erro ao tentar atualizar o telefone!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}

function clearNewAddressInputs() {
    let addAddressInput = [
        'addAddressCity',
        'addAddressStreet',
        'addAddressNumber',
        'addAddressComplement',
        'addAddressCEP'
    ];

    addAddressInput.forEach(element => {
        document.getElementById(element).value = '';
    });
}

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

async function changeAlterAddressInputs(id) {
    try {
        await $.ajax({
            type: 'GET',
            url: `<?= $mainURL ?>/me/address/${id}`,
            cache: false,
            async: false,
            headers: { 
                'Authorization': `Bearer <?= $userJWT ?? '' ?>`,
                'Accept': 'application/json',
            },
            success: (data, textStatus, jqXHR) => {
                switch (jqXHR.statusCode().status) {
                    case 200:
                        if (!data) {
                            throw '';
                        }

                        console.log(data);

                        document.getElementById('alterAddressCity').value = data.message.city_id;
                        document.getElementById('alterAddressStreet').value = data.message.street;
                        document.getElementById('alterAddressNumber').value = data.message.number;
                        document.getElementById('alterAddressComplement').value = data.message.complement;
                        document.getElementById('alterAddressCEP').value = data.message.cep;
                        break;
                    default: throw ''; break;
                }
                return true;
            },
            error: () => { throw ''; }
        });
    }
    catch (err) {
        customAlert('Ocorreu algum erro ao buscar este endereço!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}

async function changeAddress(data) {
	try {
        await $.ajax({
            type: 'PATCH',
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

                        customAlert('Endereço atualizado com sucesso!', 'success');
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
        customAlert('Ocorreu algum erro ao tentar atualizar o endereço!', 'error');
        setTimeout(() => { closeModal(); }, 25);
        return false;
    }

    return true;
}

</script>
<?php $v->end(); ?>
