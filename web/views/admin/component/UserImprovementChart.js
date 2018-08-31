'use strict';

import React, { Component } from 'react';
import { render } from 'react-dom'
import { Tab, Button, Container, Header } from 'semantic-ui-react'
import _ from 'lodash'

class UserImprovementChart extends Component {
  	randomScalingFactor() {
		return Math.floor(Math.random() * 200) + 20 
	}

    componentWillMount() {
        this.props.getUserImpovementChart()
    }

    shouldComponentUpdate(nextProps, nextState) {
        if(nextProps.userCharts.fetching != this.props.userCharts.fetching) return true
        return false
    }

    componentDidUpdate(prevProps, prevState) {

        let chartData = this.props.userCharts.data
        let labels = []
        let dataSource = []

        //alert(JSON.stringify(chartData))
        chartData = _.orderBy(chartData, function(data) {
            const {
                year,
                month,
                day
            } = data._id

            console.log(year * 12 * 30 + month * 30 + day)
            return year * 12 * 30 + month * 30 + day
        })

        //_.reverse(chartData)

        chartData.forEach((data) => {
            labels.push(data._id.year + ' он ' + data._id.month + ' сар ' + data._id.day)
            dataSource.push(data.count)
        })

        var config = {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: "Шинээр бүртгүүлсэн хэрэглэгч",
                    backgroundColor: "#E0622E",
                    borderColor: "#E0622E",
                    data: dataSource,
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title:{
                    display: false,
                    text:'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Хугацаа'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Тоо ширхэг'
                        }
                    }]
                }
            }
        }

        var ctx = document.getElementById("userImprovement").getContext("2d")
        var userChart = new Chart(ctx, config)
    }

	render() {
        //alert("Chart")
	    return (
    	    <div style={{
    	      	paddingTop: 40,
    	    }}>
        	    <Button.Group 
    	      		buttons={['Хоногоор', 'Сараар', 'Улирлаар', 'Жилээр']} 
    	      		style={{
    	      			float: 'right',
    	      			paddingTop: 20,
    	      			paddingBottom: 20,
    	      		}}
    	      	/>

    	      	<canvas id="userImprovement">
    			</canvas>
    	    </div>
	    )
	}
}

export default UserImprovementChart;