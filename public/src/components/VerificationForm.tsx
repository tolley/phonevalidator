import * as React from 'react';

export interface iVerificationFormProps {};

export interface iVerificationFormState {};

enum FormMode {
	Start = "start",
	Verify = "verify"
};

export class VerificationForm extends React.Component<iVerificationFormProps, iVerificationFormState> {
	public state = {
		mode: "start"
	};

	public constructor(props: iVerificationFormProps) {
		super(props);
	};

	public setMode() {
		this.setState({ mode: "verify" });
		console.log( this.state );
	};

	// Begin life cycle methods
	public render() {
		if( this.state.mode == "start" ) {
			return (
				<div className="container">
					<div className="form-group">
						<form onSubmit={this.handleSubmit}>
							<label>
								Phone Number:
								<input type="tel" name="phone_number" />
							</label>

							<br />

							<button className="btn btn-primary">
								Send Verification Code
							</button>
						</form>
					</div>
				</div>
			);
		} else if( this.state.mode == "verify" ) {
			return (
				<div className="container">
					<div className="form-group">
						<form onSubmit={this.handleSubmit}>
							<label>
								Phone Number:
								<input type="tel" name="phone_number" />
							</label>

							<br />

							<label>
								Code:
								<input type="tel" name="phone_number" />
							</label>

							<br />

							<button className="btn btn-primary">
								Send Verification Code
							</button>
						</form>
					</div>
				</div>
			);
		}
	};

	// End life cycle methods

	// Begin custom Methods

	// Handles the form submission
	private handleSubmit( e: React.FormEvent<HTMLFormElement> ) {
		// Don't actually submit the form, just send an ajax request
		e.preventDefault();
		console.log("here in submit, e = ", e.target);

		xhr = new XMLHttpRequest();

	};

	// Triggers the call to the start the verification
	getVerificationCode() {

	};

	// Calls the server with the code that the user entered
	submitVerificationCode() {

	};

	// Makes a call to the server to get the status of the verification
	checkVerificationStatus() {

	};
	// End custom methods
};