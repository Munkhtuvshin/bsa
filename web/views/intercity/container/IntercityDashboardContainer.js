'use strict';
import {connect} from 'react-redux'
import {bindActionCreators} from 'redux'
import IntercityDashboard from '../component/IntercityDashboard'
import { 
	getPopularRides 
} from '../IntercityActions'

import { toJS } from 'immutable'

export default connect(
   state => ({
   	  popular: state.intercity.get('popular').toJS(),
   }),
   dispatch => {
     return {
       getPopularRides: bindActionCreators(getPopularRides, dispatch),
     }
   }
)(IntercityDashboard)
