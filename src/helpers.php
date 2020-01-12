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
