<?php

if (!function_exists('larametricUses')) {
    function larametricsUses($uses)
    {
        return '\Aschmelyun\Larametrics\Http\Controllers\\' . $uses;
    }
}

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('is_countable')) {
    function is_countable($countable)
    {
        return is_array($countable) || $countable instanceof Countable;
    }
}
