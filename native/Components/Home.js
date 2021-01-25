import React, { Component, useState } from 'react';
import { StyleSheet, Text, View, Image, Button, TouchableOpacity, TextInput } from 'react-native';
import logo from '../assets/images/mirror-img.png';
import { useFonts } from 'expo-font';
import AppLoading from 'expo-app-loading';


const HomeScreen = ({ navigation }) => {
    let [fontsLoaded] = useFonts({
        'BebasNeue-Light': require('../assets/fonts/BebasNeue-Light.ttf'),
        'BebasNeue-Regular': require('../assets/fonts/BebasNeue-Regular.ttf'),
        'Roboto-Bold': require('../assets/fonts/Roboto-Bold.ttf'),
        'SFProText-Regular': require('../assets/fonts/SFProText-Regular.ttf')
    });

    if (!fontsLoaded) {
        return <AppLoading />;
    } else {
        return (
            <View style={styles.container}>
                <Image source={logo} />
                <View>
                    <Text style={styles.titleText}>Palindrome</Text>
                    <View>
                        <Text style={styles.descText}>A palindrome is a word, number, phrase, or other sequence of characters which reads the same backward as forward, such as madam or racecar.</Text>
                    </View>
                    <View>
                        <TouchableOpacity
                            style={styles.tryItButton}
                            onPress={() => navigation.navigate('Palindrome')}
                            underlayColor='#fff'>
                            <Text style={styles.tryItText}>TRY IT NOW</Text>
                        </TouchableOpacity>
                    </View>
                </View>
            </View>

        );
    }
}

const styles = StyleSheet.create({
    container: {
      flex: 1,
      backgroundColor: '#161819',
      alignItems: 'center',
      justifyContent: 'center',
      flexDirection: 'column'
    },

    tryItButton: {
      marginRight: 40,
      marginLeft: 40,
      marginTop: 10,
      paddingTop: 10,
      paddingBottom: 10
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
  
    titleText: {
      color: "white",
      textAlign: "center",
      fontSize: 32,
      fontFamily: "BebasNeue-Regular"
    },
  
    headerView: {
      width: "80%"
    },
  
    descText: {
      color: "#A4A095",
      textAlign: "center",
      fontSize: 13,
      fontFamily: "SFProText-Regular",
      width: 262
    }
  })
export default HomeScreen;