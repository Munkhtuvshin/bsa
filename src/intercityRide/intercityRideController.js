var express = require('express')
var router = express.Router()
var _ = require('lodash')
import moment from "moment"
var IntercityRide = require('./intercityRide')
import axios from 'axios'
import Config from '../config/Config.js'
//import { couponApi } from '../coupon/CouponApi' 

router.get('/popular', function (req, res){

  //  console.log(req.query)

    let query = '$from' 
    if(req.query.filter == 2)
        query = '$to'

    IntercityRide.aggregate(
         [
            // Grouping pipeline
            { "$group": { 
                "_id": query, 
                "count": { "$sum": 1 }
            }},
            // Sorting pipeline
            { "$sort": { "count": -1 } },
            // Optionally limit results
            { "$limit": 5 }
        ],function (err, result) {
         if (err) return console.log(err)

           // console.log(result)
            return res.status(200).send({
                result
            })
        }
    )
})

router.post('/intercity-all-ride', function (req, res){

    let today = moment(new Date()).format('YYYY/MM/DD')
    let query = {}
    let day = {}

    if(req.body.startDate != "Invalid date")
        Object.assign(day, {
             $gte: req.body.startDate 
       })

    if(req.body.endDate != "Invalid date")
        Object.assign(day, {
            $lte: req.body.endDate 
        })

    if(!isEmpty(day)) 
        Object.assign(query, {
            day
        })
    
    if(req.body.from)
        Object.assign(query, {
            from : req.body.from
        })

    if(req.body.to)
        Object.assign(query, {
            to : req.body.to
        })

    IntercityRide.paginate(query,
    {
        page: req.body.page, 
        limit: 7,
        sort: { day: -1, time: -1 } 
    }, function (err, rides) {
        if(err) return res.status(200).send({ code: 1, err})

        IntercityRide.find({ 
            day: { $gte: today } 
        },  function (err, nowRide) { 
            
            return res.status(200).send({
                code: 0,
                rides,
                active_ride: nowRide.length
            })   
        })    
    })
})

router.get('/my-intercity-rides', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    // couponApi({user: req.user}, function(response){
    // })

    let params = req.query
    IntercityRide.paginate({
        '_id': {
            $in: req.user.intercity_rides
        }
    }, {
        page: params.page, 
        limit: 4,
        sort: { day: -1, time: -1 } 
    }, function (err, rides) {
        if(err) return res.status(200).send({ code: 1, err})
        return res.status(200).send({
            code: 0,
            rides
        })    
    })
})

router.post('/save-ride', isAuthenticated, function (req, res) {

    let newRide = {}
    IntercityRide.create(req.body, function (err, ride) {
        var user = req.user
        user.intercity_rides.push(ride._id)
        user.save(function(err) {
            if(err) return  {  code: 500,  message: err, }
            res.status(200).send({
                code: 0,
                ride: ride._id
            }) 
        }) 
	})
})

router.get('/', function (req, res) {

    let params = req.query
    if(params.to)
    {
        IntercityRide.getFilterRides(params, (err, rides)=>{
            if(err) throw err;         
            res.status(200).send({
              code: 0,
              rides  
            });
            
        }) 
    }
})

router.post('/delete-ride', isAuthenticated, function (req, res) {
    
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    let params = req.body
   
    IntercityRide.postDelete(params, (result)=>{
   
        IntercityRide.paginate({
            '_id': {
                $in: req.user.intercity_rides
            }
        }, {
            page: 1, 
            limit: 4,
            sort: { day: -1, time: -1 } 
        }, function (err, rides) {
            if(err) return res.status(200).send({ code: 1, err})

            return res.status(200).send({
                code: 0,
                rides
            })    
        })
     })
})

function isEmpty(obj) {
    for(var key in obj) {
        if(obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
