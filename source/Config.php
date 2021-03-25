<?php 

define('SITE', [
    'name' => 'A loja virtual',
    'desc' => 'A verdadeira plataforma de ecommerce',
    'domain' => 'redstore.codedrop.com.br',
    'locale' => 'pt_BR',
    'root' => 'http://127.0.0.1/Github/RedStore'
]);

define('BASE_API', 'https://127.0.0.1/api');

// DESCOMENTAR APENAS PARA FAZER OS MINIFY

// if($_SERVER['SERVER_NAME'] == 'localhost') {
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
