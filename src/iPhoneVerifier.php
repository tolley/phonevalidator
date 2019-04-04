<?php

// The interface for the phone number validator class, which will
// validate that a given user has access to a given phone number
interface iPhoneVerifier {
	/**
	 * @param string $phoneNumber - The phone number to validate
	 */
	public function start( string $phoneNumber );

	/**
	 * @param string $phoneNumber - The phone number to validate
	 * @param int $verificationCode - The verification code that the
	 								  user entered
	 */
	public function check( string $phoneNumber, string $verificationCode );
}