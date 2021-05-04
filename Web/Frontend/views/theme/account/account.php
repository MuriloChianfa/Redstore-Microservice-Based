<?php $v->layout("theme/_theme"); ?>

<!------------ PROFILE PAGE ------------->

<div class="minimal-container">

    <div class="row row-account-img"></div>

    <div class="row">
        <div class="small-user-img user-img">
            <img src="<?= asset("/images/user-2.png"); ?>" class="small-img" width="100%">
        </div>
    </div>

    <div class="row row-account">
        <h2>Dados da conta</h2>
        <a>Status da conta: &nbsp;&nbsp;<small>Não confirmada</small></a>
    </div>

    <div class="row">
        <div class="col-12 bordered bordered-line-top pointered" onclick="alert('alterar primeiro nome')">
            <div class="bordered-content bordered-align-left">
                <h2>Primeiro nome</h2>
            </div>
            <div class="bordered-data">
                <h2><?= $userData->first_name ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line pointered" onclick="alert('alterar primeiro nome')">
            <div class="bordered-content bordered-align-left">
                <h2>Segundo nome</h2>
            </div>
            <div class="bordered-data">
                <h2><?= $userData->last_name ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line">
            <div class="bordered-content bordered-align-left">
                <h2>E-mail</h2>
            </div>
            <div class="bordered-data">
                <h2><?= $userData->email ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line-bottom bordered-border-top">
            <div class="bordered-content bordered-align-left">
                <h2>Senha</h2>
            </div>
            <div class="bordered-data">
                <h2>************</h2>
            </div>
            <span class="editable">></span>
        </div>
    </div>

    <div class="row row-account-continous">
        <h2>Dados pessoais</h2>
    </div>

    <div class="row">
        <div class="col-12 bordered bordered-line-top pointered" onclick="alert('alterar data nascimento')">
            <div class="bordered-content bordered-align-left">
                <h2>Data de nascimento</h2>
            </div>
            <div class="bordered-data">
                <h2><?= date_fmt($userData->birth_date); ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line pointered" onclick="alert('alterar cpf')">
            <div class="bordered-content bordered-align-left">
                <h2>CPF</h2>
            </div>
            <div class="bordered-data">
                <h2><?= $userData->cpf ?></h2>
            </div>
            <span class="editable">></span>
        </div>
        <div class="col-12 bordered bordered-line-bottom bordered-border-top">
            <div class="bordered-content bordered-align-left">
                <h2>Promoções via E-mail</h2>
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
        <h2>Telefone(s)</h2>
    </div>

    <div class="row">
        <?php if (is_null($userData->phone)): ?>
            <div class="col-12 bordered bordered-line-both bordered-border">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered" onclick="alert('adicionar telefone');">Adicionar telefone...</h2>
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
        <h2>Endereço(s)</h2>
    </div>

    <div class="row">
        <?php if (is_null($userData->address)): ?>
            <div class="col-12 bordered bordered-line-both bordered-border">
                <div class="bordered-content bordered-align-left">
                    <h2 class="pointered" onclick="alert('adicionar endereco');">Adicionar endereço...</h2>
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
                    <h2 class="pointered" onclick="alert('adicionar telefone');">Adicionar endereço...</h2>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row row-account"></div>
</div>

<script>
    
</script>
