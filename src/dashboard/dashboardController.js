var express = require('express')
var router = express.Router()
var _ = require('lodash')

var Dashboard = require('./dashboard')
var RideBuddies = require('../user/RideBuddies')

router.post('/top-users', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    searchTopFriends(req, res)
})

function searchTopFriends(req, res){

    let fbID = []
    req.body.friends.data.map((data, i) =>(
        fbID.push(data.id )
    ))
    
    Dashboard.paginate({
        }, {
            page: 1, 
            limit: 20,
            sort: { total_km : -1 } 
        },function (err, user) {
            if(err) return res.status(200).send({ code: 1, err})

        Dashboard.paginate({
                'fb_id': {
                    $in: fbID
                }
            }, {
                page: 1, 
                limit: 20,
                sort: { total_km : -1 }  
            },function (err, datas) {
                if(err) return res.status(200).send({ code: 1, err})
                return res.status(200).send({
                    code: 0,
                    data : datas.docs,
                    users : user.docs,
                })    
        })
    })
}

router.get('/', isAuthenticated, function (req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    
    Dashboard.findOne({
        'user_id': req.user._id
    }, function (err, dashboard) {
        if(err) return res.status(200).send({ code: 1, err})
        if (dashboard) {  
            RideBuddies.findOne({
                 'user_id': req.user._id
            },function(err, rideBuddies) {
                //console.log(rideBuddies)
                return res.status(200).send({
                    code: 0,
                    dashboard: dashboard.travel,
                    car_count: req.user.cars.length,
                    buddy_count: rideBuddies ? rideBuddies.buddies.length : 0
                }) 
             })
        }
        else create(req, res)   
    })
})

function create( req, res){
    var newUser = {
        user_id: req.user._id,
        fb_id: req.user.facebook_connection.id,
        name: req.user.last_name,
        first_name: req.user.first_name,
        avatar_url: req.user.avatar_url,
        travel: {
            ration: 0,
            costumer_label: "Энгийн",
            asPassenger: {
                travel_count: 0,
                total_distance: 0,
                total_cost: 0
            },
            asDriver: {
                rating: 0,
                rating_count: 0,
                travel_count: 0,
                total_distance: 0,
                income: 0
            }
        },
    }

    Dashboard.create(newUser, function (err, dashboard) {
        if (err) { console.log(err) }

        res.status(200).send({
            code: 0,
            dashboard: dashboard.travel,
            car_count: 0,
            buddy_count: 0,
        }) 
    })
}

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
