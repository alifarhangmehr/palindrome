import { StatusBar } from 'expo-status-bar';
import React, { Component, useState } from 'react';
import { StyleSheet, Text, View, Image, Button, TouchableOpacity, TextInput } from 'react-native';
import confirmPositiveImg from '../assets/images/confirm-positive.png';
import confirmNegativeImg from '../assets/images/confirm-negative.png';
import { useFonts } from 'expo-font';
import * as Network from 'expo-network';


class Palindrome extends React.Component {
  btnClicked = () => {
    if (this.state.word == '') {
      alert("Please type a word");
    } else {
      Network.getIpAddressAsync().then((ip) => {
        this.fetchAPI(ip);
      });
    }
  }

  constructor(props) {
    super(props);
    this.state = {
      resultImgSrc: confirmNegativeImg,
      word: ''
    }
  }

  showNegativeImg = () => {
    this.setState({
      resultImgSrc: confirmNegativeImg
    })
  }

  showPositiveImg = () => {
    this.setState({
      resultImgSrc: confirmPositiveImg
    })
  }

  fetchAPI = (ip) => {
    const json = JSON.stringify({ word: this.state.word });
    let token = "8efe07b353ccb4e5515d2062cb1976bf4cfdbfada6ffaf3c005e2c1e1515e6db";

    fetch('http://' + ip + ':8000/v1/palindromes', {
      method: 'post',
      headers: {
        'Content-Type': 'application/json', 'Authorization': 'Bearer ' + token
      },
      body: json
    })
      .then((response) => response.json())

      .then((responseJson) => {
        console.log(responseJson);
        this.showNegativeImg();
        if (responseJson.message.includes("is a")) {
          this.showPositiveImg();
        } else {
          this.showNegativeImg();
        }

      })
      .catch((error) => {
        console.error(error);
      });
  }

  render() {
    return (
      <View style={styles.palindromeContainer}>
        <View style={styles.headerView}>
          <Text style={styles.palindromeTitleText}>Palindrome</Text>
          <Text style={styles.palindromeTitleText}>Check</Text>
        </View>
        <View style={styles.spacerView1}></View>
        <View>
          <Text style={styles.wordTxt}>Your Word</Text>
        </View>
        <View>
          <TextInput style={styles.wordInput} onChangeText={(word) => this.setState({ word: word })} />
        </View>
        <View style={styles.confirmImgView}>
          {/* <Image source={this.state.source} /> */}
          <Image
            source={this.state.resultImgSrc}
          />

        </View>
        <View style={styles.spacerView1}></View>
        <View style={styles.checkBtnView}>
          <TouchableOpacity
            style={styles.checkButton}
            onPress={this.btnClicked}
          >
            <Text style={styles.checkText}>CHECK</Text>
          </TouchableOpacity>
        </View>
      </View>
    );
  }
}

const styles = StyleSheet.create({
  palindromeContainer: {
    flex: 1,
    backgroundColor: 'white',
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'column'
  },

  checkButton: {
    marginRight: 40,
    marginLeft: 40,
    justifyContent: "center",
    backgroundColor: "#E8CA60",
    borderRadius: 5,
    width: 152,
    height: 46
  },

  tryItText: {
    color: '#fff',
    textAlign: 'center',
    paddingLeft: 10,
    paddingRight: 10,
    paddingTop: 20,
    fontFamily: "Roboto-Bold",
    fontSize: 14
  },

  checkText: {
    color: '#000',
    textAlign: 'center',
    paddingLeft: 10,
    paddingRight: 10,
    fontFamily: "SFProText-Regular",
    fontSize: 14,
    fontWeight: "600"
  },

  palindromeTitleText: {
    color: "black",
    textAlign: "left",
    fontSize: 32,
    fontFamily: "BebasNeue-Regular"
  },

  spacerView1: {
    height: 100
  },

  wordTxt: {
    fontFamily: "BebasNeue-Light",
    fontSize: 50
  },

  wordInput: {
    width: 244,
    height: 57,
    borderWidth: 1,
    borderColor: "black",
    borderRadius: 10,
    padding: 10,
    fontSize: 40,
    fontFamily: "BebasNeue-Regular"
  },

  confirmImgView: {
    height: 150,
    justifyContent: 'center'
  }
})
export default Palindrome;