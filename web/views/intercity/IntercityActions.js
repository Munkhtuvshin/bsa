import * as types from './IntercityConstant'
import axios from 'axios'
import { intercityApi } from '../../api/IntercityApi'

export function getAllRides(page) {
	return dispatch => {
		dispatch({
			type: types.GET_ALL_RIDES,
		})
		
		return intercityApi.getAllRides(page)
		.then( function (response) {

	    	let payload = {
	    		rides: response.data.rides,
	    		active_ride: response.data.active_ride
	    	}

			dispatch({
				type: types.GET_ALL_RIDES_FULFILLED,
				payload
			})
	    })
	    .catch(function (error) {
	     	alert(error)
	    })
	}
}

export function getPopularRides(params) {
	return dispatch => {
		dispatch({
			type: types.GET_POPULAR_RIDES,
		})
		
		return intercityApi.getPopularRides(params)
		.then( function (response) {

	    	let payload = response.data
			dispatch({
				type: types.GET_POPULAR_RIDES_FULFILLED,
				payload
			})
	    })
	    .catch(function (error) {
	     	alert(error)
	    })
	}
}

export function getDateFilter(data) {
	return dispatch => {
		// dispatch({
		// 	type: types.GET_ALL_RIDES,
		// })
		
		return intercityApi.getDateFilter(data)
		.then( function (response) {

	  //   	let payload = {
	  //   		rides: response.data.rides,
	  //   		active_ride: response.data.active_ride
	  //   	}

			// dispatch({
			// 	type: types.GET_ALL_RIDES_FULFILLED,
			// 	payload
			// })
	    })
	    .catch(function (error) {
	     	alert(error)
	    })
	}
}