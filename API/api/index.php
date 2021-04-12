<?php

ob_start();

require __DIR__ . "/vendor/autoload.php";

use Source\Core\Response;

/**
 * BOOTSTRAP
 */
use CoffeeCode\Router\Router;

$route = new Router(url(), ":");

/**
 * LOGIN
 */
$route->namespace("Source\Controllers")->group("/");
/** POST */ ## NO AUTH
$route->post("/login", "Auth:login");
$route->post("/register", "Auth:register");
$route->post("/forget", "Auth:forget");
$route->post("/reset", "Auth:reset");
$route->post("/exit", "Auth:logoff");

/**
 * PRODUCTS 
 */
$route->namespace("Source\Controllers")->group("/");
/** GET */ ## NO AUTH
$route->get("/products", "Products:products");
$route->get("/products/{page}/{limit}", "Products:products");
$route->get("/product/{id}", "Products:product");
/** POST */ ## ADMIN AUTH REQUIRED
$route->post("/product", "Products:addProduct");
$route->patch("/product", "Products:alterProduct");

/**
 * PRODUCTS 
 */
$route->namespace("Source\Controllers")->group("/");
/** GET */ ## NO AUTH
$route->get("/categories", "Categories:categories");
$route->get("/category/{id}", "Categories:category");
/** POST */ ## ADMIN AUTH REQUIRED
$route->post("/category", "Categories:addCategory");

/**
 * PROFILE
 */
$route->namespace("Source\Controllers")->group("/me");
/** GET */ ## AUTH REQUIRED
$route->get("/profile", "Profile:profile-get");
$route->get("/favorite", "Profile:favorite-get");
$route->get("/history", "Profile:history-get");
$route->get("/cart", "Profile:cart-get");
/** POST */ ## AUTH REQUIRED
$route->post("/profile", "Profile:profile");
$route->post("/favorite", "Profile:favorite");
$route->post("/history", "Profile:history");
$route->post("/cart", "Profile:cart");

/**
 * WEB ROUTES
 */
$route->namespace("Source\Controllers")->group("/");
/** GET */ ## NO AUTH
$route->get("/test", "App:test");

/**
 * ERROR ROUTES
 */
$route->namespace("Source\Controllers")->group("/error");
$route->get("/{errcode}", "App:error");

/**
 * ROUTE
 */
try {
    $route->dispatch();
} 
catch (\Throwable $throwable) {
    $Message = new stdClass();
    $Message->status = '500 ' . HTTP_500;
    $Message->message = $throwable->getMessage();

    (new Response())->setStatusCode(HTTP_INTERNAL_SERVER_ERROR)->send($Message);
}


/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/error/{$route->error()}");
}

ob_end_flush();
