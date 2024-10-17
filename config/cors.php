<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:8080'], // Ajuste o endereço do frontend
    'allowed_headers' => ['*'],
    'exposed_headers' => false,
    'max_age' => 0,
    'supports_credentials' => true,

];
