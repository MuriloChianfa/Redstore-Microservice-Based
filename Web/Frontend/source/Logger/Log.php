<?php

namespace Source\Logger;

/**
 * Logger class
 */
abstract class Log implements LoggerInterface
{
    /**
     * @return void
     */
    final public static function init(): void
    {
        openlog('Redstore-Web', LOG_PERROR, LOG_USER);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function emergency($message, array $context = []): void
    {
        syslog(LOG_EMERG, self::interpolate($message, $context));
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
    final public static function alert($message, array $context = []): void
    {
        syslog(LOG_ALERT, self::interpolate($message, $context));
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
    final public static function critical($message, array $context = []): void
    {
        syslog(LOG_CRIT, self::interpolate($message, $context));
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function error($message, array $context = []): void
    {
        syslog(LOG_ERR, self::interpolate($message, $context));
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
    final public static function warning($message, array $context = []): void
    {
        syslog(LOG_WARNING, self::interpolate($message, $context));
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function notice($message, array $context = []): void
    {
        syslog(LOG_NOTICE, self::interpolate($message, $context));
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
    final public static function info($message, array $context = []): void
    {
        syslog(LOG_INFO, self::interpolate($message, $context));
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function debug($message, array $context = []): void
    {
        syslog(LOG_DEBUG, self::interpolate($message, $context));
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return void
     */
    final public static function log(int $level, $message, array $context = []): void
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

        syslog($level, self::interpolate($message, $context));
    }

    /**
     * Interpolates context values into the message placeholders.
     */
    final private static function interpolate($message, array $context = []): string
    {
        // build a replacement array with braces around the context keys
        $replace = [];

        // check that the value can be cast to string
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
