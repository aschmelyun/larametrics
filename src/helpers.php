<?php

if (!function_exists('larametricUses')) {
    function larametricsUses($uses)
    {
        return '\Aschmelyun\Larametrics\Http\Controllers\\' . $uses;
    }
}
