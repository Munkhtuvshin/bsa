import axios from 'axios';
import moment from 'moment';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { History} from 'history'
import * as types from './consts.js'
//---------------------EVENT actions-------------------

export function changeField(field, value) {
  return {
    type: types.FIELD_CHANGED,
    field,
    value
  }
}

export function checkEqual(event, router)  {
  let formdata = new FormData();
  formdata.append('cover_url', event.cover_url);
  formdata.append('title', event.title);
  formdata.append('start_at', event.start_at);
  formdata.append('finish_at', event.finish_at);
  formdata.append('latitude', event.latitude);
  formdata.append('longitude', event.longitude);
  formdata.append('event_start_at', event.event_start_at);
  formdata.append('event_finish_at', event.event_finish_at);
  console.log('ehlew')
  return dispatch => {
    axios({
    method: 'post',
    url: 'http://localhost:3000/event/checkEqual',
    data: formdata,
    config: { headers: {'Content-Type': 'multipart/form-data' }}
    })
    .then(function (res) {
        if(res.data.code==0){
          router.push('/admin/event')
          toast('Амжилттай нэмэгдэлээ')
        }else{
          dispatch( {
            type: types.CHECK_EQUAL,
            res,
          })
          document.getElementById('popup').click()
        }
    })
  }
}

export function editEvent(event, history) {
  let formdata = new FormData();
  formdata.append('cover_url', event.cover_url);
  formdata.append('title', event.title);
  formdata.append('start_at', event.start_at);
  formdata.append('finish_at', event.finish_at);
  formdata.append('latitude', event.latitude);
  formdata.append('longitude', event.longitude);
  formdata.append('event_start_at', event.event_start_at);
  formdata.append('event_finish_at', event.event_finish_at);
  console.log('edit event called: ')
  console.log(event)
  return dispatch => {
    axios({
    method: 'put',
    url: 'http://localhost:3000/event/'+event._id,
    data: formdata,
    config: { headers: {'Content-Type': 'multipart/form-data' }}
    })
    .then(function (res) {
        if(res.data.code==0){
          history.push('/admin/event')
          toast('Амжилттай засагдалаа')
          dispatch( {
            type: types.EDIT_EVENT,
            res,
          })
        }
        else{
          dispatch( {
            type: types.EDIT_EVENT,
            res,
          })
          document.getElementById('popup').click()
          toast('Амжилтгүй боллоо')
        }
    })
  } 
}

export function deleteEvent(id) {
  return dispatch => {
    axios.delete('http://localhost:3000/event/'+id)
    .then( (response) =>{
      dispatch({
        type: types.DELETE_EVENT,
        id,
      })
    })
  }
}

export function setEvent(event) {
  // console.log('set event action: ')
  return {
    type: types.SET_EVENT,
    event
  }
}

export function setAllEvent() {
  console.log('setAlllddd')
  return dispatch => {
    axios.get('http://localhost:3000/event')
    .then( (events) =>{           
      dispatch({
        type: types.SET_ALL_EVENT,
        events,
      })
    })
  }
}
//---------addEventForm actions--------
export function onLocationChanged(value) {
  return {
      type: types.CHANGE_LOCATION,
      value
  }
}

export function showMap() {
  return {
    type: types.SHOWMAP
  }
}

export function onCloseMap() {
  return {
    type: types.CLOSE_MAP
  }
}

export function showPreview() {
  return {
    type: types.SHOW_PREVIEW
  }
}

export function getAddressName(lat, lng) {
  return dispatch => {
    axios.get('https://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lng )
    .then( ( response ) =>{           
      dispatch({
        type: types.GET_ADDRESS,
        response,
      })
    })
  }
}

//---------addFormEditor actions------
export function handleScale( e ) {
  let scale = parseFloat(e.target.value)
  return {
    type: 'addFormScale',
    scale
  }
}
export function handlePositionChange( position ) {
  return {
    type: 'position change',
    position
  }
}
export function handleXPosition( e ) {
  let x = parseFloat(e.target.value)
  return {
    type: 'position x change',
    x
  }
}
export function handleYPosition( e ) {
  let y = parseFloat(e.target.value)
  return {
    type: 'position y change',
    y
  }
}
export function setPreview( preview ) {
  console.log('preview:')
  console.log(preview)
  return {
    type: 'set Preview',
    preview
  }
}
//------------EditForm actions------------
export function editchangeField(field, value) {
  return {
    type: types.EDIT_FIELD_CHANGED,
    field,
    value
  }
}
export function editOnCloseMap() {
  return {
    type: types.EDIT_CLOSE_MAP
  }
}
export function editOnChanged(type, value) {
  switch (type) {
    case 1: {
      return {
        type: types.EDIT_CHANGE_TITLE,
        value
      }
    }
  }     
}
export function editOnStartAtChanged(value) {
  return {
    type: types.EDIT_CHANGE_START_AT,
    value
  }
}

export function editOnEndAtChanged(value) {
  return {
    type: types.EDIT_CHANGE_END_AT,
    value
  }
}

export function editOnLocationChanged(value) {
  return {
    type: types.EDIT_CHANGE_LOCATION,
    value
  }
}

export function editShowMap() {
  return {
    type: types.EDIT_SHOWMAP
  }
}

export function editOnCoverChanged(value) {
  return {
    type: types.EDIT_CHANGE_COVER_URL,
    value
  }
}

//----------EditFormEditor actions---------
export function edit_handleScale( e ) {
  let scale = parseFloat(e.target.value)
  return {
    type: 'editFormScale',
    scale
  }
}
export function edit_handlePositionChange( position ) {
  return {
    type: 'edit_form image editor position change',
    position
  }
}
export function edit_handleXPosition( e ) {
  let x = parseFloat(e.target.value)
  return {
    type: 'edit_form image editor position x change',
    x
  }
}
export function edit_handleYPosition( e ) {
  let y = parseFloat(e.target.value)
  return {
    type: 'edit_form image editor position y change',
    y
  }
}
export function edit_setPreview( preview ) {
  return {
    type: 'edit_form image editor set Preview',
    preview
  }
}