import { combineReducers } from "redux"
import { routerReducer } from 'react-router-redux'

import intercity from './views/intercity/IntercityReducer'
import auth from './views/auth/AuthReducer'
import dashboard from './views/admin/DashboardReducer'
import events from './views/event/EventReducer'

export default combineReducers({
	intercity,
	dashboard,
	auth,
	events,
	routing: routerReducer,
})