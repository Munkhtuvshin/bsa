import React, { Component } from 'react';
import Event from './Event.js'
import PropTypes from 'prop-types';
import { connect } from 'react-redux'
import { Redirect, Link } from 'react-router-dom'
import moment from 'moment';
import { Button, Table, Container } from 'semantic-ui-react'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

export default class EventList extends Component {

  constructor(props) {
    super(props);
    this.state = {
      navigate:false,
    }
    this.props.setAllEvent()
  }

  setEvent = (event, elementId) =>{
    // console.log('set event: ')
    // console.log(event)
    if(moment(event.event_start_at).format('LL') <= moment().format('LL') ){
      document.getElementById(elementId).click();
    }
    else{
      this.props.setEvent(event)
      document.getElementById('setEvent').click()      
    }
  }
  allowEvent = (event) => {
    this.props.setEvent(event)
    document.getElementById('setEvent').click()
  }

   render() {
   	let { 
      events
    } = this.props
    console.log(this.props)
      return (
        <Container>
        <ToastContainer />
          <div class="ui fixed inverted menu">
            <div class="ui container">
              <a href="#" class="header item">
              <img class="logo" src="/img/logo.png" style={{ transform: 'scale(0.5)' }} />
                Beeco
              </a>
              <a href="/admin/dashboard" class="item">Статистек</a>
              <a href="/admin/ride-collision" class="item">Газрын зураг</a>
              <a href="/admin/intercity-ride" class="item">Хот хооронд жагсаалт</a>
              <a href="/admin/intercity" class="item">Хот хооронд статистик</a>
              <a href="/admin/event" class="item">Event</a>
              <div class="ui simple dropdown item">
                Хэрэглэгч <i class="dropdown icon"></i>
                <div class="menu">
                  <div class="divider"></div>
                  <div class="header">admin@gmail.com</div>
                  <div class="item">
                    <i class="dropdown icon"></i>
                    Sub Menu
                    <div class="menu">
                    </div>
                  </div>
                  <a class="item" href="/admin/logout">Системээс гарах</a>
                </div>
              </div>
            </div>
          </div>

        <div className='tableMargin' style={{ marginTop:'150px' }}>
          <Link to="/admin/addEvent" >    <Button primary className='addButton'>Нэмэх</Button> </Link>
          <span> <span style={{color:'green'}}>ногоон</span>-болох ивент, <span style={{color:'orange'}}> улбар шар</span>-болж буй ивент, 
          <span style={{color:'red'}}> улаан</span>-өнгөрсөн ивент</span>
          <Table celled selectable>
            <Table.Header>
              <Table.Row>
                <Table.HeaderCell>No</Table.HeaderCell>
                <Table.HeaderCell>Зураг</Table.HeaderCell>
                <Table.HeaderCell>Гарчиг</Table.HeaderCell>
                <Table.HeaderCell>Beeco-д тавих хугацаа</Table.HeaderCell>
                <Table.HeaderCell>Beeco-д устах хугацаа</Table.HeaderCell>
                <Table.HeaderCell>Ивент эхлэх хугацаа</Table.HeaderCell>
                <Table.HeaderCell>Ивент дуусах хугацаа</Table.HeaderCell>
                <Table.HeaderCell>Байршил</Table.HeaderCell>
                <Table.HeaderCell>Засах</Table.HeaderCell>
                <Table.HeaderCell>Устгах</Table.HeaderCell>
              </Table.Row>
            </Table.Header>

            <Table.Body>
              {
                events.map((event, i) => (
                  <Event
                    key={i}//i is this loop's iteration
                    rowNumber={i + 1}
                    {...event}
                    deleteEvent = {this.props.deleteEvent}
                    setEvent={this.setEvent}
                    allowEvent={this.allowEvent}  />
                  )
                )
              }
            </Table.Body>
          </Table>
        </div>
        <Link to='/admin/editEvent' id='setEvent'></Link>
      </Container>
      );
   }
}



