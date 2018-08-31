import React, { Component, PropTypes } from 'react'
import EventForm from '../component/EventForm.js'
import { connect } from 'react-redux'
import { bindActionCreators } from 'redux'
import { Redirect  } from 'react-router-dom'
import { editEvent, editOnChanged, editOnStartAtChanged, editOnEndAtChanged, editOnLocationChanged, editShowMap, editOnCoverChanged,
          edit_handleScale, edit_handlePositionChange, edit_handleXPosition, edit_handleYPosition, edit_setPreview,
          editchangeField, editOnCloseMap,
        } from '../EventActions'

function select(state) {
  return {
    add_event: state.events.getIn(['selected_event']).toJS(),
    add_event_editor: state.events.getIn(['edit_event_editor']).toJS()
  }
}

function mapDispatchToProps( dispatch ) {
  return {
    showMap: bindActionCreators(editShowMap, dispatch),
    onLocationChanged: bindActionCreators( editOnLocationChanged, dispatch),
    handleScale: bindActionCreators(edit_handleScale, dispatch),
    handlePositionChange: bindActionCreators(edit_handlePositionChange, dispatch),
    handleXPosition: bindActionCreators(edit_handleXPosition, dispatch),
    handleYPosition: bindActionCreators(edit_handleYPosition, dispatch),
    setPreview: bindActionCreators(edit_setPreview, dispatch),
    changeField: bindActionCreators(editchangeField, dispatch),
    onCloseMap: bindActionCreators(editOnCloseMap, dispatch),
    checkEqual: bindActionCreators(editEvent, dispatch)
  }
}

export default connect( select, mapDispatchToProps )(EventForm);