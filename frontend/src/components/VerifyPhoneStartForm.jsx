import React, { Component } from 'react';

class PhoneVerifyStartForm extends Component {
	constructor( props ) {
		super( props );
		this.state = {
			phoneNumber: this.props.phoneNumber,
			buttonText: 'Get Verification Code'
		}
	}

	componentWillReceiveProps( newProps ) {
		this.setState( newProps );
	}

	render() {
		return (
			<form className="verify-form" onSubmit={this.props.handleSubmit}>
				<ul>
					<li>
						<label htmlFor="phone-number">
							Phone Number:
						</label>
						<input
							type="tel"
							id="phoneNumber"
							value={this.state.phoneNumber}
							onChange={this.props.handleChange} />
					</li>
					<li>
						<input 
							className="btn btn-primary"
							type="submit"
							value="Get Verification Code" />
					</li>
				</ul>
			</form>
		);
	}
}

export default PhoneVerifyStartForm;