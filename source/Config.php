<?php 

define("SITE", [
    "name" => "A loja virtual",
    "desc" => "A verdadeira plataforma de ecommerce",
    "domain" => "redstore.codedrop.com.br",
    "locale" => "pt_BR",
    "root" => "http://127.0.0.1/Github/RedStore"
]);

// DESCOMENTAR APENAS PARA FAZER OS MINIFY

// if($_SERVER['SERVER_NAME'] == "localhost") {
//     require __DIR__ . "/Minify.php";
// }

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "auth",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

define("SOCIAL", [
    "facebook_page" => "robsonvleite2",
    "facebook_author" => "robsonvleite",
    "facebook_appId" => "2193729837289",
    "twitter_creator" => "@robsonvleite",
    "twitter_site" => "@robsonvleite"
]);

define("MAIL", [
    "host" => "",
    "port" => "",
    "user" => "",
    "passwd" => "",
    "from_name" => "Murilo Chianfa",
    "from_email" => "tibiaparainiciantes@outlook.com"
]);

define("FACEBOOK_LOGIN", []);

define("GOOGLE_LOGIN", []);
