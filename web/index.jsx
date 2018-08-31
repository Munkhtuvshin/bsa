import React, { Component } from 'react'
import { render } from 'react-dom'
import { createStore } from 'redux'
import { Provider } from 'react-redux'
import store from './store'
//import { BrowserRouter as Router, Route } from 'react-router-dom'
import { ConnectedRouter, routerReducer } from 'react-router-redux'
import createHistory from 'history/createBrowserHistory'

import App from './App'

const history = createHistory()

render(
  	<Provider store={store}>
      	<ConnectedRouter history={history}>
      		  <App />
  		</ConnectedRouter>
    </Provider>,
  	document.getElementById('container')	
)