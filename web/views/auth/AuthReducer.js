import { InitialState } from './AuthInitial'

import * as types from './AuthConstant'

export default function authState(state = InitialState, action) {
	switch(action.type) {
		case types.ON_LOGIN_ACTION:
			return state.setIn(['user', 'fetching'], true)
		case types.ON_LOGIN_ACTION_FAILED:
			return state.setIn(['user', 'fetching'], false)
		
		case types.ON_LOGIN_ACTION_FULFILLED: {
			return state.set('isAuthenticated', true)
						.setIn(['user', 'fetching'], false)
		}
		default: 
			return state
	}
}