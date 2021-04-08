<?php $v->layout("theme/_theme"); ?>

<div class="account-page">
    <div class="cointainer">
        <div class="row">
            <div class="col-2">
                <img src="<?= asset("/images/image1.png"); ?>" width="100%">
            </div>
            
            <div class="col-2">
                <div class="form-message">
                    <div class="login_form_callback">
                        <?= flash(); ?>
                    </div>
                </div>

                <div class="form-container">
                    <div class="form-btn">
                        <a href="<?= $router->route("login.login"); ?>"><span>Login</span></a>
                        <span>Forget</span>
                        <hr id="Indicator-register">
                    </div>

                    <form class="form" action="<?= $router->route("auth.forget"); ?>" method="POST" autocomplete="off" id="LoginForm">
                        <input name="password" type="password" placeholder="Password" />
                        <input name="password" type="password" placeholder="Password Again" />
                        <button type="submit" class="btn">Send</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $v->end(); ?>
