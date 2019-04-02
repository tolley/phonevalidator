<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // The name of the phone validation service in use
        'phone_validator_service' => 'twilio',

        // The settings for the phone validation service
        'twilio' => [
            'apikey' => 'YLdLlOo7Zmc3mfgjfst2DVzGKZopsj9D'
        ],
    ],
];
