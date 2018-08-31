import * as types from './DashboardConstant'

import { InitialState } from './DashboardInitial'

export default function dashboard(state = InitialState, action) {
	switch (action.type) {
		case types.GET_TOTAL_COUNT_BOTH:
			return state.setIn(['total_count', 'fetching'], true)

		case types.GET_TOTAL_COUNT_BOTH_FULFILLED:
			return state.setIn(['total_count', 'fetching'], false)
						.setIn(['total_count', 'data'], action.payload)

		case types.GET_USER_IMPROVEMENT_CHART: 
			return state.setIn(['userCharts', 'fetching'], true)
			
		case types.GET_USER_IMPROVEMENT_CHART_FULFILLED: {
			return state.setIn(['userCharts', 'fetching'], false)
						.setIn(['userCharts', 'data'], action.payload)
		}
		case types.GET_RIDE_COLLISION: {
			return state.setIn(['rideCollisions', 'fetching'], true)
		}
		case types.GET_RIDE_COLLISION_FULFILLED: {
			return state.setIn(['rideCollisions', 'fetching'], false)
						.setIn(['rideCollisions', 'rides'], action.payload.rides)
						.setIn(['rideCollisions', 'find_rides'], action.payload.find_rides)
		}
		default:
			return state
	} 
}
