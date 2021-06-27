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
                    <h2 class="pointered noselect" onclick="alert('adicionar telefone');">Adicionar telefone...</h2>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($userData->phone as $key => $value): ?>
                <div class="col-12 bordered bordered-line-top">
                    <div class="bordered-content bordered-align-left">
                        <h2>Telefone <?= ($key + 1); ?></h2>
                    </div>
                    <div class="bordered-data">
                        <h2><?= $value->number; ?></h2>
                    </div>
                    <span class="editable">></span>
                </div>
            <?php endforeach; ?>
            <div class="col-12 bordered bordered-line-bottom bordered-border-top">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered" onclick="alert('adicionar telefone');">Adicionar telefone...</h2>
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
                    <h2 class="pointered noselect" onclick="alert('adicionar endereco');">Adicionar endereço...</h2>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($userData->address as $key => $value): ?>
                <div class="col-12 bordered bordered-line-top">
                    <div class="bordered-content bordered-align-left">
                        <h2><strong>Endereço <?= ($key + 1); ?></strong></h2>
                        <h2>Cidade, Estado</h2>
                        <h2>CEP</h2>
                        <h2>Rua</h2>
                        <h2>Número</h2>
                        <h2>Complemento</h2>
                    </div>
                    <div class="bordered-data-address">
                        <h2>Arua, Bahia</h2>
                        <h2>41501-143</h2>
                        <h2>Rua 1</h2>
                        <h2>86</h2>
                        <h2>3 Andar</h2>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="col-12 bordered bordered-line-bottom bordered-border-top">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered noselect" onclick="alert('adicionar telefone');">Adicionar endereço...</h2>
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
                        setTimeout(() => { closeModal(); }, 25);
                        break;
                    case 206:
                        if (!data) {
                            throw '';
                        }

                        customAlert(data.message, 'warning');
                        setTimeout(() => { closeModal(); }, 25);
                        break;
                    default: throw ''; break;
                }

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

</script>

