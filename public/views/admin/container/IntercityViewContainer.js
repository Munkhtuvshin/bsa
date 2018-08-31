'use strict';

import React, { Component } from 'react';
import { Button, Container, Header } from 'semantic-ui-react'
import Chart from 'chart.js'

class IntercityViewContainer extends Component {

	componentDidMount() {
		var data = {
		    datasets: [{
		        data: [10, 20, 30, 25, 10],
			    backgroundColor: ['#ff6384','#36a2eb','#cc65fe', 'yellow', 'gray']
		    }],

		    // These labels appear in the legend and in the tooltips when hovering different arcs
		    labels: [
		        'Улаанбаатар',
		        'Дархан',
		        'Эрдэнэт',
		        'Баянхонгор',
		        'Бусад'
		    ]
		    
		}

        var ctx = document.getElementById("userImprovement").getContext("2d")

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
		      	<a href="#" class="item">Хяналт</a>
		      	<div class="ui simple dropdown item">
		        Dropdown asdasd<i class="dropdown icon"></i>
		        <div class="menu">
		          <a class="item" href="#">Link Item</a>
		          <a class="item" href="#">Link Item</a>
		          <div class="divider"></div>
		          <div class="header">Header Item</div>
		          <div class="item">
		            <i class="dropdown icon"></i>
		            Sub Menuasd
		            <div class="menu">
		              <a class="item" href="#">Link Item</a>
		              <a class="item" href="#">Link Item</a>
		            </div>
		          </div>
		          <a class="item" href="#">Link Item</a>
		        </div>
		      </div>
		    </div>
		</div>

		<Header 
	    	as='h1'
	    	style={{
          		paddingTop: 80,
          		paddingBottom: 40,
          	}}
	    >Хот хооронд</Header>

		<Button.Group buttons={['Сараар', 'Улирлаар', 'Жилээр']} />

		<canvas id="userImprovement">
		</canvas>
		<table class="ui celled table">
		  <thead class="">
		    <tr class="">
		      <th class="">Зар оруулагч</th>
		      <th class="">Хаанаас</th>
		      <th class="">Хаашаа</th>
		      <th class="">Хөдлөх өдөр</th>
		      <th class="">Зар оруулсан өдөр</th>
		      <th class="">Нэмэлт мэдээлэл</th>
		      <th class="">Утасны дугаар</th>
		    </tr>
		  </thead>
		  <tbody class="">
		    <tr class="">
		      <td class="">У. Дамбийням</td>
		      <td class="">Баянхонгор</td>
		      <td class="">Улаанбаатар</td>
		      <td class="positive">2017/12/31 - 07:00</td>
		      <td class="positive">2017/12/23</td>
		      <th class="">Өдөр бүр явна</th>
		      <th class="">88545655</th>
		    </tr>
		    <tr class="">
		      <td class="">Ochir Bold</td>
		      <td class="">Улаанбаатар</td>
		      <td class="">Дархан</td>
		      <td class="positive">2017/12/20 - 16:00</td>
		      <td class="positive">2017/12/20</td>
		      <th class="">3 хүн авч явна</th>
		      <th class="">99223311</th>
		    </tr>
		    <tr class="positive">
		      <td class="">Jamie</td>
		      <td class="">Ховд</td>
		      <td class="">Дархан</td>
		      <td class=""><i aria-hidden="true" class="checkmark icon"></i>2017/12/22 - 18:15</td>
		      <td class="">2017/12/20</td>
		      <th class="">2 хүнтэй</th>
		      <th class="">88556648</th>
		    </tr>
		    <tr class="negative">
		      <td class="">Aug An</td>
		      <td class="">Эрдэнэт</td>
		      <td class="">Дархан</td>
		      <td class=""><i aria-hidden="true" class="close icon"></i>2017/12/22 - 11:30</td>
		      <td class="">2017/12/20</td>
		      <th class=""></th>
		      <th class="">94562525</th>
		    </tr>
		  </tbody>
		</table>

      </Container>
    );
  }
}

export default IntercityViewContainer;