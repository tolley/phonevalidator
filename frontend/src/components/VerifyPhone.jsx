import React, { Component } from 'react';
import fetch from 'fetch';

import VerifyPhoneStartForm from './VerifyPhoneStartForm';
import VerifyPhoneCheckForm from './VerifyPhoneCheckForm';

class PhoneVerifyForm extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			phoneNumber: '',
			code: '',
			mode: 'start', // Possible modes: start, check,
			message: ''
		}
	}

	handleSubmit( e ) {
		e.preventDefault();

		// Reset the message
		this.setState( {message: ''} );

		if( this.state.mode === 'start' ) {
			// Make sure we have all the data we need
			if( this.state.phoneNumber.length >= 10 ) {
				let opts = {
					phone_number: this.state.phoneNumber
				};

				// Call the server to start the verification process
				fetch( '/verify-phone/start', {
					method: 'post',
					body: opts
				} )
				.then( this.handleStartResponse.bind(this) );
			} else {
				this.setState({ message: "Your phone number must be at least 10 digits" });
			}
		} else if( this.state.mode === 'check' ) {
			if( this.state.phoneNumber.length >= 10 && 
				this.state.code.length === 4 ) {

				let opts = {
					phone_number: this.state.phoneNumber,
					code: this.state.code
				};

				// Call the server to verify the phone number against the code
				fetch( '/verify-phone/check', {
					method: 'post',
					body: opts
				} )
				.then( this.handleStartResponse.bind(this) );
			} else {
				if( this.state.phoneNumber.length < 10 ) {
					this.setState({ message: "Your phone number must be at least 10 digits" });
				}

				if( this.state.code.length != 4 ) {
					this.setState({ message: "You must enter a 4 digit code" });
				}
			}
		}
	}

	handleStartResponse( data ) {
		if( data.success ) {
			this.setState({
				message: "Enter the code you received",
				mode: 'check'
			});
		} else {
			this.setState({ message: data.message });
		}
	}

	handleCheckResponse( data ) {
		if( data.success ) {
			this.setState({message: data.message });
		}
	}

	handleChange( e ) {
		// Both the phoneNumber and code field are numeric
		let sanitizedValue = e.target.value.replace( /[^\d]/g, '' );

		let fieldId = e.target.id;
		let newState = {};
		newState[fieldId] = sanitizedValue;

		this.setState( newState );
	}
	
	render() {
		if( this.state.mode === 'start' ) {
			return (
				<div>
					<VerifyPhoneStartForm
						phoneNumber={this.state.phoneNumber}
						handleSubmit={this.handleSubmit.bind(this)}
						handleChange={this.handleChange.bind(this)} />
					<br />
					<div className="message">
						{this.state.message}
					</div>
				</div>
			);
		} else if( this.state.mode === 'check' ) {
			return (
				<div>
					<VerifyPhoneCheckForm
						phoneNumber={this.state.phoneNumber}
						code={this.state.code}
						handleSubmit={this.handleSubmit.bind(this)}
						handleChange={this.handleChange.bind(this)} />
					<br />
					<div className="message">
						{this.state.message}
					</div>
				</div>
			);
		}
	}
}

export default PhoneVerifyForm;