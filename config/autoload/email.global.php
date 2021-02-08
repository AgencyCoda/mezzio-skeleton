<?php

return [
    'sendgrid' => [
        'api_key' => getenv('SENDGRID_API_KEY') ?? '',
        'from' => getenv('SENDGRID_FROM') ?? '',
        'name' => getenv('SENDGRID_NAME') ?? '',
        'reply_to' => getenv('SENDGRID_REPLY_TO') ?? '',
        'base_url' => getenv('SENDGRID_BASE_URL') ?? ''
    ],
];
