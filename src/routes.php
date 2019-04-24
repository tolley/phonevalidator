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

		// If there are errors, render the start form with them errors,
		// otherwise, pass an empty array to the view to prevent undefined errors
		$errors = is_array( $request->getAttribute('errors') )? 
			$request->getAttribute('errors'): array();

		// If we had actual errors, rerender our initial form with errors
		if(!empty($errors)) {
			$args['errors'] = $errors;
			return $this->view->render($response, 'verification_start.phtml', $args);		
		} else {
			// Otherwise, get our phone verifier service and start the verification process
			$postVars = $request->getParsedBody();
			$verifyService = $this->get('phone_verifier');
			$res = $verifyService->start( $postVars['phone_number'] );
			$args['phone_number'] = $postVars['phone_number'];

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

		// Make sure $errors is defined as an array to prevent errors in the view
		// If there are errors, render the start form with them errors,
		// otherwise, pass an empty array to the view to prevent undefined errors
		$errors = is_array( $request->getAttribute('errors') )? 
			$request->getAttribute('errors'): array();

		$postVars = $request->getParsedBody();

		// If there are no errors, run the verification service
		if( empty( $errors ) ) {
			$verifyService = $this->get('phone_verifier');
			$res = $verifyService->check( $postVars['phone_number'], $postVars['code'] );

			// If the response was a success, show the success page
			if( $res['success'] ) {
				$checkArgs = [
					'message' => $res['message']
				];

				return $this->view->render($response, 'verification_success.phtml', $checkArgs);
			} else {
				// Otherwise, show the start page again with errors
				$checkArgs = [
					'message' => $res['message'],
					'phone_number' => $postVars['phone_number']
				];

				return $this->view->render($response, 'verification_check.phtml', $checkArgs);
			}
		} else {
			// Otherwise, we need to reshow the form with the errors
			$checkArgs = array(
				'errors' => $errors,
				'phone_number' => $postVars['phone_number'],
				'code' => $postVars['code']
			);

			return $this->view->render($response, 'verification_check.phtml', $checkArgs );
		}
})->add(new \DavidePastore\Slim\Validation\Validation(
	array(
		'phone_number' => $phoneNumberValidator,
		'code' => $codeValidator
	)
));;
