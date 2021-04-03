<?php

/**
 * RABBITMQ
 */
define("RABBITMQ_HOST", "172.16.239.10");
define("RABBITMQ_PORT", 5672);
define("RABBITMQ_USER", "mailler");
define("RABBITMQ_PASS", "22c6eb2978adf441f9a4b3448e7999f7");

/**
 * REDIS
 */
define("CONF_REDIS_HOST", "172.16.241.12");
define("CONF_REDIS_SCHEME", "tcp");
define("CONF_REDIS_PORT", 6379);
define("CONF_REDIS_PASS", "");

/**
 * MAIL
 */
define("CONF_MAIL_HOST", "smtp.sendgrid.net");
define("CONF_MAIL_PORT", "587");
define("CONF_MAIL_USER", "");
define("CONF_MAIL_PASS", "");
define("CONF_MAIL_SENDER", ["name" => "", "address" => ""]);
define("CONF_MAIL_SUPPORT", "");
define("CONF_MAIL_OPTION_LANG", "br");
define("CONF_MAIL_OPTION_HTML", true);
define("CONF_MAIL_OPTION_AUTH", true);
define("CONF_MAIL_OPTION_SECURE", "tls");
define("CONF_MAIL_OPTION_CHARSET", "utf-8");

/**
 * DATES
 */
define("DATE_BR", "d/m/Y H:i:s");
define("DATE_API", "Y-m-d H:i:s");

/**
 * UPLOAD
 */
define("CONF_UPLOAD_DIR", "storage");
define("CONF_UPLOAD_TEMPLATE_DIR", "templates");
define("CONF_UPLOAD_FILE_DIR", "files");
define("CONF_UPLOAD_IMAGE_DIR", "images");
define("CONF_UPLOAD_MEDIA_DIR", "medias");

/**
 * JWT
 */
define("CONF_JWT_CONTEXT", ['typ' => 'JWT', 'alg' => 'HS256']);
define("CONF_JWT_SECRET", 'SECRET');
