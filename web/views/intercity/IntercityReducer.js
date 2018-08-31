import * as types from './IntercityConstant'

import { InitialState } from './IntercityInitial'

export default function intercity(state = InitialState, action) {
	switch (action.type) {
		case types.GET_POPULAR_RIDES:
			return state.setIn(['popular', 'fetching'], true)
		case types.GET_POPULAR_RIDES_FULFILLED:
			return state.setIn(['popular', 'fetching'], false)
						.setIn(['popular', 'data'], action.payload.result)
		case types.GET_ALL_RIDES:
			return state.setIn(['rides', 'fetching'], true)
		case types.GET_ALL_RIDES_FULFILLED:
			return state.setIn(['rides', 'fetching'], false)
						.setIn(['rides', 'data'], action.payload.rides)
						.setIn(['rides', 'active_ride'], action.payload.active_ride)
		default:
			return state
	} 
}
