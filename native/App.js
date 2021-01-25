import { StatusBar } from 'expo-status-bar';
import React, { Component, useState } from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import Home from './Components/Home';
import Palindrome from './Components/Palindrome';

const Stack = createStackNavigator();

function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator>
        <Stack.Screen name="Home" component={Home} />
        <Stack.Screen name="Palindrome" component={Palindrome} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default App;