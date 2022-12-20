<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sha Options
    |--------------------------------------------------------------------------
    |
    | Supported Algorithm Name: "jasypt", "sha256", "sha512", "md5"
    |
    */

    'jasypt' => [
        'algoName' => 'sha256',
        'iteration' => 1000,
    ],

    'sha256' => [
        'algoName' => 'sha256',
    ],

    'sha512' => [
        'algoName' => 'sha512',
    ],

];
