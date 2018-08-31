var express = require('express')
var router = express.Router()
var Ride = require('../ride/Ride')
var SearchHistory = require('./SearchHistory')
var Config = require('../config/Config')
var mongoose = require('mongoose')
var _ = require('lodash')

router.get('/', isAuthenticated, function (req, res) {
	Config.findOne({
		key: "find-ride-radius-range",
	}, (err, config) => {

		let params = req.query
		//Dor hayj neg sul suudaltai bh
		//console.log(params)
		let query = {
			available_seat: {
				$gt: 0
			}
		}

		//minii block hiisen hun suusan eesvel uusgesen unaa haragdahgui bna
		/*let blocked_users = []
		blocked_users.push(req.user._id)
		Object.assign(query, {
			'driver.blocked_users': {
				'$nin': blocked_users
			}
		})*/

		/*Object.assign(query, {
			'passengers.blocked_users': {
				$nin: [req.user._id],
			}
		})*/
		let DISTANCE = config.value / 6378.1

		//Minii zahialsan unaa esvel uusgesen unaa nadaa haragdahguui bh
		let active_rides = []
		req.user.active_rides.map((ride_id) => {
			active_rides.push(new mongoose.Types.ObjectId(ride_id))
		})

		Object.assign(query, {
			'_id': {
				'$nin': active_rides
			}
		})

		let result = ride_query(query, DISTANCE, params)

		Ride
			.aggregate([{
				$match: result.query,
			}, {
				$sort: {
					start_time: 1,
				}, 
			}, {
				$limit: 10,
			}
		], function (err, rides) {
	        if (err) throw err
	        
	        let share_ride_find = false
	    	if(params.share_ride_id)
		    	rides.map((ride_id, i) => {
		    		if(ride_id._id == params.share_ride_id){
		    			var b = rides[0];
						rides[0] = rides[i];
						rides[i] = b;
						share_ride_find = true
		    		}
				})

		    Object.assign(result.newSearchHistory, {
		    	user_id: req.user._id,
		    	result: rides.length,
		    })
		    
		    SearchHistory.create(result.newSearchHistory)

	        if(rides.length != 0)
		        return res.status(200).send({ 
		        	code: 0,
		        	data: rides,
		        	share_ride_find,
		        	empty: false
		        })
		    
		    // unaa oldoogui ued 

		    let DISTANCE_LARGE = 500 / 6378.1
		    let new_result = ride_query(query, DISTANCE_LARGE, params)

		    Ride.aggregate(
		    [{
				$match: new_result.query,
			}, {
				$sort: {
					start_time: 1,
				}, 
			}, {
				$limit: 5,
			}], function (err, lastrides) {
		        if(err) return res.status(200).send({ code: 1, err})
    		
	            return res.status(200).send({ 
		        	code: 0,
		        	data: lastrides,
		        	share_ride_find,
		        	empty: true
		        })  
		    })

	    })
	})
})

function ride_query(query, DISTANCE, params ){

	var newSearchHistory = {
    	from_distination_filled: params.from_distination_filled == 'true',
    	to_distination_filled: params.to_distination_filled == 'true',
    	//result: rides.length
    }

	if(params.from_distination_filled == 'true') {
		var distination = JSON.parse(params.from_distination)
		Object.assign(newSearchHistory, {
			from_distination: {
				place_name: distination.place_name,
				coordinate: [distination.coordinate.longitude, distination.coordinate.latitude],
			}
		})
		Object.assign(query, {
			"start_location.coordinate": {
				$geoWithin: {
		      		$centerSphere: [
		      			[distination.coordinate.longitude, distination.coordinate.latitude], 
		      			DISTANCE,
		      		] 
		      	} 
			}
		})
	} 

	if(params.to_distination_filled == 'true') {
		var distination = JSON.parse(params.to_distination)
		Object.assign(newSearchHistory, {
			to_distination: {
				place_name: distination.place_name,
				coordinate: [distination.coordinate.longitude, distination.coordinate.latitude],
			}
		})
		Object.assign(query, {
			"end_location.coordinate": {
				$geoWithin: { 
		      		$centerSphere: [
		      			[distination.coordinate.longitude, distination.coordinate.latitude], 
		      			DISTANCE,
		      		] 
		      	}
			}
		})
	}

	return {query, newSearchHistory}
}

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router

//var User = require('./User')
