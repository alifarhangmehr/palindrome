import logo from './images/mirror-img.png';
import './App.css';
import Palindrome from './Components/Palindrome.js';
import React, { Component, useState } from "react";
import { render } from "react-dom";
import SlidingPane from "react-sliding-pane";
import "react-sliding-pane/dist/react-sliding-pane.css";

function App() {
  const [state, setState] = useState({
    isPaneOpenBotton: false,
  });

  const tryBtnStyle = {
    fontFamily: "Roboto-Bold",
    backgroundColor: "#1F1E1B",
    padding: "10px",
    border: "none",
    color: "white"
  }

  return (
    <div className="App">
      <header className="App-header">
        <img src={logo} alt="logo" />
        <div>
        <h1 style={{fontFamily:"BebasNeue", fontSize: "32px"}}>
            Palindrome
        </h1>
        <div style={{width: "226px", fontFamily: "SFProText", fontSize: "13px", color: "#A4A095"}}>
          <p>
            A palindrome is a word, number, phrase, or other sequence of characters which reads the same backward as forward, such as madam or racecar.
          </p>
        </div>
        <div>
          <button style={tryBtnStyle} onClick={() => setState({ isPaneOpenBotton: true })}>TRY IT NOW</button>
        </div>
      </div>
      </header>
      <div>
      <div style={{ marginTop: "32px" }}>
      </div>
      <SlidingPane
        closeIcon={<div>X</div>}
        isOpen={state.isPaneOpenBotton}
        from="bottom"
        width="100%"
        onRequestClose={() => setState({ isPaneOpenBotton: false })}
        style={{backgroundColor: "white"}}
        hideHeader="true"
      >
        <Palindrome></Palindrome>
      </SlidingPane>
      </div>
    </div>
  );
}
document.body.classList.add("no-sroll")

export default App;
