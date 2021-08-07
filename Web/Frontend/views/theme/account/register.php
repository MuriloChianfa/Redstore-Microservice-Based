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
                        <span>Register</span>
                        <hr id="Indicator-register">
                    </div>

                    <form class="form" action="<?= $router->route("auth.register"); ?>" method="post" autocomplete="off" id="RegForm">
                        <input name="first_name" type="text" placeholder="First name" />
                        <input name="last_name" type="text" placeholder="Last name" />
                        <input name="email" type="email" placeholder="Email" />
                        <input name="password" type="password" placeholder="Password" />
                        <button type="submit" class="btn">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $v->end(); ?>
