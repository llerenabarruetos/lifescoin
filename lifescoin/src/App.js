import React from 'react';
import logo from './logo.png';
import './App.css';

function App() {
  return (
    <div className="App">
      <header className="App-header">
		<div style={{fontSize: 55}}>Lifescoin</div>
		<div style={{fontSize: 25}}>by the LakeDeep LLC kids</div>

        <img src={logo} className="App-logo" alt="logo" />
		<div style={{fontSize: 25}}>With the help of the internet and tutorials, we will build this.</div>
        <p>
          Edit <code>src/App.js</code> and save to reload.
        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
      </header>
    </div>
  );
}

export default App;
