<?php

/**
 * @param \Throwable $exception
 * @return void
 */
function exceptionHandler($exception) {
    $errorCode = @$exception->getCode();
    $errorMessage = @$exception->getMessage();

    if (!empty($exception->getTrace())) {
        $errorLine = @$exception->getTrace()[0]['line'] ?? '';
        $errorFile = @$exception->getTrace()[0]['file'] ?? '';
    }

    error_log((empty($errorLine)) ? "[{$errorCode}] {$errorMessage}" : "[{$errorCode}] {$errorMessage} on line {$errorLine} of file {$errorFile}");

    header('Location: /500');
    exit;
}

/**
 * @param int $errno
 * @param string $errstr
 * @param string $errfile
 * @param int $errline
 * @return void
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
    exceptionHandler(new ErrorException($errstr, 0, $errno, $errfile, $errline));
}

set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');

ob_start();
@session_start();

require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(site());
$router->namespace('Source\Controllers');

/**
 * WEB
 */
$router->group(null);
$router->get('/', 'Web:home', 'web.home');
$router->get('/products', 'Web:products', 'web.products');
$router->get('/products/{page}', 'Web:products', 'web.products');
$router->get('/product/{id}', 'Web:productsDetails', 'web.productsDetails');
$router->get('/about', 'Web:about', 'web.about');
$router->get('/cart', 'Web:cart', 'web.cart');

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
if($router->error()) {
    $router->redirect('web.error', ['errcode' => $router->error()]);
}

ob_end_flush();
