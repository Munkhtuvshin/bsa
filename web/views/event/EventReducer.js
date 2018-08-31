import { combineReducers } from 'redux'
import * as types from './consts.js'
// import { DELETE_EVENT, SET_EVENT, EDIT_EVENT, SET_ALL_EVENT, 
//          CHANGE_TITLE, CHANGE_START_AT, CHANGE_END_AT, CHANGE_COVER_URL, CHANGE_LOCATION, SHOWMAP, 
//          EDIT_CHANGE_TITLE, EDIT_CHANGE_START_AT, EDIT_CHANGE_END_AT, EDIT_CHANGE_COVER_URL,SHOW_PREVIEW,
//          EDIT_CHANGE_LOCATION, EDIT_SHOWMAP, FIELD_CHANGED, GET_ADDRESS, EDIT_FIELD_CHANGED, CHECK_EQUAL,
//          CLOSE_MAP, EDIT_CLOSE_MAP
//         } from './EventActions'

import moment from 'moment';

var { Map, List,fromJS } = require('immutable');

const eventInitial = fromJS({
  events: [],
  add_event:{ title: '', event_start_at:moment(), event_finish_at:moment(), start_at: moment(), finish_at: moment(), cover_url: '', 
              location:{ latitude:47.920659, longitude:106.917636 }, showmap:false, checkEqual: {chek:false, count:-1}
            },
  add_event_editor:{ allowZoomOut: false, position: { x: 0.5, y: 0.5 }, scale: 1, 
              rotate: 0, borderRadius: 0,  width: 300, height: 534,
              preview: {img:'', rect:null,scale:0,width:0, height:0,borderRadius:0,showPreview:false}},
  edit_event_editor:{ allowZoomOut: false, position: { x: 0.5, y: 0.5 }, scale: 1, 
              rotate: 0, borderRadius: 0, preview: null, width: 300, height: 534,
              preview: {img:'', rect:null,scale:0,width:0, height:0,borderRadius:0,showPreview:false}},
  selected_event: {},
})

