'use strict';

import React, { Component } from 'react'
import { render } from 'react-dom'
import Chart from 'chart.js'
import moment from 'moment'
import { Button, Container, Header, Icon } from 'semantic-ui-react'
import Navbar from '../../components/Navbar'

class IntercityDashboard extends Component {

	constructor(props) {
	  super(props);
	
	  this.state = {
	  	tableCount: 0,
	  };
	}

	componentWillMount() {
		this.props.getPopularRides()
	}

	componentDidUpdate(prevProps, prevState) {
	  	let {
			popular
		} = this.props

		let counts = []
		let labels = []

		if(popular.fetching) return

		popular.data.forEach((item, i) => {
			counts.push(item.count)
			labels.push(item._id)
		})

		var data = {
		    datasets: [{
		        data: counts,
			    backgroundColor: ['#ff6384','#36a2eb','#cc65fe', 'yellow', 'gray']
		    }],
		    labels
		}

        var ctx = document.getElementById("popularRidesChart").getContext("2d")

        var myPieChart = new Chart(ctx,{
		    type: 'pie',
		    data: data,
		})

        var myDoughnutChart = new Chart(ctx, {
		    type: 'doughnut',
		    data: data,
		})
	}

    render() {  

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

			<div style={{
				padding: 40,
				flex: 1,
			}}>
				<Header 
			    	as='h1'
			    >Хэрэглэгчдийн чиглэлийн шилдэг үзүүлэлт
			    </Header>	

				<div class="ui large buttons" style={{marginBottom: 20}}>
					  <button class="ui button" role="button" onClick={() => this.props.getPopularRides({ filter: 1})}>Хаанаас</button>
					  <button class="ui button" role="button" onClick={() => this.props.getPopularRides({ filter: 2})}>Хаашаа</button>
				</div>

				<canvas id="popularRidesChart">
				</canvas>
			</div>
			    
		  </Container>
      )
    }
}

export default IntercityDashboard;