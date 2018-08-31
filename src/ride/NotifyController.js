var _ = require('lodash')
var express = require('express')
var router = express.Router()
var moment = require('moment')
var jwt = require('jwt-simple')
var User = require('../user/User')
var Notify = require('./Notify')

function matchNotify(ride) {
    console.log(ride)
}

router.post('/', isAuthenticated, function(req, res) {
    let {
        fromMe,
        toMe,
        range_minute,
        start_time,
        date
    } = req.body

    let tempDate = moment(date)
    let time = moment(start_time)
    time.year(tempDate.year())
    time.month(tempDate.month())
    time.date(tempDate.date())
    time.millisecond(0)
    //console.log(moment(start_time).format('HH:ss'))
    //time = moment(date).format('YYYY-MM-DD') + ' ' + moment(start_time).format('HH:ss')

    let begin_time = moment(time).seconds(0).milliseconds(0).subtract(range_minute, 'minutes')
    let end_time = moment(time).seconds(0).milliseconds(0).add(range_minute, 'minutes')
    
    // console.log(time)
    //console.log(begin_time)
    //console.log(end_time)

    const params = {
        user: req.user._id,
        start_location: {
            place_name: fromMe.place_name,
            coordinate: [fromMe.coordinate.longitude, fromMe.coordinate.latitude]
        },
        end_location: {
            place_name: toMe.place_name,
            coordinate: [toMe.coordinate.longitude, toMe.coordinate.latitude]
        },
        start_time: begin_time,
        end_time,
    }

    Notify
    .remove({
        $and: [{
            user: req.user._id,    
        }, {
            $or: [{
                $and: [{
                    start_time: {
                        $gte: begin_time,
                    },    
                }, {
                    start_time: {
                        $lte: end_time,
                    }    
                }]
            }, {
                $and: [{
                    end_time: {
                        $gte: begin_time,
                    },    
                }, {
                    end_time: {
                        $lte: end_time,
                    }   
                }]
            }]
        }]
    }, function(err, notifies) {
        if(err) throw err
        // console.log(notifies)
        // return res.json({
        //     code: 0,
        // })
        Notify
        .create(params, function(err, notify) {
            return res.status(200).send({
                code: 0,
                notify,
            })    
        })
    })
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router