export default function events(state = eventInitial, action) {
  switch (action.type) {

    //----------Event actions---------------
    case types.FIELD_CHANGED: {
      return state.setIn(['add_event', action.field], fromJS(action.value) )
    }
    case types.EDIT_FIELD_CHANGED: {

      return state.setIn(['selected_event', action.field], fromJS(action.value) )
    }
    case types.CHECK_EQUAL: {
      console.log('checkEqual reducer')
      console.log(action.res.data)
      //  let event1 = { title:action.res.data.event.title, cover_url:action.res.data.cover_url,
      //     event_finish_at:action.res.data.event.event_finish_at, event_start_at:action.res.data.event.event_start_at,
      //     start_at:action.res.data.event.start_at, finish_at:action.res.data.event.finish_at,
      //     location:{ latitude:action.res.data.event.latitude, longitude: action.res.data.longitude},
      //     checkEqual: {check:false, count:0} }

      if(action.res.data.code==1){
        // let event = 
        //   checkEqual: } 
        return state.setIn(['add_event', 'checkEqual'], fromJS({check:true, count:action.res.data.count}))
      }
      let r ={title: '', event_start_at:moment(),
              event_finish_at:moment(), start_at: moment(),
              finish_at: moment(), cover_url: '', 
              location:{ latitude:47.920659, longitude:106.917636 },
              showmap:false, checkEqual: {chek:false, count:0}
            }
      return state.setIn(['add_event'], fromJS(r))
    } 
    case types.EDIT_EVENT: {

      if(action.res.data.code==1){
        return state.setIn(['selected_event', 'checkEqual'], fromJS({check:true, count:action.res.data.count}))
      }
      console.log('edit ehlsen')
      let events = state.get('events')
      var index = events.findIndex((event) => {
        return event.get('_id') == action.res.data.event._id
      })
      let tmp_event = {
        title: action.res.data.event.title, 
        cover_url:action.res.data.cover_url, 
        start_at:action.res.data.event.start_at,
        finish_at: action.res.data.event.finish_at, 
        event_start_at: action.res.data.event.event_start_at,
        event_finish_at:action.res.data.event.event_finish_at, 
        location:{ latitude:action.res.data.event.latitude, longitude:action.res.data.event.longitude},
        showmap:false,
        checkEqual: {chek:false, count:0}
      }
      return state.setIn(['events', index], fromJS(tmp_event));
    }

    case types.SET_EVENT: {
      let tmp = {showmap:false, checkEqual: {chek:false, count:-1}}
      let tmp1 = Object.assign(tmp, action.event);
      return state.set('selected_event',fromJS(tmp1))
    }
    case types.DELETE_EVENT: {
      let events = state.get('events')
      var index = events.findIndex((event) => {
        return event.get('_id') == action.id
      })
      return state.removeIn(['events', index])
    }
    case types.SET_ALL_EVENT: {
      return state.set('events', fromJS(action.events.data));
    }

    //-----------addForm actions-------------
    case types.CHANGE_LOCATION: {
      console.log(action)
      return state.setIn(['add_event', 'location'], fromJS(action.value));
    }

    case types.SHOWMAP: {
      let tmp = state.getIn(['add_event']).toJS();
      tmp.showmap = !tmp.showmap;
      return state.set('add_event', fromJS(tmp));
    }
    case types.CLOSE_MAP: {
      let tmp = state.getIn(['add_event']).toJS();
      tmp.showmap = false;
      return state.set('add_event', fromJS(tmp));
    }
    case types.EDIT_CLOSE_MAP: {
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.showmap = false;
      return state.set('add_event', fromJS(tmp));
    }
    case types.SHOW_PREVIEW: {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.showPreview = !tmp.showPreview;
      return state.set('add_event_editor', fromJS(tmp));
    }
    case types.GET_ADDRESS: {
      return state.add_event.setIn(['coordinate', 'addressName'], fromJS( action.formatted_address ) )
    }

    //---------addFormEditor actions-------
    case 'addFormScale': {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.scale = action.scale;
      return state.set('add_event_editor', fromJS(tmp))
    }
    case 'position change': {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.position = action.position;
      return state.set('add_event_editor', fromJS(tmp))
    }
    case 'position x change': {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.position.x = action.x;
      return state.set('add_event_editor', fromJS(tmp))
    }
    case 'position y change': {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.position.y = action.y;
      return state.set('add_event_editor', fromJS(tmp))
    }
    case 'set Preview': {
      let tmp = state.getIn(['add_event_editor']).toJS();
      tmp.preview = action.preview;
      return state.set('add_event_editor', fromJS(tmp))
    }

    //---------Edit actions----------------
    case types.EDIT_CHANGE_TITLE: {
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.title =action.value;
      return state.set('selected_event', fromJS(tmp));
    }
    case types.EDIT_CHANGE_START_AT: {
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.start_at = action.value;
      return state.set('selected_event', fromJS(tmp));
    }
    case types.EDIT_CHANGE_END_AT: {
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.end_at = action.value;
      return state.set('selected_event', fromJS(tmp));
    }
    case types.EDIT_CHANGE_COVER_URL: {
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.cover_url = action.value;
      return state.set('selected_event', fromJS(tmp));
    }
    case types.EDIT_CHANGE_LOCATION: {
      return state.setIn(['selected_event', 'location'], fromJS(action.value));
    }
    case types.EDIT_SHOWMAP: {
      console.log('fdsfcxzv')
      let tmp = state.getIn(['selected_event']).toJS();
      tmp.showmap = !tmp.showmap;
      return state.set('selected_event', fromJS(tmp));
    }
    //---------editFormEditor actions-------
    case 'editFormScale': {
      let tmp = state.getIn(['edit_event_editor']).toJS();
      tmp.scale = action.scale;
      return state.set('edit_event_editor', fromJS(tmp))
    }
    case 'edit_form image editor position change': {
      let tmp = state.getIn(['edit_event_editor']).toJS();
      tmp.position = action.position;
      return state.set('edit_event_editor', fromJS(tmp))
    }
    case 'edit_form image editor position x change': {
      let tmp = state.getIn(['edit_event_editor']).toJS();
      tmp.position.x = action.x;
      return state.set('edit_event_editor', fromJS(tmp))
    }
    case 'edit_form image editor position y change': {
      let tmp = state.getIn(['edit_event_editor']).toJS();
      tmp.position.y = action.y;
      return state.set('edit_event_editor', fromJS(tmp))
    }
    case 'edit_form image editor set Preview': {
      let tmp = state.getIn(['edit_event_editor']).toJS();
      tmp.preview = action.preview;
      return state.set('edit_event_editor', fromJS(tmp))
    }
    
    default:
      return state
   }
}