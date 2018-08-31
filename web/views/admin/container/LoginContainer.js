'use strict';
//import Chart from 'chart.js'

//import { Button, Container, Header } from 'semantic-ui-react'
import {connect} from 'react-redux'
import {bindActionCreators} from 'redux'
//import {NavigationActions} from 'react-navigation'
import Login from '../component/Login'
import {
  onLoginAction
} from '../../auth/AuthActions'
import { toJS } from 'immutable'

export default connect(
   state => ({
       //total_count: state.dashboard.get('total_count').toJS(),
       //userCharts: state.dashboard.get('userCharts').toJS(),
   }),
   dispatch => {
     return {
         onLoginAction: bindActionCreators(onLoginAction, dispatch)
       //navigate: bindActionCreators(NavigationActions.navigate, dispatch),
       //backAction: bindActionCreators(NavigationActions.back, dispatch),
       //getTotalCountBoth: bindActionCreators(getTotalCountBoth, dispatch),
       //getUserImpovementChart: bindActionCreators(getUserImpovementChart, dispatch),
     }
   }
)(Login)
