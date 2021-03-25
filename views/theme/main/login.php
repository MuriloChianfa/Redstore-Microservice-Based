<?php $v->layout("theme/_theme"); ?>

<div class="account-page">
    <div class="cointainer">
        <div class="row">
            <div class="col-2">
                <img src="<?= asset("/images/image1.png"); ?>" width="100%">
            </div>
            <div class="col-2">
                <div class="form-container">
                    <div class="login_form_callback">
                        <?= flash(); ?>
                    </div>

                    <div class="form-btn">
                        <span onclick="login()">Login</span>
                        <span onclick="register()">Register</span>
                        <hr id="Indicator">
                    </div>

                    <form class="form" action="<?= $router->route("auth.login"); ?>" method="post" autocomplete="off" id="LoginForm">
                        <input name="email" type="text" placeholder="Email" />
                        <input name="password" type="password" placeholder="Password" />
                        <button type="submit" class="btn">Login</button>
                        <a>Forgot password</a>
                    </form>

                    <form class="form" action="<?= $router->route("auth.register"); ?>" method="post" autocomplete="off" id="RegForm">
                        <input name="name" type="text" placeholder="Username" />
                        <input name="email" type="email" placeholder="Email" />
                        <input name="password" type="password" placeholder="Password" />
                        <button type="submit" class="btn">Register</button>
                    </form>

                    <!-- <a href="<?= $router->route("auth.facebook"); ?>" class="btn btn-facebook">Facebook Login</a>
                    <a href="<?= $router->route("auth.google"); ?>" class="btn btn-google">Google Login</a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/login-style.js"); ?>"></script>

<script src="<?= asset("/js/form.js"); ?>"></script>
<?php $v->end(); ?>
