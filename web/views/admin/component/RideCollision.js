'use strict';

import React, { Component } from 'react';
import { render } from 'react-dom'
import { Tab, Button, Container, Header } from 'semantic-ui-react'
import 'react-dates/initialize';
import { DateRangePicker, SingleDatePicker, DayPickerRangeController, isInclusivelyBeforeDay } from 'react-dates'
import GoogleMapReact from 'google-map-react'
import moment from 'moment'
//import ClusterMarker from './markers/ClusterMarker'
//import SimpleMarker from './markers/SimpleMarker'
import supercluster from 'points-cluster'

import ClusterMarker from './markers/ClusterMarker'
import SingleMarker from './markers/SingleMarker'

const susolvkaCoords = { lat: 47.918981, lng: 106.917626 };

class RideCollision extends Component {
    static defaultProps = {
        center: {
            lat: 47.918981, 
            lng: 106.917626
        },
        zoom: 13,
        clusterRadius: 60,
        minZoom: 3,
        maxZoom: 15,
    }

    constructor(props) {
      super(props);

      this.state = {
        clusters: [],
        searchClusters: [],
        rides: [],
        find_rides: [],
        mapProps: {
            center: susolvkaCoords,
            zoom: 10,
        },
        selectedLocation: 'start_location',
        startDate: moment().subtract(7, 'days'),
        endDate: moment(),
        focusedInput: null,
        selectedRide: null
      }

      //alert(this.state.clusters)
    }

    componentWillMount() {
        let {
            startDate,
            endDate,
        } = this.state

        this.props.getRideCollision({ 
            startDate: startDate.format("YYYY-MM-DD"), 
            endDate: endDate.format("YYYY-MM-DD"), 
        })
    }

    componentWillReceiveProps(nextProps) {
        let rides = []
        let find_rides = []

        if(!nextProps.rideCollisions.fetching && this.props.rideCollisions.fetching) {
            rides = nextProps.rideCollisions.rides.map((ride) => ({
                _id: ride._id,
                lat: ride[this.state.selectedLocation].coordinate[1],
                lng: ride[this.state.selectedLocation].coordinate[0],
                passengers_count: ride.passengers.length,
            }))

            const findRideFilled = this.state.selectedLocation == 'start_location' ? 'from_distination_filled' : 'to_distination_filled'
            const findRideLocation = this.state.selectedLocation == 'start_location' ? 'from_distination' : 'to_distination'

            nextProps.rideCollisions.find_rides.forEach((search) => {

                if(search[findRideFilled]) {
                    find_rides.push({
                        _id: search._id,
                        lat: search[findRideLocation].coordinate[1],
                        lng: search[findRideLocation].coordinate[0],
                    })
                }
            })

            this.setState({
                rides,
                find_rides,
            }, () => this.recalculate(this.state.mapProps))
        }
    }

    onDatesChange = ({ startDate, endDate }) => {
        this.setState({ 
            startDate, endDate 
        }, () => {
            this.props.getRideCollision({ 
                startDate: moment(startDate).format("YYYY-MM-DD"), 
                endDate: endDate ? moment(endDate).format("YYYY-MM-DD") : moment(startDate).format("YYYY-MM-DD"), 
            })
        })
    }

    setLocation = (selectedLocation) => {
        let rides = []
        let find_rides = []

        rides = this.props.rideCollisions.rides.map((ride) => ({
            _id: ride._id,
            lat: ride[selectedLocation].coordinate[1],
            lng: ride[selectedLocation].coordinate[0],
            passengers_count: ride.passengers.length,
        }))

        //console.log(this.state.selectedLocation)
        const findRideFilled = selectedLocation == 'start_location' ? 'from_distination_filled' : 'to_distination_filled'
        const findRideLocation = selectedLocation == 'start_location' ? 'from_distination' : 'to_distination'

        this.props.rideCollisions.find_rides.forEach((search) => {
            if(search[findRideFilled]) {
                find_rides.push({
                    _id: search._id,
                    lat: search[findRideLocation].coordinate[1],
                    lng: search[findRideLocation].coordinate[0],
                })
            }
        })

        this.setState({
            rides,
            find_rides,
            selectedLocation
        }, () => this.recalculate(this.state.mapProps))
    }

    onChange = (event) => {
        this.recalculate(event)
    }

    recalculate = ({ center, zoom, bounds }) => {
        let clusters = supercluster(this.state.rides, {
             minZoom: this.props.minZoom,
             maxZoom: this.props.maxZoom,
             radius: this.props.clusterRadius
        })({
             center,
             zoom,
             bounds
        })

        let searchClusters = supercluster(this.state.find_rides, {
             minZoom: this.props.minZoom,
             maxZoom: this.props.maxZoom,
             radius: this.props.clusterRadius
        })({
             center,
             zoom,
             bounds
        })

        this.setState({
            clusters: clusters.map(({ wx, wy, numPoints, points }, i) => ({
                lat: wy,
                lng: wx,
                text: numPoints,
                numPoints,
                points,
                id: i,
            })),
            searchClusters: searchClusters.map(({ wx, wy, numPoints, points }, i) => ({
                lat: wy,
                lng: wx,
                text: numPoints,
                numPoints,
                points,
                id: i,
            })),
            mapProps: {
                center,
                zoom,
                bounds
            }
        })
    }

