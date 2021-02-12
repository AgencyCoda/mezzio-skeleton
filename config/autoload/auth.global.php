<?php

return [
    'mia_auth' => [
        'key' => getenv('API_KEY') ?? '',
        'method' => 'jwt',
        'iss' => 'https://agencycoda.com',
        'aud' => 'https://agencycoda.com',
        'expire' => 'P15D'
    ],
];
