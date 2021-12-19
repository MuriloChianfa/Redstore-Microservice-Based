<?php

declare(strict_types=1);

/**
 * Simple shutdown function
 */
function shutdown()
{
    global $argv;
    global $startMicrotime;

    $endMicrotime = round((microtime(true) - $startMicrotime), 2);

    $usedMemory    = round(memory_get_usage(false) / 1024);
    $allocedMemory = round(memory_get_usage(true)  / 1024);

    \Source\Infra\Logger\Log::debug("[*] Used memory: {$usedMemory}KB, Alocated memory: {$allocedMemory}KB");
    \Source\Infra\Logger\Log::debug("[*] Execution time: {$endMicrotime}, Exiting...");

    if (isset($argv) && in_array('--debug', $argv)) {
        @closelog();
    }

    exit(0);
}

/**
 * @param \Throwable $exception
 * @return void
 */
function exceptionHandler($exception)
{
    \Source\Infra\Logger\Log::exception($exception);
}

/**
 * @param string $email
 * @return bool
 */
function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * ##################
 * ###   STRING   ###
 * ##################
 */

/**
 * @param string $string
 * @return string
 */
function str_slug(string $string): string
{
    $string = filter_var(mb_strtolower($string), FILTER_SANITIZE_STRIPPED);
    $formats = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $replace = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

    $slug = str_replace(['-----', '----', '---', '--'], '-',
        str_replace(' ', '-',
            trim(strtr(utf8_decode($string), utf8_decode($formats), $replace))
        )
    );

    return $slug;
}

/**
 * @param string $string
 * @return string
 */
function str_studly_case(string $string): string
{
    $string = str_slug($string);
    $studlyCase = str_replace(' ', '',
        mb_convert_case(str_replace('-', ' ', $string), MB_CASE_TITLE)
    );

    return $studlyCase;
}

/**
 * @param string $string
 * @return string
 */
function str_camel_case(string $string): string
{
    return lcfirst(str_studly_case($string));
}

/**
 * @param string $string
 * @return string
 */
function str_title(string $string): string
{
    return mb_convert_case(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS), MB_CASE_TITLE);
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_words(string $string, int $limit, string $pointer = '...'): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    $arrWords = explode(' ', $string);
    $numWords = count($arrWords);

    if ($numWords < $limit) {
        return $string;
    }

    $words = implode(' ', array_slice($arrWords, 0, $limit));

    return "{$words}{$pointer}";
}

/**
 * @param string $string
 * @param int $limit
 * @param string $pointer
 * @return string
 */
function str_limit_chars(string $string, int $limit, string $pointer = '...'): string
{
    $string = trim(filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS));
    if (mb_strlen($string) <= $limit) {
        return $string;
    }

    $chars = mb_substr($string, 0, mb_strrpos(mb_substr($string, 0, $limit), ' '));

    return "{$chars}{$pointer}";
}

/**
 * ################
 * ###   DATE   ###
 * ################
 */

/**
 * @param string $date
 * @param string $format
 * @return string
 */
function date_fmt(string $date = 'now', string $format = 'd/m/Y H\hi'): string
{
    return (new DateTime($date))->format($format);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_br(string $date = 'now'): string
{
    return (new DateTime($date))->format(CONF_DATE_BR);
}

/**
 * @param string $date
 * @return string
 */
function date_fmt_app(string $date = 'now'): string
{
    return (new DateTime($date))->format(CONF_DATE_APP);
}

/**
 * ##############
 * ###  LOGS  ###
 * ##############
 */

/**
 * Get log level name by number
 *
 * @param int $logLevel
 * @return string
 */
function getLogLevelName(int $logLevel): string
{
    $logLevelHashTable = [
        LOG_EMERG => 'LOG_EMERG',
        LOG_ALERT => 'LOG_ALERT',
        LOG_CRIT => 'LOG_CRIT',
        LOG_ERR => 'LOG_ERR',
        LOG_WARNING => 'LOG_WARNING',
        LOG_NOTICE => 'LOG_NOTICE',
        LOG_INFO => 'LOG_INFO',
        LOG_DEBUG => 'LOG_DEBUG'
    ];

    return $logLevelHashTable[$logLevel] ?? 'UNRECOGNIZED';
}

