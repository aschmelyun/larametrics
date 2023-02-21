<?php declare(strict_types=1);

// config for Aschmelyun/Larametrics
return [

    'prefix' => 'larametrics',

    'name_prefix' => 'larametrics.',

    'enable_api' => false,

    'default_model_events' => [
        'created',
        'updated',
        'deleted',
    ],

    'unique_visits' => false,

];
