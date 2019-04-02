<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/verify-phone',
	function (Request $request, Response $response, array $args) {
	    // Sample log message
	    $this->logger->info("Verify Phone '/'");

	    // Render index view
	    return $this->renderer->render($response, 'index.phtml', $args);
});

// API routes for phone number verification

// Initiate the check, this will send the code to a phone number
$app->post('/verify-phone/start',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/start'");
});

// This will return the any existing status checks for a phone number
$app->get('/verify-phone/status',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/status'");
		
});

// This will verify whether or not the phone number/code combo is valid
$app->post('/verify-phone/check',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/check'");		
});
