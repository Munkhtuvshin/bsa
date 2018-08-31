import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux'
import { deleteEvent, setEvent, setAllEvent } from '../EventActions'

import { bindActionCreators } from 'redux'
import EventList from '../component/EventList'


function select(state) {
  return {
    events: state.events.getIn(['events']).toJS()
  }
}

function mapDispatchToProps(dispatch) {
  return {
    deleteEvent: bindActionCreators(deleteEvent, dispatch),
    setAllEvent: bindActionCreators(setAllEvent, dispatch),
    setEvent: bindActionCreators(setEvent, dispatch),   
  }
}

export default connect(select, mapDispatchToProps)(EventList);