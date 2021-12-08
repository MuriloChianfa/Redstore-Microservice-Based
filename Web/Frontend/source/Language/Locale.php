<?php

namespace Source\Language;

abstract class Locale
{
    /**
     * Store the transaltion for specific languages
     *
     * @var array $translation
     */
    private static $translation = [];

    /**
     * Current locale
     *
     * @var string $locale
     */
    private static $locale;

    /**
     * Default locale
     *
     * @var string $defaultLocale
     */
    private static $defaultLocale = DEFAULT_COUNTRY;

    /**
     * Lang default dir
     *
     * @var string $localeDir
     */
    private static $localeDir = __DIR__ . '/Translation';

    /**
     * Get the Default locale
     *
     * @return string
     */
    final public static function getDefault(): string
    {
        return self::$defaultLocale;
    }

    /**
     * Set the default locale
     *
     * @return void
     */
    final private static function setDefault(): void
    {
        self::$locale = self::$defaultLocale;
    }

    /**
     * Get the user define locale
     *
     * @return string
     */
    final public static function get(): ?string
    {
        return self::$locale;
    }

    /**
     * Set the user define localte
     *
     * @param string $locale
     * @return void
     */
    final public static function set($locale = null): void
    {
        self::$locale = $locale;
    }

    /**
     * Determine if transltion exist or translation key exist
     *
     * @param string $locale
     * @param string $key
     * @return bool
     */
    final public static function hasTranslation($locale, $key = null): bool
    {
        if (null == $key && isset(self::$translation[$locale])) {
            return true;
        }

        if (isset(self::$translation[$locale][$key])) {
            return true;
        }

        return false;
    }

    /**
     * Get the transltion for required locale or transtion for key
     *
     * @param string $locale
     * @param string $key
     * @return string|array
     */
    final public static function getTranslation($locale, $key = null)
    {
        if (null == $key && self::hasTranslation($locale)) {
            return self::$translation[$locale];
        }

        if (self::hasTranslation($locale, $key)) {
            return self::$translation[$locale][$key];
        }

        return [];
    }

    /**
     * Get the transltion for required locale or transtion for key
     *
     * @param string $key
     * @return null|string
     */
    final public static function getTranslationKey(string $key): ?string
    {
        if (self::hasTranslation(self::$locale, $key)) {
            return self::getTranslation(self::$locale, $key);
        }

        if (self::$locale === self::$defaultLocale) {
            return null;
        }

        self::loadTranslation(self::$defaultLocale);

        if (!self::hasTranslation(self::$defaultLocale, $key)) {
            return null;
        }

        $translation = self::getTranslation(self::$defaultLocale, $key);
    }

    /**
     * Set the transtion for required locale
     *
     * @param string $locale Language code
     * @param string $trans translations array
     * @return void
     */
    final private static function setTranslation($locale, $trans = []): void
    {
        self::$translation[$locale] = $trans;
    }

    /**
     * Load a Transtion into array
     *
     * @return void
     */
    final private static function loadTranslation($locale = null, $force = false): void
    {
        if ($locale == null) {
            $locale = self::$locale;
        }

        if (!self::hasTranslation($locale)) {
            self::setTranslation($locale, include(sprintf('%s/%s.php', self::$localeDir, COUNTRY_TO_LANG[self::$locale])));
        }
    }

    /**
     * Initialize locale
     *
     * @param string $locale
     * @return void
     */
    final public static function init($locale = null, $defaultLocale = null): void
    {
        self::initLocale();

        if (self::$locale != null) {
            return;
        }

        if (
            $locale == null
            || (!preg_match('#^[a-z]+_[a-zA-Z_]+$#', $locale)
                && !preg_match('#^[a-z]+_[a-zA-Z]+_[a-zA-Z_]+$#', $locale)
            )
        ) {
            self::detectLocale();
            self::initLocale();
            return;
        }

        self::$locale = $locale;
        self::initLocale();
    }

    /**
     * Attempt to autodetect locale
     *
     * @return void
     */
    final private static function detectLocale(): void
    {
        if (!function_exists('geoip_country_code_by_name')) {
            error_log('a funcao de GeoIP nao foi encontrada!');
            self::setDefault();
            return;
        }

        if (!isset($_SERVER['REMOTE_ADDR'])) {
            error_log('src_ip não foi encontrado!');
            self::setDefault();
            return;
        }

        // GeoIP
        $country = geoip_country_code_by_name($_SERVER['REMOTE_ADDR']);

        if ($country) {
            self::$locale = isset(COUNTRY_TO_LANG[$country]) ? $country : null;
        }

        if (empty(self::$locale)) {
            self::setDefault();
        }
    }

    /**
     * Check if config for selected locale exists
     *
     * @return void
     */
    final private static function initLocale(): void
    {
        if (null === self::$locale) {
            self::detectLocale();
        }

        if (!file_exists(sprintf('%s/%s.php', self::$localeDir, @COUNTRY_TO_LANG[self::$locale]))) {
            error_log(sprintf('lang: %s of country %s, does not exists!', @COUNTRY_TO_LANG[self::$locale] ?? 'undefined', self::$locale));
            self::setDefault();
        }
    }

    /**
     * Translate a key
     *
     * @param string Key to be translated
     * @param string optional arguments
     * @return string
     */
    final public static function translate($key): string
    {
        self::init();
        self::loadTranslation(self::$locale);

        $translation = self::getTranslationKey($key);

        if (empty($translation)) {
            return $key;
        }

        if (false === strpos($translation, '{arg:')) {
            return $translation;
        }

        // Replace arguments
        $replace = [];
        $args = func_get_args();

        for ($i = 1, $max = count($args); $i < $max; $i++) {
            $replace['{arg:' . $i . '}'] = $args[$i];
        }

        // Interpolate replacement values into the messsage then return
        return strtr($translation, $replace);
    }
}
