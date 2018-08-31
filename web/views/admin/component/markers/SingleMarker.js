'use strict';

import React, { Component } from 'react';
import { render } from 'react-dom'

class SingleMarker extends React.PureComponent {
  _colorFilter(text) {
  	  return "#f2f2f2"
  }

  render() {
  	let {
  		text,
  		color
  	} = this.props

    return (
      <div style={{
	    position: 'relative', 
	    color: 'white', 
	    height: 40, 
	    width: 40,
	    justifyContent: 'center', 
	    alignItems: 'center',
	    top: -12, 
	    left: -10, 
	    display: 'flex'
	  }}>
	    <img src="http://localhost:3000/img/logo.png" width="20" height="24"/>
	  </div>
    );
  }
}

export default SingleMarker;