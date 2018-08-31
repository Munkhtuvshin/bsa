import React, { Component, PropTypes } from 'react'
import ReactDOM from 'react-dom';
import { BrowserRouter, Link } from 'react-router-dom';
import { Redirect  } from 'react-router-dom'
import Dropzone from 'react-dropzone'
import AvatarEditor from 'react-avatar-editor'
import { Button, Checkbox, Form, Divider, Segment, Modal, Header, Icon, Image, Popup } from 'semantic-ui-react'
import DatePicker from 'react-datepicker'
import moment from 'moment';
import GMap from './Gmap.js';
import 'react-datepicker/dist/react-datepicker.css'
import './EventForm.css'    
import Preview from './Preview.js'
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import { ScrollTo } from "react-scroll-to";

var targetFile =null;

export default class EventForm extends Component {

  componentWillUpdate(){

  }

  constructor(props) {
    super(props);
    this.state={
      complateAddEvent:false
    }
    console.log('constrr')
    if(this.props.add_event.checkEqual.count==0) {
      this.setState({complateAddEvent:true})
    }
    else{

    }

  }
  notify = () => {
    document.getElementById('addConfirm').click()
  }
  // notify = () => toast("Амжилттай хадгалагдлаа !", {
  //   // hook will be called whent the component unmount
  //   onClose: this.cleanCollection
  // });
  cleanCollection =()=> {
    document.getElementById('addConfirm').click()
  }

  info = () => {this.setState({complateAddEvent:true}) };

  handleSave = data => {
    console.log('handle save:')
    const img = this.editor.getImageScaledToCanvas().toDataURL()
    const rect = this.editor.getCroppingRect()
    this.props.setPreview(
      {
        img,
        rect,
        scale: this.props.add_event_editor.scale,
        width: this.props.add_event_editor.width,
        height: this.props.add_event_editor.height,
        borderRadius: this.props.add_event_editor.borderRadius,
        showPreview:true
      },
    )
    // this.props.showPreview()
  }

  addEvent = () => {
    console.log('log log log')
    let event = 
    { 
      _id:this.props.add_event._id, title:this.props.add_event.title,  cover_url:this.props.add_event.cover_url, start_at:this.props.add_event.start_at, 
      finish_at:this.props.add_event.finish_at, longitude:this.props.add_event.location.longitude, latitude:this.props.add_event.location.latitude,
      event_start_at:this.props.add_event.event_start_at, event_finish_at:this.props.add_event.event_finish_at
    }
    let counter = 0;
    var re = new RegExp('@|#');
    console.log(event)
    if(re.test(event.title) | event.title.length < 4) {
      document.getElementById('title').innerHTML=' Хэт богино эсвэл онцгой тэмдэгт орсон байна.';
      document.getElementById('title').style.color='red';
      counter++;
    }
    else{
      document.getElementById('title').innerHTML='';
    }
    if( moment(event.start_at).format('LLL')==moment(event.finish_at).format('LLL') ) {
      document.getElementById('endAt').innerHTML = ' Эхлэх хугацаа Дуусах хугацаа хоёр давхцсан байна'
      document.getElementById('endAt').style.color = 'red'
      counter++;
    }
    else{
      document.getElementById('endAt').innerHTML = ''
    }
    if( moment(event.event_start_at).format('LLL')==moment(event.event_finish_at).format('LLL') ) {
      document.getElementById('beeco_endAt').innerHTML = ' Эхлэх хугацаа Дуусах хугацаа хоёр давхцсан байна'
      document.getElementById('beeco_endAt').style.color = 'red'
      counter++;
    }
    else {
      document.getElementById('beeco_endAt').innerHTML = '';
    }
    if( event.cover_url == ''){
      document.getElementById('coverUrl').innerHTML = ' Зураг оруулна уу'
      document.getElementById('coverUrl').style.color = 'red'
      counter++;
    }
    else{
      document.getElementById('coverUrl').innerHTML = ''
    }
    if( event.latitude==47.920659 & event.longitude==106.917636 ) {
      document.getElementById('location').innerHTML = ' Байршил оруулна уу'
      document.getElementById('location').style.color = 'red'
      counter++;
    }
    else{
      document.getElementById('location').innerHTML = ''
    }
    if(counter==0) {
      this.props.checkEqual(event, this.props.history)
    }else{
      scroll(500, 0)
    }    
  }

