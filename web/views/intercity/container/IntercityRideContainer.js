'use strict';
import {connect} from 'react-redux'
import {bindActionCreators} from 'redux'
import IntercityRideTable from '../component/IntercityRideTable'
import { 
  getAllRides,
  getDateFilter 
} from '../IntercityActions'

import { toJS } from 'immutable'

export default connect(
   state => ({
   	  rides: state.intercity.get('rides').toJS(),
      citys: state.intercity.get('citys'),
   }),
   dispatch => {
     return {
       getAllRides: bindActionCreators(getAllRides, dispatch),
       getDateFilter: bindActionCreators(getDateFilter, dispatch)
     }
   }
)(IntercityRideTable)
