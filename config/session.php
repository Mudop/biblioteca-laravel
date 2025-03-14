<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'cookie'), // ✅ Asegúrate de que esté en 'cookie'

    'lifetime' => 120,

    'expire_on_close' => false,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => null,

    'table' => 'sessions',

    'store' => null,

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    'path' => '/',

    'domain' => env('SESSION_DOMAIN', null),

    'secure' => env('SESSION_SECURE_COOKIE', false), // ❗ Si usas HTTPS, cambia a true

    'http_only' => true,

    'same_site' => 'lax', // ✅ IMPORTANTE: Evita problemas con CSRF
];
