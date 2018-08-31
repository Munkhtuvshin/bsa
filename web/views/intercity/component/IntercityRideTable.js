'use strict';

import React, { Component } from 'react'
import { render } from 'react-dom'
import moment from 'moment'
import { Button, Container, Header, Grid, Select, Dropdown} from 'semantic-ui-react'
import Navbar from '../../components/Navbar'
import Pagination from "react-js-pagination"
import 'react-dates/initialize'
import DatePicker from 'react-datepicker'
import _ from 'lodash'

class IntercityRideTable extends Component {

	constructor(props) {
	  super(props);
		
	  this.state = {
	  	changeData: false,
	  	tableData: {},
	  	active_ride: '',
	  	page: 1,
	  	focused: false,
	  	startDate: null,
	  	endDate: null,
	  	clickFrom: null,
	  	clickTo: null,
	  	selectedValue: 0
	  }

	}

	componentWillMount() {
		this.pagination(1)
	}
	
	componentDidUpdate(prevProps, prevState) {
	  	let {
			rides
		} = this.props

		if(rides.fetching) return

		if(!prevState.changeData)
			this.setState({
				changeData: true,
				tableData: rides.data,
				active_ride: rides.active_ride
			})
	}

	apiAction = (page = 1) => {
		this.setState({
			changeData: false,
			page: page
		})

		this.props.getAllRides({
			page: page,
			startDate: moment(this.state.startDate).format('YYYY-MM-DD'),
	    	endDate: moment(this.state.endDate).format('YYYY-MM-DD'),
	    	from: this.state.clickFrom,
	    	to: this.state.clickTo
		})
	}

	pagination = (page) => {
		this.apiAction(page)
	}
	
	handleStartDateChange = (date) => {
 		this.setState({
	     	startDate : date
	    }, () => this.apiAction())
	}

	handleEndDateChange = (date) => {
	    this.setState({
	      	endDate: date
	    }, () => this.apiAction())
	}	

	onClickStartDateRemove = () => {
		this.setState({
	     	startDate : null
	    }, () => this.apiAction())
	}

	onClickEndDateRemove = () => {
		this.setState({
	      	endDate: null
	    }, () => this.apiAction())
	}

	onClickToValue = (value) => {
		let { citys } = this.props

		let city = _.find(citys, (city) => {
			return city.value === value
		})

		if(value == 0)
		 	return this.setState({
				clickTo: null
			}, () => this.apiAction())

		this.setState({
			clickTo: city.text
		}, () => this.apiAction())
	}

	onClickFromValue = (value) => {
		let { citys } = this.props

		let city = _.find(citys, (city) => {
			return city.value === value
		})

		if(value == 0)
		 	return this.setState({
				clickFrom: null
			}, () => this.apiAction())

		this.setState({
			clickFrom: city.text
		}, () => this.apiAction())
	}

