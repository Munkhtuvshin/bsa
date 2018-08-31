'use strict';

var _ = require('lodash');
var path = require("path");
var express = require('express');
var mongoose = require('mongoose');
var moment = require('moment');
var router = express.Router();

var User = require('../user/User');
var Ride = require('../ride/Ride');
var RideHistory = require('../ride/RideHistory');
var SearchHistory = require('../search/SearchHistory');

router.post('/login', function(req, res) {
    //console.log(req.body)
    return res.json({
        code: 0,
    })
})

router.get('/get-old-users', function(req, res) {
    User.find({
        created_at: {
            $lt: moment('2018-01-04')
        }
    }, 'phone', function(err, users) {
        let phones = users.map((user) => parseInt(user.phone))

        return res.json({
            code: 0,
            phones
        })
    })
})

router.get('/ride-collisions', function(req, res) {
    //console.log(req.query.startDate)
    //console.log(moment().seconds(0).milliseconds(0).add(15, 'minutes').utc().format())

    var query = {
        startDate: moment(req.query.startDate, "YYYY-MM-DD").add(1, 'minutes'),
        endDate: moment(req.query.endDate, "YYYY-MM-DD").add(1, 'minutes'),
    }

    //console.log(query)

    RideHistory.find({
        created_at: {
            $gte: query.startDate,
            $lte: query.endDate,
        }
    }, 'start_location end_location passengers', function(err, rides) {
        if(err) throw err
        //console.log(rides)
        SearchHistory.find({
            created_at: {
                $gte: query.startDate,
                $lte: query.endDate,
            }
        }, 'from_distination_filled to_distination_filled from_distination to_distination result', function(err, find_rides) {
            //console.log(find_rides)
            return res.status(200).send({
                code: 0,
                rides,
                find_rides,
            })
        })
    })
})

router.get('/use-location', function(req, res) {

    let lat = 47.880650
    let ltg = 106.852577

    let DISTANCE = 3 / 6378.1

    User.find({}, function(err, users) {
        RideHistory
        .aggregate([{
            $match: {
                "start_location.coordinate": {
                    $geoWithin: {
                        $centerSphere: [
                            [ltg, lat], 
                            DISTANCE,
                        ] 
                    } 
                }
            }
        }], function(err, searches) {

            let locUsers = 0

            users.forEach((user) => {
                let userOffer = false
                //if(user._id)
                searches.forEach((ride) => {
                    if(ride.driver._id == user._id) 
                        userOffer = true
                    //if(ride.passenger)

                    var passengerIndex = _.findIndex(ride.passengers, (passenger) => {
                        if(passenger._id == user._id)
                            userOffer = true
                    })
                })

                if(userOffer)
                    locUsers ++
                //_.find()
            })

            RideHistory
            .aggregate([{
                $match: {
                    "end_location.coordinate": {
                        $geoWithin: {
                            $centerSphere: [
                                [ltg, lat], 
                                DISTANCE,
                            ] 
                        } 
                    }
                }
            }], function(err, endRides) {
                users.forEach((user) => {
                    let userOffer = false
                    //if(user._id)
                    endRides.forEach((ride) => {
                        if(ride.driver._id == user._id) 
                            userOffer = true
                        //if(ride.passenger)

                        var passengerIndex = _.findIndex(ride.passengers, (passenger) => {
                            if(passenger._id == user._id)
                                userOffer = true
                        })
                    })

                    if(userOffer)
                        locUsers ++
                    //_.find()
                })

                return res.json({
                    code: 0,
                    locUsers
                })
            })
        })
    })
})

router.get('/user-age', function(req, res) {
    User.aggregate([{
        $group: {
            _id: {
                year: { $year: "$birthday"},
            },
            count: {
                $sum: 1,
            }
        }
    }], function(err, result) {

        const currentYear = new Date().getFullYear()

        let users18_25 = 0
        let users25_30 = 0
        let users30_35 = 0
        let users35_40 = 0
        let users40more = 0

        let users = []
        result.forEach((data) => {
            let dist = currentYear - data._id.year
            if(dist > 17 && dist <= 25) users18_25 += data.count
            if(dist > 25 && dist <= 30) users25_30 += data.count
            if(dist > 30 && dist <= 35) users30_35 += data.count
            if(dist > 35 && dist <= 40) users35_40 += data.count
            if(dist > 40) users40more += data.count
        })

        return res.json({
            code: 0,
            users18_25,
            users25_30,
            users30_35,
            users35_40,
            users40more
        })
    })
})

router.get('/user-improvement', function(req, res) {
    //console.log('test')
    User.aggregate([{
        $group: {
            _id: {
                year: { $year: "$created_at" },
            	month: { $month: "$created_at" },
            	day: { $dayOfMonth: "$created_at"},
            },
            count: {
                $sum: 1
            }
        }
    }, {
        $sort: {
            "created_at": -1
        }
    }], function(err, result) {
        //console.log(result)
        return res.status(200).send({
            code: 0,
            result,
        })
    })
})

router.get('/total-count', function (req, res) {
    User.count({}, function (err, userCount) {
        Ride.count({}, function (err, activeRideCount) {
            RideHistory.count({}, function (err, historyCount) {
                return res.status(200).send({
                    code: 0,
                    result: {
                        total_user: userCount,
                        total_active_ride: activeRideCount,
                        total_ride: activeRideCount + historyCount
                    }
                });
            });
        });
    });
});

module.exports = router;