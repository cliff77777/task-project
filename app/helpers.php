<?php

if (!function_exists('lang')) {
    /**
     * Translate the given message.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     * @return string|array|null
     */
    function lang($key, $replace = [], $locale = null)
    {
        return app('translator')->get("common.$key", $replace, 'zh_TW');
    }
}