<?php

$enviroment = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..', '.env');
$enviroment->load();

/**
 * PROJECT URLs
 */
define('CONF_URL_BASE', $_ENV['PROD_URL']);
define('CONF_URL_TEST', $_ENV['DEV_URL']);

/**
 * DATABASE
 */
define('CONF_DB_HOST', $_ENV['DB_HOST']);
define('CONF_DB_USER', $_ENV['DB_USER']);
define('CONF_DB_PASS', $_ENV['DB_PASS']);
define('CONF_DB_NAME', $_ENV['DB_NAME']);

# redis cache
define('CONF_REDIS_HOST', $_ENV['REDIS_HOST']);
define('CONF_REDIS_SCHEME', $_ENV['REDIS_SCHEME']);
define('CONF_REDIS_PORT', $_ENV['REDIS_PORT']);
define('CONF_REDIS_PASS', $_ENV['REDIS_PASS']);

# rabbitmq
define('CONF_RABBITMQ_HOST', $_ENV['RABBITMQ_HOST']);
define('CONF_RABBITMQ_PORT', $_ENV['RABBITMQ_PORT']);
define('CONF_RABBITMQ_USER', $_ENV['RABBITMQ_USER']);
define('CONF_RABBITMQ_PASS', $_ENV['RABBITMQ_PASS']);

/**
 * DATES
 */
define('CONF_DATE_BR', 'd/m/Y H:i:s');
define('CONF_DATE_APP', 'Y-m-d H:i:s');

/**
 * PASSWORD
 */
define('CONF_PASSWD_MIN_LEN', 8);
define('CONF_PASSWD_MAX_LEN', 40);
define('CONF_PASSWD_ALGO', PASSWORD_DEFAULT);
define('CONF_PASSWD_OPTION', ['cost' => 10]);

/**
 * UPLOAD
 */
define('CONF_UPLOAD_DIR', 'storage');
define('CONF_UPLOAD_IMAGE_DIR', 'images');
define('CONF_UPLOAD_FILE_DIR', 'files');
define('CONF_UPLOAD_MEDIA_DIR', 'medias');

/**
 * IMAGES
 */
define('CONF_IMAGE_CACHE', CONF_UPLOAD_DIR . '/' . CONF_UPLOAD_IMAGE_DIR . '/cache');
define('CONF_IMAGE_SIZE', 2000);
define('CONF_IMAGE_QUALITY', ['jpg' => 75, 'png' => 5]);

/**
 * JWT
 */
define('CONF_JWT_CONTEXT', ['typ' => 'JWT', 'alg' => 'HS256']);
define('CONF_JWT_SECRET', $_ENV['JWT_SECRET']);

/**
 * HTTP
 */
define('HTTP_CONTINUE', 100);
define('HTTP_SWITCHING_PROTOCOLS', 101);
define('HTTP_OK', 200);
define('HTTP_CREATED', 201);
define('HTTP_ACCEPTED', 202);
define('HTTP_NON_AUTHORITATIVE_INFORMATION', 203);
define('HTTP_NO_CONTENT', 204);
define('HTTP_RESET_CONTENT', 205);
define('HTTP_PARTIAL_CONTENT', 206);
define('HTTP_MULTIPLE_CHOICES', 300);
define('HTTP_MOVED_PERMANENTLY', 301);
define('HTTP_MOVED_TEMPORARILY', 302);
define('HTTP_SEE_OTHER', 303);
define('HTTP_NOT_MODIFIED', 304);
define('HTTP_USE_PROXY', 305);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_UNAUTHORIZED', 401);
define('HTTP_PAYMENT_REQUIRED', 402);
define('HTTP_FORBIDDEN', 403);
define('HTTP_NOT_FOUND', 404);
define('HTTP_METHOD_NOT_ALLOWED', 405);
define('HTTP_NOT_ACCEPTABLE', 406);
define('HTTP_PROXY_AUTHENTICATION_REQUIRED', 407);
define('HTTP_REQUEST_TIME_OUT', 408);
define('HTTP_CONFLICT', 409);
define('HTTP_GONE', 410);
define('HTTP_LENGTH_REQUIRED', 411);
define('HTTP_PRECONDITION_FAILED', 412);
define('HTTP_REQUEST_ENTITY_TOO_LARGE', 413);
define('HTTP_REQUEST_URI_TOO_LARGE', 414);
define('HTTP_UNSUPPORTED_MEDIA_TYPE', 415);
define('HTTP_INTERNAL_SERVER_ERROR', 500);
define('HTTP_NOT_IMPLEMENTED', 501);
define('HTTP_BAD_GATEWAY', 502);
define('HTTP_SERVICE_UNAVAILABLE', 503);
define('HTTP_GATEWAY_TIME_OUT', 504);
define('HTTP_VERSION_NOT_SUPPORTED', 505);

define('HTTP_100', 'Continue');
define('HTTP_101', 'Switching Protocols');
define('HTTP_200', 'OK');
define('HTTP_201', 'Created');
define('HTTP_202', 'Accepted');
define('HTTP_203', 'Non-Authoritative Information');
define('HTTP_204', 'No Content');
define('HTTP_205', 'Reset Content');
define('HTTP_206', 'Partial Content');
define('HTTP_300', 'Multiple Choices');
define('HTTP_301', 'Moved Permanently');
define('HTTP_302', 'Moved Temporarily');
define('HTTP_303', 'See Other');
define('HTTP_304', 'Not Modified');
define('HTTP_305', 'Use Proxy');
define('HTTP_400', 'Bad Request');
define('HTTP_401', 'Unauthorized');
define('HTTP_402', 'Payment Required');
define('HTTP_403', 'Forbidden');
define('HTTP_404', 'Not Found');
define('HTTP_405', 'Method Not Allowed');
define('HTTP_406', 'Not Acceptable');
define('HTTP_407', 'Proxy Authentication Required');
define('HTTP_408', 'Request Time-out');
define('HTTP_409', 'Conflict');
define('HTTP_410', 'Gone');
define('HTTP_411', 'Length Required');
define('HTTP_412', 'Precondition Failed');
define('HTTP_413', 'Request Entity Too Large');
define('HTTP_414', 'Request-URI Too Large');
define('HTTP_415', 'Unsupported Media Type');
define('HTTP_500', 'Internal Server Error');
define('HTTP_501', 'Not Implemented');
define('HTTP_502', 'Bad Gateway');
define('HTTP_503', 'Service Unavailable');
define('HTTP_504', 'Gateway Time-out');
define('HTTP_505', 'HTTP Version not supported');
