<?php

declare(strict_types=1);

namespace Source\Infra\Logger;

/**
 * Logger class, following the PSR-3 recomendation...
 *
 * @version 0.1.0
 * @author Murilo Chianfa <github.com/MuriloChianfa
 * @package Source\Infra\Logger\Log
 */
abstract class Log implements LoggerInterface
{
    /**
     * @return void
     */
    final public static function init(): void
    {
        openlog('Mailler', LOG_PERROR, LOG_USER);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function emergency(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_EMERG) {
            return;
        }

        syslog(LOG_EMERG, self::interpolate($message, $context, LOG_EMERG));
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function alert(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_ALERT) {
            return;
        }

        syslog(LOG_ALERT, self::interpolate($message, $context, LOG_ALERT));
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function critical(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_CRIT) {
            return;
        }

        syslog(LOG_CRIT, self::interpolate($message, $context, LOG_CRIT));
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function error(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_ERR) {
            return;
        }

        syslog(LOG_ERR, self::interpolate($message, $context, LOG_ERR));
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function warning(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_WARNING) {
            return;
        }

        syslog(LOG_WARNING, self::interpolate($message, $context, LOG_WARNING));
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function notice(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_NOTICE) {
            return;
        }

        syslog(LOG_NOTICE, self::interpolate($message, $context, LOG_NOTICE));
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function info(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_INFO) {
            return;
        }

        syslog(LOG_INFO, self::interpolate($message, $context, LOG_INFO));
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function debug(string $message, array $context = []): void
    {
        if (LOG_LEVEL < LOG_DEBUG) {
            return;
        }

        syslog(LOG_DEBUG, self::interpolate($message, $context, LOG_DEBUG));
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function log(int $level, string $message, array $context = []): void
    {
        if (
            !in_array($level, [
            LOG_EMERG,
            LOG_ALERT,
            LOG_CRIT,
            LOG_ERR,
            LOG_WARNING,
            LOG_NOTICE,
            LOG_INFO,
            LOG_DEBUG
            ])
        ) {
            $level = LOG_NOTICE;
        }

        syslog($level, self::interpolate($message, $context, $level));
    }

    final public static function exception(\Throwable $exception): void
    {
        $errorCode = @$exception->getCode();
        $errorMessage = @$exception->getMessage();
        $errorClass = @get_class($exception) ?? 'unrecognized';

        if (!empty($exception->getTrace())) {
            $errorLine = @$exception->getTrace()[0]['line'] ?? '';
            $errorFile = @$exception->getTrace()[0]['file'] ?? '';
        }

        Log::error((empty($errorLine)) ? "[{$errorCode}][$errorClass] {$errorMessage}" : "[{$errorCode}][$errorClass] {$errorMessage} on line {$errorLine} of file {$errorFile}");
    }

    /**
     * Interpolates context values into the message placeholders.
     */
    private static function interpolate(string $message, array $context = [], $logLevel = LOG_DEBUG): string
    {
        // build a replacement array with braces around the context keys
        $replace = [];

        // check that the value can be cast to string
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        $logLevelName = getLogLevelName($logLevel);

        // interpolate replacement values into the message and return
        return strtr("[{$logLevelName}] - " . $message, $replace);
    }
}
