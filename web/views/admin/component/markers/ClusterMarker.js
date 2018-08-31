'use strict';

import React, { Component } from 'react';
import PropTypes from 'prop-types'
import { render } from 'react-dom'

class ClusterMarker extends React.PureComponent {
  static propTypes = {
      color: PropTypes.string,
      points: PropTypes.array,
      has_passengers: PropTypes.bool,
      selected: PropTypes.bool,
  };
  static defaultProps = {
      color: 'red',
      points: [],
      has_passengers: false,
      selected: false
  }

  _colorFilter(text) {
  	  //if(text < 10) return "#5BC0EB"
  	  //if(text < 20) return "#66cc22"
  	  //if(text < 30) return "#FDE74C"
  	  //if(text < 40) return "#E55934"
  	  //if(text < 50) return "#9BC53D"
      return '#5BC0EB'
  	  //return '#66cc22'
  }

  _renderCount(text) {
    return (
        <h3>
          {text}
        </h3>
    )
  }

  _renderPassengersCount(text, points, selected) {
    let combinedRideCount = 0
    points.forEach((point) => {
      if(point.passengers_count > 0) combinedRideCount ++
    })

     return (
        <h3 style={{
           fontSize: 19
        }}>
          {text}/<span style={{
              fontSize: 17,
          }}>{combinedRideCount}</span>
        </h3>
     )
  }

  render() {
  	let {
  		text,
      color,
      points,
      selected,
      has_passengers
  	} = this.props

    return (
      <div style={{
	    position: 'relative', 
	    color: 'white', 
	    background: color,
      opacity: has_passengers ? 0.7 : 0.9,
	    height: 40, 
	    width: has_passengers ? 70 : 40,
	    borderRadius: has_passengers ? 10 : 20,
      transform: 'scale(' + (selected ? 2 : 1) + ')',
	    justifyContent: 'center', 
	    alignItems: 'center',
	    top: -20, 
	    left: -20, 
	    display: 'flex'
	  }}>
        {has_passengers ? this._renderPassengersCount(text, points, selected) : this._renderCount(text)}
	  </div>
    );
  }
}

export default ClusterMarker;