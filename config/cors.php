<?php

return [
    'paths' => ['api/*', 'login', 'logout', 'register', 'sanctum/csrf-cookie'], // ✅ Asegúrate de incluir 'sanctum/csrf-cookie'

    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // ✅ Debe coincidir con el frontend
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // ✅ Debe estar en true
];