  handleScale = e => {
    this.props.handleScale(e)
  }

  handlePositionChange = position => {
    this.props.handlePositionChange(position)
  }

  handleXPosition = e => {
    this.props.handleXPosition(e)
  }

  handleYPosition = e => {
    this.props.handleYPosition(e)
  }

  handleWidth = e => {
   
  }

  handleHeight = e => {
    
  }
  
  logCallback(e) {
    console.log('callback', e)
  }

  setEditorRef = editor => {
    if (editor) this.editor = editor
  }

  uploadFile = (event) => {
    ReactDOM.findDOMNode(this.refs.myInput).click();
  }

  changeField = (field, value) =>{
    switch(field) {
      case 'title': {
        let re = new RegExp('@|#');
        if(!re.test(value) & value.length < 4 ){
          document.getElementById('title').innerHTML='хэт богино гарчиг';
          document.getElementById('title').style.color='red';
        }
        else{
          document.getElementById('title').innerHTML='';
        }
        this.props.changeField(field, value)
        return
      }
      case 'start_at': {
        if( moment(this.props.start_at).format('LLL') <= moment(this.props.finish_at).format('LLL') | 
          moment(this.props.start_at).format('LLL') <= moment(this.props.event_start_at) | 
          moment(this.props.start_at).format('LLL') <= moment(this.props.event_finish_at) ) {
          this.props.changeField('finish_at', moment(value))
          this.props.changeField('event_start_at', moment(value))
          this.props.changeField('event_finish_at', moment(value))
        }
        this.props.changeField(field, value)
        return
      }
      case 'event_start_at': {
        if( moment(this.props.event_start_at).format('LLL') <= moment(this.props.event_finish_at).format('LLL') ) {
          this.props.changeField('beeco_end_at', moment(value) )
        }
        this.props.changeField(field, value)
        return
      }
      default: return this.props.changeField(field, value)
    }
    // this.props.changeField(field, value)
  }
  onClose = () =>{
    const img = this.editor.getImageScaledToCanvas().toDataURL()
    const rect = this.editor.getCroppingRect()
    this.props.setPreview(
      {
        img,
        rect,
        scale: this.props.add_event_editor.scale,
        width: this.props.add_event_editor.width,
        height: this.props.add_event_editor.height,
        borderRadius: this.props.add_event_editor.borderRadius,
        showPreview:false
      })
  }

