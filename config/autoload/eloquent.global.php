<?php

return [
    'eloquent' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST') ? getenv('DB_HOST') : 'localhost:8889',
        'unix_socket' => getenv('DB_UNIXSOCKET') ? getenv('DB_UNIXSOCKET') : null,
        'database'  => getenv('DB_DATABASE') ? getenv('DB_DATABASE') : 'codahub',
        'username'  => getenv('DB_USERNAME') ? getenv('DB_USERNAME') : 'root',
        'password'  => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_general_ci',
    ]
];