import * as types from './DashboardConstant'
import DashboardApi from '../../api/DashboardApi'

export function getRideCollision(params) {
	return dispatch => {
		dispatch({
			type: types.GET_RIDE_COLLISION,
		})

		DashboardApi.getRideCollision(params)
		.then((res) => {
			dispatch({
				type: types.GET_RIDE_COLLISION_FULFILLED,
				payload: {
					rides: res.data.rides,
					find_rides: res.data.find_rides,
				}
			})
		})
	}
}

export function getTotalCountBoth(params) {
	return dispatch => {
		dispatch({
			type: types.GET_TOTAL_COUNT_BOTH,
		})

		DashboardApi.getTotalCountBoth()
        .then((res) => {

        	dispatch({
				type: types.GET_TOTAL_COUNT_BOTH_FULFILLED,
				payload: res.data.result
			})
        })
        .catch(err => {

        })		
	}
}

export function getUserImpovementChart() {
	return dispatch => {
		dispatch({
			type: types.GET_USER_IMPROVEMENT_CHART,
		})

		DashboardApi.getUserImprovement()
        .then((res) => {
        	dispatch({
				type: types.GET_USER_IMPROVEMENT_CHART_FULFILLED,
				payload: res.data.result
			})
        })
        .catch(err => {

        })	

		
	}
}