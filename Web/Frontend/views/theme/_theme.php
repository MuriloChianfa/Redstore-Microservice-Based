<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?= $head; ?>

    <link rel="icon" type="image/png" href="<?= asset("/images/favicon.png"); ?>" />
    <link rel="stylesheet" href="<?= asset("/css/message.css"); ?>" />
    <link rel="stylesheet" href="<?= asset("/css/load.css"); ?>" />
    <link rel="stylesheet" href="<?= asset("/css/style.css"); ?>" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>

    <div class="ajax_load">
        <div class="ajax_load_box">
            <div class="ajax_load_box_circle"></div>
            <div class="ajax_load_box_title">Aguarde, carrengando...</div>
        </div>
    </div>

    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="<?= $router->route("web.home"); ?>"><img src="<?= asset("/images/logo.png"); ?>" alt="Website Logo" width="125px"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="<?= $router->route("web.home"); ?>">Home</a></li>
                    <li><a href="<?= $router->route("web.products"); ?>">Products</a></li>
                    <li><a href="<?= $router->route("web.home"); ?>">About</a></li>
                    <li><a href="<?= $router->route("web.home"); ?>">Contact</a></li>
                    <li><a href="<?= $router->route("login.login"); ?>">Account</a></li>
                </ul>
            </nav>
            <a href="<?= $router->route("web.cart"); ?>"><img src="<?= asset("/images/cart.png"); ?>" alt="cart" width="30px" height="30px"></a>
            <img src="<?= asset("/images/menu.png"); ?>" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>

    <main class="main_content">
        <?= $v->section("content"); ?>
    </main>

    <?php include 'main/footer.php'; ?>

    <script src="<?= asset("/js/jquery.js"); ?>"></script>
    <script src="<?= asset("/js/jquery-ui.js"); ?>"></script>
    <script src="<?= asset("/js/footer.js"); ?>"></script>
    <script src="<?= asset("/js/form.js"); ?>"></script>

    <?= $v->section("scripts"); ?>
</body>
</html>
