<?php

declare(ticks = 1);

declare(strict_types = 1);

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

/* Remove the execution time limit */
set_time_limit(0); 

if (isset($argv)) {
	if (in_array('--debug', $argv)) {
		$filename = pathinfo(__FILE__, PATHINFO_FILENAME);
        openlog($filename, LOG_PID | LOG_PERROR, LOG_LOCAL0);
	}
}

require __DIR__ . '/vendor/autoload.php';

/**
 * Listener
 */
use Source\Listener;

// Shutdown function
function shutdown(): void
{
	\writeLog('Stoping E-mail Service...');

	// Closing connection with syslog
	if (isset($argv)) {
        if (in_array('--debug', $argv)) {
            closelog();
        }
    }

	exit();
}

register_shutdown_function('shutdown');

pcntl_signal(SIGINT, 'shutdown');
pcntl_signal(SIGTERM, 'shutdown');

\writeLog('Starting E-mail Service...');

do {
    try {
        sleep(2);
        $RabbitReceiver = new Listener(RABBITMQ_QUEUE, RABBITMQ_EXCHANGER);
    }
    catch (\Throwable $exception) {
        \writeLog($exception->getMessage());

        if (!empty($RabbitReceiver)) {
            unset($RabbitReceiver);
        }
        
        sleep(5);
        continue;
    }
} while (true);

