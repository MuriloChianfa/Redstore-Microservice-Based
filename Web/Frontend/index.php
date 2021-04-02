<?php
ob_start();
session_start();

require __DIR__."/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace("Source\Controllers");

/**
 * WEB
 */
$router->group(null);
$router->get("/", "Web:home", "web.home");
$router->get("/products", "Web:products", "web.products");
$router->get("/product", "Web:productsDetails", "web.productsDetails");
$router->get("/cart", "Web:cart", "web.cart");

/**
 * LOGIN
 */
$router->group(null);
$router->get("/login", "Login:loginn", "login.login");
// $router->get("/cadastrar", "Web:register", "web.register");
// $router->get("/recuperar", "Web:forget", "web.forget");
// $router->get("/senha/{email}/{forget}", "Web:reset", "web.reset");

/**
 * AUTH
 */
// $router->group(null);
// $router->post("/login", "Auth:login", "auth.login");
// $router->post("/register", "Auth:register", "auth.register");
// $router->post("/forget", "Auth:forget", "auth.forget");
// $router->post("/reset", "Auth:reset", "auth.reset");

/**
 * AUTH SOCIAL
 */

/**
 * PROFILE
 */
// $router->group("/me");
// $router->get("/", "App:home", "app.home");
// $router->get("/sair", "App:logoff", "app.logoff");

/**
 * ERRORS
 */
$router->group("ops");
$router->get("/{errcode}", "Web:error", "web.error");

/**
 * ROUTE PROCESS
 */
$router->dispatch();

/**
 * ERRORS PROCESS
 */
if($router->error()) {
    $router->redirect("web.error", ["errcode" => $router->error()]);
}

ob_end_flush();
