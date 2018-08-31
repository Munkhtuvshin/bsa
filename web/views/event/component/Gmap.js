import React, { Component, PropTypes } from 'react'
import ReactDOM from 'react-dom';
import GoogleMap from 'google-map-react';
import styled from 'styled-components';
import { Button, Modal, Header, Icon, Image } from 'semantic-ui-react'

const CustomMarke = ({ text, }) => (<div className='klass' >{text}</div>)

const CustomMarker = styled.div`
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  padding: 0px 3px 3px 0;
  border-radius: 50% 50% 50% 0%;
  box-shadow: -1px 1px 4px 0px rgba(0, 0, 0, 0.5);
  background: red;
  transform: translate(-50%, -50%) rotateX(20deg) rotateZ(-45deg);
  transform-origin: 50% 50%;

  & > span {
    display: none;
    position: absolute;
    left: 6px;
    top: 2px;
    transform: rotate(45deg);
    font-size: 16px;
    color: red;
  }
`;

export default class Gmap extends React.Component {
  
	constructor(props) {
	  super(props);
	  this.state=this.props.coordinate
	}
	onClose = () => {
		this.props.showMap()
	}
	onLocationChanged = (value) => {
		this.setState({ latitude:value.lat, longitude:value.lng})
	}
  render(){
  	// console.log(this.state);
    return (
		  <Modal open={this.props.showmap} onClose={this.props.onClose}>
	      <Modal.Header>Байршил сонгох</Modal.Header>
	      <Modal.Content >
	        <Modal.Description>
	        	<div style={{ height: '100vh', width: '100%' }}>
		          <GoogleMap
		            bootstrapURLKeys={{ key:'AIzaSyAGitiN41FPl8mcC3zBN7yC9Av9y5CJxEc' }}
			        	center= { { lat: parseFloat(this.props.coordinate.latitude), lng: parseFloat(this.props.coordinate.longitude) } }
			        	zoom={8}
			        	onClick={(value) => this.onLocationChanged(value)}>
						    <CustomMarker
						      lat={ this.state.latitude }
							  lng={ this.state.longitude }
						      text=" ">
					      </CustomMarker>
			      	</GoogleMap>
		    		</div>
	        </Modal.Description>
	      </Modal.Content>

	      <Modal.Actions>
	        <Button primary onClick={this.addLocation}>
	          Хадгалах <Icon name='right chevron' />
	        </Button>
	      </Modal.Actions>
	    </Modal>
		)
  }
  addLocation = (coordinate) =>{
  	
    this.props.onLocationChanged(this.state)
    this.props.onSave()
  }

}