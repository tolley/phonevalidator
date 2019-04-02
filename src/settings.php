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
            'sid' => 'AC90ee131fe8d3272c738af0e7fba7b7f2',
            'auth_token' => '737434c3712301c960db59880c8b56be'
        ],
    ],
];
