import { fromJS } from 'immutable'

export let InitialState = fromJS({
	user: {
		fetching: false,
		data: {}
	},
	isAuthenticated: false
})