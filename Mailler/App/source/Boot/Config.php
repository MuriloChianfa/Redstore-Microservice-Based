<?php

/**
 * RABBITMQ
 */
define('RABBITMQ_HOST', '172.16.239.10');
define('RABBITMQ_PORT', 5672);
define('RABBITMQ_USER', 'admin');
define('RABBITMQ_PASS', 'admin');
define('RABBITMQ_QUEUE', 'email');
define('RABBITMQ_EXCHANGER', 'email');

/**
 * REDIS
 */
define('CONF_REDIS_HOST', '172.16.241.12');
define('CONF_REDIS_SCHEME', 'tcp');
define('CONF_REDIS_PORT', 6379);
define('CONF_REDIS_PASS', '');

/**
 * MAIL
 */
define('CONF_MAIL_HOST', getenv('MAIL_HOST') ?? 'smtp.sendgrid.net');
define('CONF_MAIL_PORT', getenv('MAIL_PORT') ?? '587');
define('CONF_MAIL_USER', getenv('MAIL_USER') ?? 'apikey');
define('CONF_MAIL_SENDER', ['name' => getenv('MAIL_SENDER_NAME') ?? '', 'address' => getenv('MAIL_SENDER_ADDRESS') ?? '']);
define('CONF_MAIL_SUPPORT', getenv('MAIL_SUPPORT') ?? '');
define('CONF_MAIL_OPTION_LANG', getenv('MAIL_OPTION_LANG') ?? 'br');
define('CONF_MAIL_OPTION_HTML', true);

$auth = false;
if (!empty(@getenv('MAIL_OPTION_AUTH'))) {
    if (getenv('MAIL_OPTION_AUTH') == 'true') {
        $auth = true;
    }
}

$smtp = false;
if (!empty(@getenv('MAIL_OPTION_SMTP'))) {
    if (getenv('MAIL_OPTION_SMTP') == 'true') {
        $smtp = true;
    }
}

define('CONF_MAIL_OPTION_AUTH', $auth);
define('CONF_MAIL_OPTION_SMTP', $smtp);

unset($auth);
unset($smtp);

define('CONF_MAIL_OPTION_SECURE', getenv('MAIL_OPTION_SECURE') ?? 'tls');
define('CONF_MAIL_OPTION_CHARSET', getenv('MAIL_OPTION_CHARSET') ?? 'utf-8');

/**
 * DATES
 */
define('DATE_BR', 'd/m/Y H:i:s');
define('DATE_API', 'Y-m-d H:i:s');
