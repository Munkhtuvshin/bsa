'use strict';
//import Chart from 'chart.js'

//import { Button, Container, Header } from 'semantic-ui-react'
import {connect} from 'react-redux'
import {bindActionCreators} from 'redux'
//import {NavigationActions} from 'react-navigation'
import DashboardView from '../component/DashboardView'
import { 
  getTotalCountBoth,
  getUserImpovementChart,
} from '../DashboardActions'
import { toJS } from 'immutable'

export default connect(
   state => ({
   	   total_count: state.dashboard.get('total_count').toJS(),
       userCharts: state.dashboard.get('userCharts').toJS(),
   }),
   dispatch => {
     return {
       //navigate: bindActionCreators(NavigationActions.navigate, dispatch),
       //backAction: bindActionCreators(NavigationActions.back, dispatch),
       getTotalCountBoth: bindActionCreators(getTotalCountBoth, dispatch),
       getUserImpovementChart: bindActionCreators(getUserImpovementChart, dispatch),
     }
   }
)(DashboardView)
