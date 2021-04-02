<?php $v->layout("theme/_theme"); ?>

<div class="account-page">
    <div class="cointainer">
        <div class="row">
            <div class="col-2">
                <img src="<?= asset("/images/image1.png"); ?>" width="100%">
            </div>
            <div class="col-2">
                <div class="form-container">
                    <div class="form-btn">
                        <span onclick="login()">Login</span>
                        <span onclick="register()">Register</span>
                        <hr id="Indicator">
                    </div>

                    <form id="LoginForm">
                        <input type="text" placeholder="Username" />
                        <input type="password" placeholder="Password" />
                        <button type="submit" class="btn">Login</button>
                        <a>Forgot password</a>
                    </form>

                    <form id="RegForm">
                        <input type="text" placeholder="Username" />
                        <input type="email" placeholder="Email" />
                        <input type="password" placeholder="Password" />
                        <button type="submit" class="btn">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("/js/login.js"); ?>"></script>
<?php $v->end(); ?>
