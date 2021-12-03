<?php

@ob_start();
@session_start();

require __DIR__ . '/vendor/autoload.php';

@set_error_handler('errorHandler');
@set_exception_handler('exceptionHandler');

$_SERVER['REMOTE_ADDR'] = getallheaders()['X-Real-IP'];

use CoffeeCode\Router\Router;
use \Source\Language\Locale;
use \Source\Logger\Log;

$router = new Router(site());
$router->namespace('Source\Controllers');

Locale::init();
Log::init();

/**
 * WEB
 */
$router->group(null);
$router->get('/', 'Web:home', 'web.home');
$router->get('/products', 'Web:products', 'web.products');
$router->get('/products/{page}', 'Web:products', 'web.products');
$router->get('/products/{sort}/{page}', 'Web:products', 'web.products');
$router->get('/product/{id}', 'Web:productsDetails', 'web.productsDetails');
$router->get('/about', 'Web:about', 'web.about');
$router->get('/cart', 'Web:cart', 'web.cart');
// Checkout
$router->group('/checkout');
$router->get('/select-address', 'Checkout:selectAddress', 'checkout.selectAddress');
$router->get('/payment-method', 'Checkout:paymentMethod', 'checkout.paymentMethod');
$router->get('/method/boleto', 'Checkout:boleto', 'checkout.boleto');
$router->get('/method/credit', 'Checkout:credit', 'checkout.credit');
$router->get('/method/debit', 'Checkout:debit', 'checkout.debit');
$router->get('/success', 'Checkout:success', 'checkout.success');

// Products
$router->get('/product/insert', 'Web:productInsert', 'web.productInsert');
$router->post('/product/insert', 'Products:insert', 'products.insert');
$router->post('/product/image/insert', 'Products:image', 'products.image');

/**
 * LOGIN
 */
$router->group(null);
$router->get('/login', 'Login:loginn', 'login.login');
$router->get('/login/facebook', 'Login:loginn', 'auth.facebook');
$router->get('/login/google', 'Login:loginn', 'auth.google');
$router->get('/forget', 'Login:forget', 'login.forget');
$router->get('/reset/{email}/{forget}', 'Login:reset', 'login.reset');
$router->get('/register', 'Login:register', 'login.register');

/**
 * AUTH
 */
// $router->group(null);
$router->post('/login', 'Auth:login', 'auth.login');
$router->post('/register', 'Auth:register', 'auth.register');
$router->post('/forget', 'Auth:forget', 'auth.forget');
$router->post('/reset', 'Auth:reset', 'auth.reset');

/**
 * AUTH SOCIAL
 */
// $router->post('/login/facebook', 'Auth:loginFacebook', 'auth.loginFacebook');

/**
 * PROFILE
 */
$router->group('/me');
$router->get('/', 'App:account', 'app.account');
$router->get('/logoff', 'App:logoff', 'app.logoff');

/**
 * ERRORS
 */
$router->group('ops');
$router->get('/{errcode}', 'Web:error', 'web.error');

/**
 * ROUTE PROCESS
 */
$router->dispatch();

/**
 * ERRORS PROCESS
 */
if ($router->error()) {
    $router->redirect('web.error', ['errcode' => $router->error()]);
}

@ob_end_flush();
@closelog();