    render() {  
      let {
      	tableData,
      	changeData,
      	page,
      	endDate,
      	active_ride,
      	startDate,
      	clickFrom,
      	clickTo,
      	selectedValue
      } = this.state

      let {
      	citys
      } = this.props

      return (
          <Container>
		    <div class="ui fixed inverted menu">
                <div class="ui container">
                    <a href="#" class="header item">
                        <img class="logo" src="/img/logo.png" style={{ transform: 'scale(0.5)' }} />
                        Beeco
                    </a>
                    <a href="/admin/dashboard" class="item">Статистек</a>
                    <a href="/admin/ride-collision" class="item">Газрын зураг</a>
                    <a href="/admin/intercity-ride" class="item">Хот хооронд жагсаалт</a>
                    <a href="/admin/intercity" class="item">Хот хооронд cтатистик</a>
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

            <Header 
		    	as='h1'
		    	style={{
	          		paddingTop: 80,
	          		paddingBottom: 40,
	          		textAlign: 'center'
	          	}}
		    >Хот хооронд хяналтын хэсэг</Header>

		    <div class="ui three statistics">
		      <div class="statistic orange">
			    <div class="value">
			    	{active_ride}
			    </div>
			    <div class="label">
			      идэвхтэй зар
			    </div>
			  </div>
			  <div class="statistic orange">
			    <div class="value">
			      {tableData.total}
			    </div>
			    <div class="label">
			      нийт илэрц
			    </div>
			  </div>
			  
			</div>

		  <div class="ui form" style={{ marginTop: 60, marginBottom: 20}}>
		    <div class="two fields"> 
			    <div class="field">
			      	<label>Хаанаас</label>
			      	<Dropdown placeholder='Хотууд' search selection options={citys}
			      			  defaultValue={0}
			      			  onChange={(event, data) => this.onClickFromValue(data.value) } />
			    </div>
		        <div class="field" style={{ marginRight: 10 }}>
			      	<label>Хаашаа</label>
			      	<Dropdown placeholder='Хотууд' search selection options={citys}
			      			  defaultValue={0}
			      			  onChange={(event, data) => this.onClickToValue(data.value) } />
			    </div>

		      <div class="field">
		        <label>Эхлэх өдөр</label>
		        <div class="row">
			        <DatePicker
		        		title={"Шүүж харах"}
		        		placeholderText={"Өдрөө сонгоно уу"}
				        selected={startDate}
				        onChange={this.handleStartDateChange}
					/>
					{
						startDate != null && (
							<button 
								class="ui icon button" 
								role="button"
								onClick={() => this.onClickStartDateRemove()}>
								<i aria-hidden="true" class="remove icon"></i>
							</button>
						) 
					}
				</div>
		      </div>
		      <div class="field">
		        <label>Дуусах өдөр</label>
		        <div class="row"> 
			        <DatePicker
		        		title={"Шүүж харах"}
		        		placeholderText={"Өдрөө сонгоно уу"}
				        selected={endDate}
				        onChange={this.handleEndDateChange}
					/>
					{
						endDate != null && (
							<button 
								class="ui icon button" 
								role="button"
								onClick={() => this.onClickEndDateRemove()}>
								<i aria-hidden="true" class="remove icon"></i>
							</button>
						) 
					}
				</div>
		      </div>
		    </div>
		  </div>

			<div style={{ padding: 0,flex: 1, marginTop: 20 }}/>
			{
				(changeData) && (
					<div>

						<table 
							class="ui celled table"
							style={{borderColor: 'gray'}}
						>
							<thead class="" >
							  	<tr class="" >
									<th class="">№</th>
									<th class="">Зар оруулагч</th>
									<th class="">Хаанаас</th>
									<th class="">Хаашаа</th>
									<th class="">Утас</th>
									<th class="">Хэзээ явах</th>
									<th class="">Зар оруулсан өдөр</th>
									<th class="">Нэмэлт мэдээлэл</th>
							    </tr>
							</thead>
							<tbody class="">
							{
								tableData.docs.map((item, i) =>(
									( moment(item.day).format('YYYY/MM/DD') >= moment(new Date()).format('YYYY/MM/DD') )
									? (
										<tr key={i} class="">
											<td class="positive">{ (page - 1) * 7 + i + 1 }</td>
											<td class="positive">{item.driver.last_name} {item.driver.first_name} </td>
										    <td class="positive">{item.from}</td>
										    <td class="positive">{item.to}</td>
										    <td class="positive">{item.phoneNumber}</td>
										    <td class="positive">{moment(item.day).format('YYYY/MM/DD')} - {item.time}</td>
										    <td class="positive">{moment(item.created_at).format('YYYY/MM/DD - HH:MM') }</td>
										    <td class="positive">{item.text}</td>
										</tr>
									) : (
										<tr key={i} class="">
											<td class="positive">{ (page - 1) * 7 + i + 1}</td>
											<td class="">{item.driver.last_name} {item.driver.first_name} </td>
										    <td class="">{item.from}</td>
										    <td class="">{item.to}</td>
										    <td class="">{item.phoneNumber}</td>
										    <td class="negative">{moment(item.day).format('YYYY/MM/DD')} - {item.time}</td>
										    <td class="">{moment(item.created_at).format('YYYY/MM/DD - HH:MM') }</td>
										    <td class="">{item.text}</td>
										</tr>
									)
								))
							}
							</tbody>

						</table>
			
						<div>
					        <Pagination
					          activePage={page}
					          itemsCountPerPage={1}
					          totalItemsCount={tableData.pages}
					          pageRangeDisplayed={4}
					          onChange={this.pagination}
					        />
					    </div>

				</div>
				)
			}    
		  </Container>
      )
    }
}

export default IntercityRideTable;