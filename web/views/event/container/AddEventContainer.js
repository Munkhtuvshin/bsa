import React, { Component, PropTypes } from 'react'
import EventForm from '../component/EventForm.js'
import { bindActionCreators } from 'redux'
import { connect } from 'react-redux'
import { showMap, onLocationChanged,
         handleScale, handlePositionChange, handleXPosition, handleYPosition, setPreview, changeField, 
         getAddressName, checkEqual, showPreview, onCloseMap
       } from '../EventActions'

function select( state ) {
  return {
    add_event: state.events.getIn(['add_event']).toJS(),
    add_event_editor: state.events.getIn(['add_event_editor']).toJS()
  }
}

function mapDispatchToProps( dispatch ) {
  return {
    showMap: bindActionCreators(showMap, dispatch),
    handleScale: bindActionCreators(handleScale, dispatch),
    handlePositionChange: bindActionCreators(handlePositionChange, dispatch),
    handleXPosition: bindActionCreators(handleXPosition, dispatch),
    handleYPosition: bindActionCreators(handleYPosition, dispatch),
    setPreview: bindActionCreators(setPreview, dispatch),
    onLocationChanged: bindActionCreators(onLocationChanged, dispatch),
    changeField: bindActionCreators(changeField, dispatch),
    checkEqual: bindActionCreators(checkEqual, dispatch),
    onCloseMap: bindActionCreators(onCloseMap, dispatch),
  }
}

export default connect( select, mapDispatchToProps )(EventForm);
