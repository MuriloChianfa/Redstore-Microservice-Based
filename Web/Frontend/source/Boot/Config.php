<?php

define('SITE', [
    'name' => 'A loja virtual',
    'desc' => 'A verdadeira plataforma de ecommerce',
    'domain' => 'redstore.codedrop.com.br',
    'locale' => 'pt_BR',
    'root' => 'https://' . getenv('MAIN_IP')
]);

define('BASE_API', 'https://' . getenv('MAIN_IP') . '/api');
define('CONF_URL_BASE', 'https://' . getenv('MAIN_IP'));

// if ($_SERVER['SERVER_NAME'] == 'localhost') {
//     require __DIR__ . '/Minify.php';
// }

define('SOCIAL', [
    'facebook_page' => '123',
    'facebook_author' => '123',
    'facebook_appId' => '123',
    'twitter_creator' => '123',
    'twitter_site' => '123'
]);

define('FACEBOOK_LOGIN', []);

define('GOOGLE_LOGIN', []);

define('DEFAULT_COUNTRY', 'US');