    onChildMouseEnter = (hoverKey, item) => {
        if(item.has_passengers) {
            this.setState({
                selectedRide: item,
            })
        }
        
        //setHoveredMarkerId(id)
    }

    onChildMouseLeave = () => {
        //setHoveredMarkerId(-1)
        this.setState({
            selectedRide: null,
        })
    }

	render() {
      let {
        clusters,
        searchClusters,
        selectedLocation,
        startDate,
        endDate,
        selectedRide
      } = this.state

      //alert(selectedRide ? JSON.stringify(selectedRide) : -1)
        //alert(JSON.stringify(clusters))

	    return (
    	    <div style={{
                height: '100%',
    	    }}>
              <div class="ui fixed inverted menu">
                <div class="ui container">
                    <a href="#" class="header item">
                        <img class="logo" src="/img/logo.png" style={{ transform: 'scale(0.5)' }} />
                        Beeco
                    </a>
                    <a href="/admin/dashboard" class="item">Статистек</a>
                    <a href="/admin/ride-collision" class="item">Газрын зураг</a>
                    <a href="/admin/intercity-ride" class="item">Хот хооронд жагсаалт</a>
                    <a href="/admin/intercity" class="item">Хот хооронд cтатистик</a>
                    <div class="ui simple dropdown item">
                    Хэрэглэгч <i class="dropdown icon"></i>
                    <div class="menu">
                      <div class="divider"></div>
                      <div class="header">admin@gmail.com</div>
                      <div class="item">
                        <i class="dropdown icon"></i>
                        Sub Menu
                        <div class="menu">
                        </div>
                      </div>
                      <a class="item" href="/admin/logout">Системээс гарах</a>
                    </div>
                  </div>
                </div>
            </div>
              <div style={{ 
                height: '90px', 
                backgroundColor: 'rgba(255, 255, 255, 0.8)', 
                padding: 20, 
                position: 'absolute',
                top: 60,
                left: 0,
                right: 0,
                zIndex: 10,
              }}>
                <div style={{
                    display: 'flex',
                    flexDirection: 'row',
                    alignItems: 'center',
                }}>
                  <div style={{ }}>
                      <Button.Group>
                        {
                            selectedLocation == 'start_location' ? (
                                <Button positive onClick={() => this.setLocation('start_location')}>ХААНААС</Button>
                            ) : (
                                <Button onClick={() => this.setLocation('start_location')}>ХААНААС</Button>
                            )
                        }
                        <Button.Or text='or' />
                        {
                            selectedLocation != 'start_location' ? (
                                <Button positive onClick={() => this.setLocation('end_location')}>ХААШАА</Button>
                            ) : (
                                <Button onClick={() => this.setLocation('end_location')}>ХААШАА</Button>
                            )
                        }
                      </Button.Group>
                  </div>

                    <div style={{ flex: 1, paddingLeft: 30, }}>
                        <DateRangePicker
                              startDate={startDate} // momentPropTypes.momentObj or null,
                              endDate={endDate} // momentPropTypes.momentObj or null,
                              endDateId="endDate"
                              startDateId="startDate"
                              isOutsideRange={day => !isInclusivelyBeforeDay(day, moment())}
                              onDatesChange={this.onDatesChange} // PropTypes.func.isRequired,
                              focusedInput={this.state.focusedInput} // PropTypes.oneOf([START_DATE, END_DATE]) or null,
                              onFocusChange={focusedInput => this.setState({ focusedInput })} // PropTypes.func.isRequired,
                        />
                    </div>
                </div>
              </div>
        	    <GoogleMapReact
                    defaultCenter={this.props.center}
                    defaultZoom={this.props.zoom}
                    bootstrapURLKeys={{key: 'AIzaSyAG-RaJkH2WrDFcdQXRZKFlpDlAiEmc5KU'}}
                    onChange={this.onChange}
                    onChildMouseEnter={this.onChildMouseEnter}
                    onChildMouseLeave={this.onChildMouseLeave}
                >
                    {
                        searchClusters.map(({ lat, lng, numPoints, points }) => (
                            <ClusterMarker 
                              lat={lat}
                              lng={lng}
                              text={numPoints}
                              color={"#9BC53D"}
                            />
                        ))
                    }

                    {
                        clusters.map(({ lat, lng, numPoints, points, id }) => (
                            <ClusterMarker
                              lat={lat}
                              lng={lng}
                              text={numPoints}
                              color={"#5BC0EB"}
                              has_passengers={true}
                              selected={selectedRide ? (selectedRide.points[0]._id == points[0]._id ? true: false) : false}
                              points={points}
                            />
                        ))
                    }
                </GoogleMapReact>
    	    </div>
	    )
	}
}

// clusters.map(({ ...markerProps, id, numPoints }) => (
//                             numPoints === 1
//                                 ? <SimpleMarker key={id} {...markerProps} />
//                                 : <ClusterMarker key={id} {...markerProps} />
//                         ))

export default RideCollision;