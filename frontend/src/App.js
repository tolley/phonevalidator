import React, { Component } from 'react';
import './App.css';
import VerifyPhone from './components/VerifyPhone.jsx';

class App extends Component {
  render() {
    return (
      <div className="container">
        <div className="">
            <VerifyPhone />
        </div>
      </div>
    );
  }
}

export default App;
