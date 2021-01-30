<?php

return [
    'eloquent' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST') ?? 'localhost:8889',
        'unix_socket' => getenv('DB_UNIXSOCKET') ?? null,
        'database'  => getenv('DB_DATABASE') ?? 'coinsport',
        'username'  => getenv('DB_USERNAME') ?? 'root',
        'password'  => getenv('DB_PASSWORD') ?? 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
    ]
];