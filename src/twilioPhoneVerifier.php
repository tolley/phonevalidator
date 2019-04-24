<?php

require '../src/iPhoneVerifier.php';

// The interface for the twilio phone number verifier object
class TwilioPhoneVerifier implements iPhoneVerifier {

	// The url for the twilio verification API
	private $url = 'https://api.authy.com/protected/json/phones/verification/';

	// The actual authy api object
	protected $authyApi;

	// The arguments to pass to the twilio API
 	private $method; // The method to use to send the verification code
 	private $country_code = '1'; // The country code
	private $code_length = 4; // The number of digits that the code should contain

	public function __construct( array $config ) {
		// Set the relevant config settings on this object if they exist
		$this->method = strlen($config['method'])? $config['method']: 'sms';
		$this->$country_code = strlen($config['country_code'])? $config['country_code']: '1';
		$this->code_length = strlen($config['code_length'])? $config['code_length']: '4';

		// Create an instance of the authy api object for twilio requests
		$this->authyApi = new Authy\AuthyApi( $config['apikey'] );
	}

	/**
	 * Calls the twilio end point on which sends a verification code to 
	 * the users phone number
	 * 
	 * @param string $phoneNumber - The phone number to validate
	 * @return array An array containing the success status, a result message, and a TTL for the code
	 */
	public function start( string $phoneNumber ) {
		// Strip out all non numeric characters from the phone number
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

		// If we still have something in the phone field, start the verification process
		if( strlen( $phoneNumber ) > 0 ) {
			$res = $this->authyApi->phoneVerificationStart(
				$phoneNumber,
				$this->country_code,
				$this->method,
				$this->code_length);

			$returnVal = [
				'success' => $res->bodyvar('success'),
				'message' => $res->bodyvar('message'),
				'seconds_to_expire' => $res->bodyvar('seconds_to_expire')
			];
		} else {
			$returlVal = [
				'success' => false,
				'message' => 'Please enter a phone number',
				'seconds_to_expire' => 0
			];
		}

		return $returnVal;
	}

	/**
	 * Calls the twilio end point to verify that the code matches the phone number
	 *
	 * @param string $phoneNumber - The phone number to validate
	 * @param int $verificationCode - The verification code that the
	 *								  user entered
	 * @return array An array containing the success status and a message
	 */
	public function check( string $phoneNumber, string $verificationCode ) {
		$phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
		$verificationCode = preg_replace( '~\D~', '', $verificationCode );

		// Make sure we still have a code a phone number to check
		if( strlen( $phoneNumber ) > 0 || strlen( $verificationCode ) != $this->code_length ) {
			$res = $this->authyApi->phoneVerificationCheck( $phoneNumber, $this->country_code, $verificationCode );

			$returnVal = [
				'success' => $res->ok(),
				'message' => $res->bodyvar( 'message' )
			];
		} else {
			$returnVal = [
				'success' => false,
				'message' => 'You must enter a phone number and code to verify'
			];
		}

		return $returnVal;
	}
}