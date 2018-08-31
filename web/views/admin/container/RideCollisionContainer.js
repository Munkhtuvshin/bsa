'use strict';
//import Chart from 'chart.js'

//import { Button, Container, Header } from 'semantic-ui-react'
import {connect} from 'react-redux'
import {bindActionCreators} from 'redux'
//import {NavigationActions} from 'react-navigation'
import RideCollision from '../component/RideCollision'
import { 
  getRideCollision,
  getUserImpovementChart,
} from '../DashboardActions'
import { toJS } from 'immutable'

export default connect(
   state => ({
   	   //total_count: state.dashboard.get('total_count').toJS(),
       rideCollisions: state.dashboard.get('rideCollisions').toJS(),
   }),
   dispatch => {
     return {
       getRideCollision: bindActionCreators(getRideCollision, dispatch),
       //navigate: bindActionCreators(NavigationActions.navigate, dispatch),
       //backAction: bindActionCreators(NavigationActions.back, dispatch),
       //getRideCollision: bindActionCreators(getRideCollision, dispatch),
       //getUserImpovementChart: bindActionCreators(getUserImpovementChart, dispatch),
     }
   }
)(RideCollision)
