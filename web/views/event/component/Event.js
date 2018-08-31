import React, { Component, PropTypes } from 'react'
import { Redirect, Link  } from 'react-router-dom'
import { Table, Button, Icon, Image, Popup, Grid, Header } from 'semantic-ui-react'
import moment from 'moment';

export default class Event extends React.Component {
   // shouldComponentUpdate(nextProps, nextState) {
   //   if(nextProps.completeddasthis.props.completed) return true
   //   return false;
   // }
  constructor(props) {
    super(props);
    this.state = {
      no:this.props.id
    }
  }

  render() {
    let {
      rowNumber
    } = this.props
    var clr=''
    if(moment().format('LL') <= moment(this.props.event_finish_at).format('LL') & moment().format('LL') >= moment(this.props.event_start_at).format('LL') ) {
      clr = 'warning'
    }
    else if( moment().format('LL') < moment(this.props.event_start_at).format('LL') ) {
      clr = 'positive'
    }
    else if( moment().format('LL') > moment(this.props.event_finish_at).format('LL') ) {
      clr = 'negative'
    }
    return (
      <Table.Row className={clr} >
        <Table.Cell>{rowNumber}</Table.Cell>
        <Table.Cell><Image src={this.props.cover_url} width='30' height='30'/></Table.Cell>
        <Table.Cell>{this.props.title}</Table.Cell>
        <Table.Cell>{ moment(moment.utc(this.props.start_at)).format('YYYY-MM-DD HH:mm') }</Table.Cell>
        <Table.Cell>{moment.utc(this.props.finish_at).format('YYYY-MM-DD HH:mm')}</Table.Cell>
        <Table.Cell>{moment.utc(this.props.event_start_at).format('YYYY-MM-DD HH:mm')}</Table.Cell>
        <Table.Cell>{moment.utc(this.props.event_finish_at).format('YYYY-MM-DD HH:mm')}</Table.Cell>
        <Table.Cell>{this.props.location.latitude} , {this.props.location.longitude}</Table.Cell>
        
        <Table.Cell>
          <center>
            <Popup wide trigger={<a content='' id={'popup'+rowNumber} />}  on='click'>
            <Grid centered divided columns={1}>
            <Grid.Column textAlign='center'>
              <p>
                <b>Энэ ивент болж </b><br/>байгаа тул хэрэглэгчид <br/>өөрчлөлтийг мэдэлгүй <br/>өнгөрөх магадлалтай.
              </p>
              <Button onClick={() => this.props.allowEvent(this.props) } >Зөвшөөрөх</Button>
            </Grid.Column>
          </Grid>
          </Popup>
            <div className='onhovr' id={'id'+rowNumber}>
              <Icon onClick = { () => this.props.setEvent(this.props, 'popup'+rowNumber)} className='borderRadius' bordered  name='edit' color="teal"  />
            </div>
          </center>
        </Table.Cell>

        <Table.Cell>
          <center>
            <div className='onhovr'>
              <Icon onClick = {() => this.props.deleteEvent(this.props._id)} className='borderRadius' bordered  name='delete' color="orange"  />
            </div>
          </center>
        </Table.Cell>      
      </Table.Row>
    )
  }
}