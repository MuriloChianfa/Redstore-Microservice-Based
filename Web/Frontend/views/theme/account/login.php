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
                        <span>Login</span>
                        <a href="<?= $router->route("login.register"); ?>"><span>Register</span></a>
                        <hr id="Indicator-login">
                    </div>

                    <form class="form" action="<?= $router->route("auth.login"); ?>" method="post" autocomplete="off" id="LoginForm">
                        <input name="email" type="text" placeholder="Email" />
                        <input name="password" type="password" placeholder="Password" />
                        <button type="submit" class="btn">Login</button>

                        <a href="<?= $router->route("login.forget"); ?>">Forgot password</a>

                        <a href="<?= $router->route("auth.facebook"); ?>"><img class="login-facebook-button" src="<?= asset("/images/facebook-button.png"); ?>"></img></a>
                        <a href="<?= $router->route("auth.google"); ?>"><img class="login-google-button" src="<?= asset("/images/google-button.png"); ?>"></img></a>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $v->end(); ?>
