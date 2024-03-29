<?php

@ob_start();

require __DIR__ . '/vendor/autoload.php';

use Source\Core\Response;
use \Source\Logger\Log;

/**
 * BOOTSTRAP
 */
use CoffeeCode\Router\Router;

$route = new Router(url(), ':');

Log::init();

/**
 * LOGIN
 */
$route->namespace('Source\Controllers')->group('/');
/** POST */ ## NO AUTH
$route->post('/login', 'Auth:login');
$route->post('/register', 'Auth:register');
$route->post('/forget', 'Auth:forget');
$route->post('/reset', 'Auth:reset');
$route->post('/exit', 'Auth:logoff');

/**
 * PRODUCTS 
 */
$route->namespace('Source\Controllers')->group('/');
/** GET */ ## NO AUTH
$route->get('/products', 'Products:products');
$route->get('/products/{page}/{limit}', 'Products:products');
$route->get('/products/{page}/{limit}/{order}/{direction}', 'Products:products');
$route->get('/products/{page}/{limit}/{order}/{direction}/{filterColumn}/{filterValue}', 'Products:products');
$route->get('/products/{page}/{limit}/{order}/{direction}/{filterColumn}/{filterValue}/{selfId}', 'Products:products');
$route->get('/product/{id}', 'Products:product');
/** POST */ ## ADMIN AUTH REQUIRED
$route->post('/product', 'Products:addProduct');
$route->post('/product-image/{id}', 'Products:addProductImage');
$route->post('/product-checkout', 'Products:checkoutSuccess');
$route->delete('/product-image/{id}', 'Products:deleteProductImage');
$route->patch('/product', 'Products:alterProduct');

/**
 * CATEGORIES 
 */
$route->namespace('Source\Controllers')->group('/');
/** GET */ ## NO AUTH
$route->get('/categories', 'Categories:categories');
$route->get('/category/{id}', 'Categories:category');
/** POST */ ## ADMIN AUTH REQUIRED
$route->post('/category', 'Categories:addCategory');

/**
 * PROFILE
 */
$route->namespace('Source\Controllers')->group('/me');
/** POST */ ## AUTH REQUIRED
$route->post('/profile', 'Profile:profile');
$route->patch('/update', 'Profile:update');
// Phone
$route->post('/phone', 'PhoneController:addPhone');
$route->patch('/phone', 'PhoneController:updatePhone');
// Address
$route->get('/address/{id}', 'AddressController:address');
$route->post('/address', 'AddressController:addAddress');
$route->patch('/address', 'AddressController:updateAddress');

$route->post('/favorite', 'Profile:favorite');
$route->post('/history', 'Profile:history');
$route->post('/cart', 'Profile:cart');

/**
 * WEB ROUTES
 */
$route->namespace('Source\Controllers')->group('/');
/** GET */ ## NO AUTH
$route->get('/test', 'App:test');

/**
 * ERROR ROUTES
 */
$route->namespace('Source\Controllers')->group('/error');
$route->get('/{errcode}', 'App:error');

/**
 * ROUTE
 */
try {
    $route->dispatch();
} catch (\Throwable $throwable) {
    $Message = new stdClass();
    $Message->status = '500 ' . HTTP_500;
    $Message->message = $throwable->getMessage();

    Log::error($throwable->getMessage());

    (new Response())->setStatusCode(HTTP_INTERNAL_SERVER_ERROR)->send($Message);
}


/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/error/{$route->error()}");
}

@ob_end_flush();
@closelog();
