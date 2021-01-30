<?php
// In config/autoload/cors.global.php
declare(strict_types=1);

use \Mezzio\Cors\Configuration\ConfigurationInterface;

return [
    ConfigurationInterface::CONFIGURATION_IDENTIFIER => [
        'allowed_origins' => [ConfigurationInterface::ANY_ORIGIN], // Allow any origin
        'allowed_headers' => ["Authorization", "If-Match", "If-Unmodified-Since", "Content-Type", "Accept", "Origin", "X-Auth-Token", "X-Requested-With", "Access-Control-Allow-Headers", "Access-Control-Allow-Origin"], // No custom headers allowed
        'allowed_max_age' => '600', // 10 minutes
        'credentials_allowed' => true, // Allow cookies
        'exposed_headers' => ['X-Custom-Header', 'Etag'], // Tell client that the API will always return this header
        //'allowed_methods'
    ],
];