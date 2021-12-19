<?php

declare(ticks=1);
declare(strict_types=1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

/* Remove the execution time limit */
set_time_limit(0);

/* Set default time to UTC */
date_default_timezone_set('UTC');

$startMicrotime = microtime(true);

require_once __DIR__ . '/vendor/autoload.php';

register_shutdown_function('shutdown');

if (extension_loaded('pcntl')) {
    function catchSignals() { exit; }

    pcntl_signal(SIGINT,  'catchSignals');
    pcntl_signal(SIGTERM, 'catchSignals');
}

set_exception_handler('exceptionHandler');

use Source\Infra\Logger\Log;

if (isset($argv) && in_array('--debug', $argv)) {
    Log::init();
}

Log::info('Starting E-mail Service...');

while (true) {
    try {
        Log::info('Initing listener...');

        new Source\Core\Listener(RABBITMQ_QUEUE, RABBITMQ_EXCHANGER);
    }
    catch (\Throwable $exception) {
        Log::exception($exception);
    }
    finally {
        sleep(5);
    }
}
