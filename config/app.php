<?php

return [
    'name' => env('APP_NAME', 'Quiz System'),
    'env' => env('APP_ENV', 'local'),
    'debug' => env('APP_DEBUG', true),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'America/Sao_Paulo',
    'locale' => 'pt_BR',
    'fallback_locale' => 'en',
    'key' => env('APP_KEY', 'base64:'.base64_encode(random_bytes(32))),
    'cipher' => 'AES-256-CBC',
];
