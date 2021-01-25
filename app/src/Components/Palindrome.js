import React from 'react';
import axios from 'axios';
import confirmPositiveImg from '../images/confirm-positive.png';
import confirmNegativeImg from '../images/confirm-negative.png';

class Palindrome extends React.Component {
    
    state = { message: [] };
    btnClicked = () => {
        if (document.getElementById("wordInput").value == "") {
            document.getElementById("errorMsg").style.visibility = "visible";
            document.getElementById('negativeImg').style.display = "none";
            document.getElementById('negativeImg').style.display = "none";
        } else {
            document.getElementById("errorMsg").style.visibility = "hidden";
        }
        this.fetchAPI();
        console.log('in btn clicked');
        console.log(this.state);

    }

    fetchAPI = () => {

    const json = {word: document.getElementById("wordInput").value};
    
      let token = "8efe07b353ccb4e5515d2062cb1976bf4cfdbfada6ffaf3c005e2c1e1515e6db";
      axios.post('http://localhost:8000/v1/palindromes', json, {
        method: 'post',
        baseURL: 'http://localhost:8000/v1/',
        timeout: 2000,
        headers: {'Content-Type': 'application/json', 'Authorization' : 'Bearer ' + token},
        data: json
      })
      .then(response => {
          if (response.data.message.includes("is a")) {
              this.showConfirmPositive();
          } else if (response.data.message.includes("is not")) {
              this.showConfirmNegative();
          }
       })
    }

    showConfirmPositive = () => {
        document.getElementById('positiveImg').style.display = "block";
        document.getElementById('negativeImg').style.display = "none";
    }

    showConfirmNegative = () => {
        document.getElementById('positiveImg').style.display = "none";
        document.getElementById('negativeImg').style.display = "block";
    }

    render() {
        const palindromeStyle = {
            width: "100%",
            backgroundColor: "white",
            color: "black"
        }
        const inputStyle = {
            height: "57px",
            width: "244px",
            fontFamily: "BebasNeue",
            fontSize: "24px",
            textAlign: "center"
        }
        const positiveImgStyle = {
            paddingTop: "50px",
            display: "none"
        }
        const negativeImgStyle = {
            paddingTop: "50px",
            display: "none"
        }
        const checkBtnStyle = {
            fontFamily: "SFProText",
            width: "152px",
            height: "46px",
            backgroundColor: "#E8CA60",
            border: "none",
            borderRadius: "10px"
        }
        const errorMsgStyle = {
            fontFamily: "BebasNeue",
            fontSize: "20px",
            color: "red",
            visibility: "hidden"
        }
        return (
            <div style={palindromeStyle}>
                <p style={{fontFamily: "BebasNeue", fontSize: "42px"}}>
                    Palindrome
                    <br />
                    check
                </p>
                <p align={"center"} style={{fontFamily: "BebasNeueLight", fontSize: "50px"}}>
                    Your Word
                </p>
                <p align={"center"}>
                    <input id="wordInput" style={inputStyle}/>
                    <div style={{height: "100px", paddingTop: "40px"}}>
                    <img id="positiveImg" style={positiveImgStyle} src={confirmPositiveImg} />
                    <img id="negativeImg" style={negativeImgStyle} src={confirmNegativeImg} />
                    <span id="errorMsg" style={errorMsgStyle}>Please enter a word.</span>
                    </div>
                </p>
                <br />
                <p align={"center"}>
                    <button style={checkBtnStyle} onClick={this.btnClicked}>Check</button>
                    <div>{this.state.result}</div>

                </p>
            </div>
        );   
    }
}

export default Palindrome;