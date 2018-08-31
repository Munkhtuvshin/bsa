import { render } from 'react-dom'
import React, { Component } from 'react'
import { 
	BrowserRouter as Router, 
	Route,
	Redirect, Switch
} from 'react-router-dom'

import { connect } from 'react-redux'

import DashboardViewContainer from './views/admin/container/DashboardViewContainer'
import RideCollisionContainer from './views/admin/container/RideCollisionContainer'
import LoginContainer from './views/admin/container/LoginContainer'
import IntercityDashboardContainer from './views/intercity/container/IntercityDashboardContainer'
import IntercityRideContainer from './views/intercity/container/IntercityRideContainer'
import LogoutContainer from './views/auth/container/LogoutContainer'
import AddEventContainer from './views/event/container/AddEventContainer'
import EventContainer from './views/event/container/EventContainer'
import EditEventContainer from './views/event/container/EditEventContainer'

import PrivateRoute from './PrivateRoute'

class App extends Component {	
	state = {
		isAuthenticated: false
	}

	componentWillMount() {
		let token = sessionStorage.getItem('accessToken')
		if(token) {
			this.setState({
		     	isAuthenticated: true
		    })
		}
	    // 
	}

	componentWillReceiveProps(nextProps) {
	    if(nextProps.isAuthenticated != this.props.isAuthenticated) {
	    	window.location.reload()
	    }
	}
	
	render() {
		return (
			<div style={{ height: '100%' }}>
				<Router>
					<Switch>
						<Route exact={true} path="/admin" component={this.state.isAuthenticated ? DashboardViewContainer : LoginContainer} />
						<Route path="/admin/logout" component={LogoutContainer} />
						<PrivateRoute path="/admin/intercity" component={IntercityDashboardContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/dashboard" component={DashboardViewContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/intercity-ride" component={IntercityRideContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/ride-collision" component={RideCollisionContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/event" component={EventContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/addEvent" component={AddEventContainer} isAuthenticated={this.state.isAuthenticated}/>
						<PrivateRoute path="/admin/editEvent" component={EditEventContainer} isAuthenticated={this.state.isAuthenticated}/>
					</Switch>
				</Router>
			</div>
		)
	}
}

const mapStateToProps = ({ auth }) => ({
  isAuthenticated: auth.get('isAuthenticated')
});

export default connect(mapStateToProps)(App);
