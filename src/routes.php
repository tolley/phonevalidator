<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Respect\Validation\Validator as v;

// Routes
$app->get('/verify-phone',
	function (Request $request, Response $response, array $args) {
	    // Sample log message
	    $this->logger->info("Verify Phone '/'");

	    // Render index view
	    return $this->view->render($response, 'verification_start.phtml', $args);
});

// API routes for phone number verification

function dd( $v ) {
	echo '<pre>';
	print_r( $v );
	echo '</pre>';
	die();
}

$phoneNumberValidator = v::numeric()->length(10)->setName("Phone Number");
$codeValidator = v::numeric()->length(4)->setName("Verification Code");

// Initiate the check, this will send the code to a phone number
$app->post('/verify-phone/start',
	function (Request $request, Response $response, array $args) {
		$this->logger->info("Verify Phone '/start'");

		// If there are errors, render the start form with errors
		$errors = $request->getAttribute('errors');
		if(!empty($errors)) {
			$args['errors'] = $errors;
			return $this->view->render($response, 'verification_start.phtml', $args);		
		} else {
			// Get our phone verifier service and start the verification process
			$postVars = $request->getParsedBody();
			$verifyService = $this->get('phone_verifier');
			$res = $verifyService->start( $postVars['phone_number'] );

			dd( $res );

			// Show the result of whether or not the verification code was sent
			return $this->view->render($response, 'verification_check.phtml', $args);
		}
})->add(new \DavidePastore\Slim\Validation\Validation(
	array(
		'phone_number' => $phoneNumberValidator
	)
));

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
})->add(new \DavidePastore\Slim\Validation\Validation(
	array(
		'phone_number' => $phoneNumberValidator,
		'code' => $codeValidator
	)
));;