  render() {   
    let event = 
    { 
      _id:this.props.add_event._id, title:this.props.add_event.title,  cover_url:this.props.add_event.cover_url, start_at:this.props.add_event.start_at, 
      finish_at:this.props.add_event.finish_at,
      loc:this.props.add_event.location, event_start_at:this.props.add_event.event_start_at, event_finish_at:this.props.add_event.event_finish_at
    }

    // console.log('render preview:')
    // console.log(this.props.add_event_editor.preview)
    return (
      <div className="addForm">
        <ToastContainer/>
    
        <Form method="post" encType="multipart/form-data" className='addform' >
          <Form.Field>
            <label>Гарчиг</label>
            <input 
            ref = "title1"
            id = "tit"
            type='text'
            className='ad'
            value={this.props.add_event.title}
            onChange={ ( event ) => this.changeField( 'title', event.target.value ) }
            placeholder='Гарчиг'
            />
            <span id='title' className='titlespan' ></span>
          </Form.Field>

          <Divider />

          <Form.Group widths='equal'>

            <div className='fullwidth' >  
              <label className='self' >Beeco дээр тавих хугацаа
                <DatePicker
                  readOnly={false}
                  id = "beeco_start_at"
                  showTimeSelect
                  timeFormat="HH:mm"
                  timeIntervals={15}
                  selected={moment(this.props.add_event.start_at)}
                  onChange={ ( date ) => this.changeField( 'start_at', date) }
                  dateFormat="YYYY-MM-DD HH:mm"
                  minDate={ moment() }
                   />
                  
              </label>  
              <br/>
              <label className='marginLef' >Beeco дээрээс устах хугацаа </label>
                <DatePicker 
                  readOnly= {false}
                  id = "beeco_end_at"
                  showTimeSelect
                  timeFormat="HH:mm"
                  timeIntervals={15}
                  selected={moment(this.props.add_event.finish_at)}
                  onChange={ ( date ) => this.changeField( 'finish_at', date ) }
                  dateFormat="YYYY-MM-DD HH:mm"
                  minDate = { moment(this.props.add_event.start_at) }
                     />
              <span id='beeco_endAt' className='endAt' ></span>
            </div>

            <div className='fullwidth'>
              <label className='self' > Ивент захиалга авч эхлэх хугацаа
                <DatePicker
                  readOnly={false}
                  id = "start_at"
                  showTimeSelect
                  timeFormat="HH:mm"
                  timeIntervals={15}
                  selected={moment(this.props.add_event.event_start_at)}
                  onChange={ ( date ) => this.changeField( 'event_start_at', date) }
                  dateFormat="YYYY-MM-DD"
                  minDate={ moment(this.props.add_event.start_at) }
                  maxDate={ moment(this.props.add_event.finish_at) }
                  />
              </label>
              <br/>
              <label className='marginLef' >Ивент захиалга авч дуусах хугацаа
                <DatePicker 
                  readOnly= {false}
                  id = "end_at"
                  showTimeSelect
                  timeFormat="HH:mm"
                  timeIntervals={15}
                  selected={moment(this.props.add_event.event_finish_at)}
                  onChange={ ( date ) => this.changeField( 'event_finish_at', date ) }
                  dateFormat="YYYY-MM-DD"
                  minDate = { moment(this.props.add_event.start_at) }
                  maxDate = { moment(this.props.add_event.finish_at) }
                  />
              </label><br/>
              <span id='endAt' className='endAt' ></span>
            </div>

          </Form.Group>

          <Divider />

          <Form.Field>
            <Button onClick={ this.props.showMap } >Байршил сонгох</Button> 
            <span className='marleft' >{ this.props.add_event.location.latitude } , 
            { this.props.add_event.location.longitude }</span> 
            <span id='location' className='locationspan' ></span>
            
               <GMap 
                showmap={this.props.add_event.showmap}
                onSave={this.props.showMap}
                onClose={this.props.onCloseMap}
                coordinate={this.props.add_event.location}
                addLocation={this.addLocation}
                onLocationChanged = {this.props.onLocationChanged}
              />
            
          </Form.Field>
          <Divider />

          <Form.Group widths='equal'>
            
              <Form.Field>
              <Segment >
                <input name="newImage" type="file" id='file' ref = "myInput" accept=".gif, .jpg, .png" className='displayNone' 
                  onChange={ ( e ) => this.changeField( 'cover_url', e.target.files[0] ) } style={{display:'none'}} />
                <Button onClick={this.uploadFile} basic color='blue' content='Зураг сонгох' />
                <span id='coverUrl' className='fnt'></span> <br/>
                
                <label className='inputLabel'>Zoom: </label>
                <input
                  name="scale"
                  type="range"
                  onChange={this.handleScale}
                  min={this.props.add_event_editor.allowZoomOut ? '0.1' : '1'}
                  max="2"
                  step="0.01"
                  defaultValue="1"
                />

                <label className='inputLabel' >X Position: </label><br/>
                <input
                  name="scale"
                  type="range"
                  onChange={this.props.add_event_editor.handleXPosition}
                  min="0"
                  max="1"
                  step="0.01"
                  value={this.props.add_event_editor.position.x}
                />

                <label className='inputLabel'> Y Position: </label>

                <input
                  name="scale"
                  type="range"
                  onChange={this.props.handleYPosition}
                  min="0"
                  max="1"
                  step="0.01"
                  value={this.props.add_event_editor.position.y}
                />

                <Button primary onClick={this.handleSave} content="Preview" />
                
                  <Modal open={this.props.add_event_editor.preview.showPreview} onClose={this.onClose}>
                    <Header>simulatory</Header>
                    <Modal.Content  image >
                      <div className='overflowX'>
                      <label className='previewImg'>iphone 5 утасны дэлгэц<br/>
                        <img
                          src={this.props.add_event_editor.preview.img}
                          width={240}
                          height={426}
                          style={{
                            borderRadius: `${(Math.min(
                              this.props.add_event_editor.preview.height,
                              this.props.add_event_editor.preview.width
                            ) +
                              10) *
                              (this.props.add_event_editor.preview.borderRadius / 2 / 100)}px`,
                          }}
                        /></label>
                        <label className='previewImg'>Samsung S6,S7 утасны дэлгэц<br/>
                        <img
                          width={270}
                          height={448}
                          src={this.props.add_event_editor.preview.img}
                          style={{
                            borderRadius: `${(Math.min(
                              this.props.add_event_editor.preview.height,
                              this.props.add_event_editor.preview.width
                            ) +
                              10) *
                              (this.props.add_event_editor.preview.borderRadius / 2 / 100)}px`,
                          }}
                        /></label>
                        <label className='previewImg'>iphone 7 утасны дэлгэц<br/>
                        <img
                          src={this.props.add_event_editor.preview.img}
                          width={281.25}
                          height={500.25}
                          style={{
                            borderRadius: `${(Math.min(
                              this.props.add_event_editor.preview.height,
                              this.props.add_event_editor.preview.width
                            ) +
                              10) *
                              (this.props.add_event_editor.preview.borderRadius / 2 / 100)}px`,
                          }}
                        /></label>
                        <label className='previewImg'>Samsung S8 утасны дэлгэц<br/>
                        <img
                          width={270}
                          height={555}
                          src={this.props.add_event_editor.preview.img}
                          style={{
                            borderRadius: `${(Math.min(
                              this.props.add_event_editor.preview.height,
                              this.props.add_event_editor.preview.width
                            ) +
                              10) *
                              (this.props.add_event_editor.preview.borderRadius / 2 / 100)}px`,
                          }}
                        /></label>

                        <label className='previewImg'>iphone X утасны дэлгэц<br/>
                        <img
                          src={this.props.add_event_editor.preview.img}
                          width={281.25}
                          height={609}
                          style={{
                            borderRadius: `${(Math.min(
                              this.props.add_event_editor.preview.height,
                              this.props.add_event_editor.preview.width
                            ) +
                              10) *
                              (this.props.add_event_editor.preview.borderRadius / 2 / 100)}px`,
                          }}
                        /></label>
                      </div>
                    </Modal.Content>
                </Modal>   

              </Segment>
            </Form.Field>

            <Form.Field>
              <Dropzone
                onDrop={this.handleDrop}
                disableClick
                multiple={false}
                style={{ width: this.props.width, height: this.props.height, marginBottom:'35px' }} >
                <div>
                  <AvatarEditor
                    ref={this.setEditorRef}
                    scale={parseFloat(this.props.add_event_editor.scale)}
                    width={this.props.add_event_editor.width}
                    height={this.props.add_event_editor.height}
                    position={this.props.add_event_editor.position}
                    onPositionChange={this.handlePositionChange}
                    borderRadius={this.props.add_event_editor.width / (100 / this.props.add_event_editor.borderRadius)}
                    onLoadFailure={this.logCallback.bind(this, 'onLoadFailed')}
                    onLoadSuccess={this.logCallback.bind(this, 'onLoadSuccess')}
                    onImageReady={this.logCallback.bind(this, 'onImageReady')}
                    image={this.props.add_event.cover_url}
                    className="editor-canvas"
                  />
                </div>
              </Dropzone>
            </Form.Field>
          </Form.Group>
            <Form.Field >
              <Popup
                trigger={<div><Button icon id='popup' style={{display:'none'}}>Click me</Button>
              </div>}
                content={this.props.add_event.checkEqual.count+ ' дугаартай ивенттэй давхацсан байна.'}
                on='click'
                hideOnScroll
              />
            <Button type='submit' primary className='center' 
            onClick={this.addEvent} content={this.props.add_event._id ? 'Засах' : 'Нэмэх'} />
              <span style={{fontSize:'12px'}}>Таны оруулсан хугацаанаас хойш 24 цагийн дараа имайл илгээгдэх болно</span>
            <Link to='/admin/event' id='addConfirm' ></Link>
          </Form.Field>

        </Form>
      </div>
    )
  }
}

