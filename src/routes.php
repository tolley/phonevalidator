<?php

use Slim\Http\Request;
use Slim\Http\Response;

function debug( $v ) {
	echo '<pre>';
	print_r( $v );
	echo '</pre>';
}

// Routes
$app->get('/verify-phone',
	function (Request $request, Response $response, array $args) {
	    // Sample log message
	    $this->logger->info("Verify Phone '/'");

	    // Render index view
	    return $this->view->render($response, 'verification_start.phtml', $args);
});

// API routes for phone number verification

// Initiate the check, this will send the code to a phone number
$app->post('/verify-phone/start',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/start'");

		$verifyService = $this->get('phone_verifier');
		$res = $verifyService->start( $_POST['phone_number'] );

		// Show the result of whether or not the verification code was sent
		echo json_encode( $res );
});

$app->get('/verify-phone/check',
	function (Request $request, Response $response, array $args) {
		return $this->view->render($response, 'verification_check.phtml', $args);
});

// This will verify whether or not the phone number/code combo is valid
$app->post('/verify-phone/check',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/check'");

		$verifyService = $this->get('phone_verifier');
		$res = $verifyService->check( $_POST['phone_number'], $_POST['code'] );

		echo json_encode( $res );
});
