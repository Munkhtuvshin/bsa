'use strict';

import React, { Component } from 'react'
import { render } from 'react-dom'
import Chart from 'chart.js'
import { Label, Tab, Button, Container, Header, List } from 'semantic-ui-react'

import UserImprovementChart from './UserImprovementChart'

class DashboardView extends Component {
	constructor(props) {
	  super(props);

	  this.state = {
	  	activeIndex: 0,
	  }

	  this.panes = [
		    { 
		  		menuItem: 'Хэрэглэгчийн график', 
		  		render: () => (
			      <Tab.Pane 
			      	attached={false}
			      	style={{
			      		border: '0px solid transparent',
			      		boxShadow: 'none'
			      	}}
			      >
			      </Tab.Pane>
			    )
		  	}, { 	
		    	menuItem: 'Аялалын график', 
		  		render: () => 
		  			<Tab.Pane 
		  				attached={false}
		  				style={{
				      		border: '0px solid transparent',
				      		boxShadow: 'none'
				      	}}
		  			>
		  			</Tab.Pane> 
		  	}, {
		  		menuItem: 'Coming soon',
			    render: () => (
			      <Tab.Pane 
			      	attached={false}
			      	style={{
			      		border: '0px solid transparent',
			      		boxShadow: 'none'
			      	}}
			      >
			      </Tab.Pane>
			    )
		  	}
		]	
	}

	componentWillMount() {
		this.props.getTotalCountBoth()
	}

	handleTabChange = (e, { activeIndex }) => this.setState({ activeIndex })

	_renderTabComponent = (index) => {
		switch(index) {
			case 0:
				return ( 
					<UserImprovementChart 
					   userCharts={this.props.userCharts}
					   getUserImpovementChart={this.props.getUserImpovementChart}
					/>
				)
			default:
				<div>
				</div>
				break
		}
	}

    render() {
      let {
      	  total_count
      } = this.props

      let {
      	  activeIndex
      } = this.state

      let stats = total_count.data

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
                    <a href="/admin/event" class="item">Ивент</a>
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
		    >Хот дотор хяналтын хэсэг</Header>

		    <div class="ui three statistics" style={{ position: 'relative'}}>
			  <div class="statistic orange">
			    <div class="value">
			      {stats.total_user}
			    </div>
			    <div class="label">
			      нийт хэрэглэгч
			    </div>
			  </div>
			  <div class="statistic orange">
			    <div class="value">
			      {stats.total_active_ride}
			    </div>
			    <div class="label">
			      идэвхтэй аялал
			    </div>
			  </div>
			  <div class="statistic orange">
			    <div class="value">
			      {stats.total_ride}
			    </div>
			    <div class="label">
			      нийт аяласан
			    </div>
			  </div>
			</div>

			<div style={{
				padding: 40,
				flex: 1,
			}}>
				<Tab 
					menu={{ secondary: true }} 
					panes={this.panes}
					activeIndex={activeIndex} onTabChange={this.handleTabChange}
				>
				</Tab>

				{ this._renderTabComponent(activeIndex) }
			</div>
		    
		  </Container>
      )
    }
}

export default DashboardView;