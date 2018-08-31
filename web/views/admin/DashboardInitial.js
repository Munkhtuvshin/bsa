import { Map, } from 'immutable'

export const InitialState = Map({
	total_count: Map({
		fetching: false,
		data: Map({
			total_user: 0,
			total_active_ride: 0,
			total_ride: 0,
		}),
	}),
	userCharts: Map({
		fetching: false,
		filter: {},
		data: [],
	}),
	rideCollisions: Map({
		fetching: false,
		rides: [],
		find_rides: [],
	})
})