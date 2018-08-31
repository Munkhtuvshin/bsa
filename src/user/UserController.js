var _ = require('lodash')
var express = require('express')
var mongoose = require('mongoose')
var router = express.Router()
var User = require('./User')
var Buddy = require('./RideBuddies')
var Ride = require('../ride/Ride')
var RepeatedRide = require('../ride/RepeatedRide')
var RideHistory = require('../ride/RideHistory')
var Room = require('../room/Room')
var Chat = require('../room/Chat')
var Coupon = require('../coupon/Coupon')
var Notification = require('../notification/Notification')
var Conversation = require('../room/Conversation')
var Dashboard = require('../dashboard/dashboard')
var jwt = require('jwt-simple')
var admin = require("firebase-admin")
var serviceAccount = require("../../beeco-156f5-firebase-adminsdk-rlduo-7b0487c3b6.json")

// admin.initializeApp({
//   credential: admin.credential.cert(serviceAccount),
//   databaseURL: process.env.FB_HOST
// })
/*router.post('/group/:group/conversations', isAuthenticated, function(req, res) {
if(req.body.messages == 0 || !req.body.ride_id) {
        return res.status(200).send({
            code: 2,
            message: 'Empty request',
        })
    }

    ////console.log("Buren baina shdee eaejsdfjkh aks ")

    _.forEach(req.body.messages, function(message) {
        Conversation.create({
            room_id: req.body.ride_id,
            createdAt: message.createdAt,
            text: message.text,
            user: message.user,
        }, function(err, conversation) {

        })
    })


    return res.status(200).send({
        code: 0,
    })
})*/

router.get('/', function(req, res) {
    User.find({},'first_name last_name phone', function(err, users) {
        return res.status(200).send({
            code: 0,
            users
        })
    })
})

//Unread notification count
router.get('/unread-content-count', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    
    Notification.count({
        user_id: req.user._id,
        created_at: {
            $gte: req.user.last_read_notification
        }
    }, function(err, notifications_count) {
        req.user.last_read_notification = new Date()
        Room.count({
            updated_at: {
                $gte: req.user.last_read_message,
            },
            'users._id': req.user._id,
        }, function(err, rooms_count) {
            Chat.count({
                updated_at: {
                    $gte: req.user.last_read_message,
                },
                'users._id': req.user._id,
            }, function(err, chat_count) {
                req.user.last_read_message = new Date()
                //console.log(req.user.last_read_message)
                req.user.save(function(err) {
                    if(err) throw err
                    return res.status(200).send({
                        code: 0,
                        notifications_count,
                        message_count: rooms_count + chat_count
                    }) 
                })
            })
        })
    })
})

router.post('/create-chat', isAuthenticated, function(req, res) {
    User.findOne({
        _id: req.body.user_id,
    }, function(err, user) {
        Chat.create({
            users: [{
                _id: req.user._id,
                first_name: req.user.first_name,
                last_name: req.user.last_name,
                avatar_url: req.user.avatar_url,
            }, {
                _id: user._id,
                first_name: user.first_name,
                last_name: user.last_name,
                avatar_url: user.avatar_url,
            }]
        }, function(err, chat) {
            req.user.private_connections.push(chat._id)
            user.private_connections.push(chat._id)
            
            req.user.save(function(err) {
                user.save(function(err) {
                    return res.status(200).send({
                        code: 0,
                        chat
                    })
                })
            })
        }) 
    })
})

router.get('/check-chat-exists', isAuthenticated, function(req, res) {
    Chat.findOne({
        'users._id': {
            $all: [req.query.user_id, req.user._id]
        }
    }, function(err, chat) {
        return res.status(200).send({
            code: 0,
            exists: chat ? true : false,
            chat
        })
    })
})

router.get('/chat/:chat/conversations', isAuthenticated, function (req, res) {
    let query = {
        room_id: req.params.chat,
    }

    if(req.query.deleted_at != null) {
        query = Object.assign(query, {
            createdAt: {
                $gt: req.query.deleted_at,
            }
        })
    }

    Conversation.paginate(query, {
        page: req.query.page,
        limit: 10,
        sort: {
            createdAt: -1,
        }
    }, function (err, result) {
        if(err) {
            return res.status(500).send({
                code: 500,
                err
            })
        }

        return res.status(200).send({
            code: 0,
            result
        })
    })
})

router.get('/group/:group/conversations', isAuthenticated, function (req, res) {
    let query = {
        room_id: req.params.group,
    }

    if(req.query.deleted_at != null) {
        query = Object.assign(query, {
            createdAt: {
                $gt: req.query.deleted_at,
            }
        })
    }

    Conversation.paginate(query, {
        page: req.query.page,
        limit: 10,
        sort: {
            createdAt: -1,
        }
    }, function (err, result) {
        if(err) {
            return res.status(500).send({
                code: 500,
                err
            })
        }

        return res.status(200).send({
            code: 0,
            result
        })
    })
})

router.get('/group/:ride_id', isAuthenticated, function(req, res) {
    Room.findOne({
        ride_id: req.params.ride_id
    }, function(err, room) {
        if(err) throw err
        ////console.log(room)
        return res.status(200).send({
            code: 0,
            group: room
        })
    })
})

router.delete('/private-group', isAuthenticated, function(req, res) {
    Chat.update({
        _id: req.body.room_id,
        'users._id': req.user._id,
    }, {
        $set: {
            'users.$.deleted': true
        }
    }, function(err, updated) {
        return res.status(200).send({
            code: 0,
        })    
    })
})

router.delete('/chat', isAuthenticated, function(req, res) {
    Chat.update({
        _id: req.query.room_id,
        'users._id': req.user._id,
    }, {
        $set: {
            'users.$.deleted': true,
            'users.$.deleted_at': new Date()
        }
    }, function(err, updated) {
        return res.status(200).send({
            code: 0,
        })    
    })
})

router.delete('/group', isAuthenticated, function(req, res) {
    Room.update({
        _id: req.query.room_id,
        'users._id': req.user._id,
    }, {
        $set: {
            'users.$.deleted': true,
            'users.$.deleted_at': new Date()
        }
    }, function(err, updated) {
        return res.status(200).send({
            code: 0,
        })    
    })
})

async function getLatestMessage(room_id) {
    return await new Promise(function(resolve, reject) {
        Conversation.findOne({
            room_id
        }, {

        }, {
            sort: {
                createdAt: -1
            }
        }, function(err, conversation) {
            resolve(conversation)
        })
    })
}

router.get('/chat', isAuthenticated, function (req, res) {
    Chat.paginate({
        _id: {
            $in: req.user.private_connections
        }, 
        users: {
            $elemMatch: { 
               _id: req.user._id,
               deleted: false
            } 
        }
    }, {
        page: 1, 
        limit: 5,
        sort: {
            updated_at: -1,
        },
        lean: true,
    }, async (err, result) => {
        if(err) {
            return res.status(500).send({
                code: 500,
                err
            })
        }

        for(let i = 0; i < result.docs.length; i ++) {
            let conversation = await Conversation.findOne({
                room_id: result.docs[i]._id
            }, {}, {
                sort: {
                    createdAt: -1
                }
            })

            result.docs[i].buddy = _.find(result.docs[i].users, (user) => {
                return req.user._id != user._id
            })

            result.docs[i].last_message = conversation
        }


        return res.status(200).send({
            code: 0,
            result
        })
    })    
})

router.get('/group', isAuthenticated, function (req, res) {
    let roomIds = req.user.rooms.map((room) => {
        return room._id
    })

    Room.paginate({
        _id: {
            $in: roomIds
        }, 
        users: {
            $elemMatch: { 
               _id: req.user._id,
               deleted: false
            } 
        }
    }, {
        page: 1, 
        limit: 5,
        sort: {
            updated_at: -1,
        },
        lean: true,
    }, async (err, result) => {
        if(err) {
            return res.status(500).send({
                code: 500,
                err
            })
        }

        for(let i = 0; i < result.docs.length; i ++) {
            let conversation = await Conversation.findOne({
                room_id: result.docs[i]._id
            }, {}, {
                sort: {
                    createdAt: -1
                }
            })
            result.docs[i].last_message = conversation
        }


        return res.status(200).send({
            code: 0,
            result
        })
    })    
})

router.post('/feedback', isAuthenticated, function(req, res) {
 
    RideHistory.findOneAndUpdate({
        _id: req.body.ride_id,
        'passengers._id': req.user._id,
    }, {
        $set: {
            "passengers.$.dirty": false,
            "passengers.$.is_give_feedback": true,
            "passengers.$.feedback": {
                is_ride_going: req.body.is_ride_going,
                rating: req.body.rating,
                reason: req.body.reason,
            },
        }
    }, 
    { upsert: true,
      new : true }, 
    function(err, result) {
        if(err) throw err
  
        if(req.body.is_ride_going){

            let me = _.find(result.passengers, (passenger) => {
                return passenger._id == req.user._id
            })
            
            let passengerQuery = { "travel.asPassenger.travel_count": 1,
                "travel.asPassenger.total_distance": result.total_distance,
                "travel.asPassenger.total_cost": result.price_per_person
            }

            Dashboard.findOneAndUpdate(
                { user_id: req.user._id },
                { $inc: passengerQuery },
                { upsert: true, new : true },
                function (err, passengerDashboard) {
                    if(err) throw err

                    let total_km = passengerDashboard.travel.asPassenger.total_distance + passengerDashboard.travel.asDriver.total_distance
                    let passengerLabel = userLabel(total_km)
                    
                    passengerDashboard.travel.costumer_label = passengerLabel.label
                    passengerDashboard.travel.ration = passengerLabel.ration
                    passengerDashboard.save()

                    let query = {}
                    let response = { first_feedback: false}
                    if(!result.driver.is_feedback_recieved) { // Joloochid irsen ehnii feedback
                        query = { "travel.asDriver.travel_count": 1,
                              "travel.asDriver.total_distance": result.total_distance,
                              "travel.asDriver.income": me.seat_order * result.price_per_person
                        }
                        response = {  
                            first_feedback: true,
                            driver_id: result.driver._id,
                            start_location: result.start_location.place_name,
                            end_location: result.end_location.place_name,
                            ride_km: result.total_distance
                        }
                    } else { // joloochid irsem 2doh feedback zuwhun une rank 2 uurchlugdunu
                        query = { "travel.asDriver.income": me.seat_order * result.price_per_person }                       
                    }   
                    
                    Dashboard.findOneAndUpdate(
                        { user_id: result.driver._id },
                        { $inc: query },
                        { upsert: true, new: true },
                        function(err, driverDahboard){
                        if(err) throw err

                        let C = 4.5 
                        let M = 30 
                        let V = driverDahboard.travel.asDriver.rating_count + 1
                        let R = driverDahboard.travel.asDriver.rating
                        R = ((V-1) * R + me.feedback.rating)/V
                        let new_rating = (V/(V+M))*R+(M/(V+M))*C // Rating algoritm
                        let total_km = driverDahboard.travel.asPassenger.total_distance + driverDahboard.travel.asDriver.total_distance
                        let driverLabel = userLabel(total_km)
                        
                        driverDahboard.travel.asDriver.rating_count = V
                        driverDahboard.travel.costumer_label = driverLabel.label
                        driverDahboard.travel.asDriver.rating = Math.round(new_rating * 10) / 10
                        driverDahboard.travel.ration = driverLabel.ration
                        driverDahboard.save()

                        if (!result.driver.is_feedback_recieved) {
                            result.driver.is_feedback_recieved = true
                            result.save()    
                        }

                        return res.status(200).send({
                            code: 0,
                            response
                        })
                    })
            })

        } else return res.status(200).send({
            code: 0,
        })

    })
})

function userLabel(total_km){
    if(total_km <= 100) return { ration : total_km, label: "Энгийн"}
    if(total_km > 100 && total_km <= 1000) return { ration : total_km/10, label: "Хүрэл"}
    if(total_km > 1000 && total_km <= 10000) return { ration : total_km/100, label: "Мөнгөн"}
    if(total_km > 10000 && total_km <= 100000) return { ration : total_km/1000, label: "Алтан"}
    if(total_km > 100000) return { ration : total_km/10000, label: "Даймонд"}
}

router.get('/my-history-rides', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    
    RideHistory.paginate({
        '_id': {
            $in: req.user.history_rides
        }
    }, {
        page: 1,
        limit: 5,
        sort: { 
            start_time: -1,
        },
        lean: true
    }
    , async function (err, result) {
        if(err) return res.status(200).send({ code: 1, err})

        let rides = result.docs

        for(let i = 0; i < rides.length; i ++) {
            rides[i].as_driver = rides[i].driver._id == req.user._id ? true : false

            let userIds = rides[i].passengers.map((passenger) => {
                return passenger._id
            })

            userIds.push(rides[i].driver._id)

            let users = await User.find({
                _id: {
                    $in: userIds,
                }
            }, 'phone')

            rides[i].phones = users
        }

        //console.log(result)
        return res.status(200).send({
            code: 0,
            result
        })    
    })  
})

router.get('/my-rides', isAuthenticated, function (req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    Ride.find({
            '_id': {
                $in: req.user.active_rides
            }
        })
        .sort({
            start_time: 1,           
        })
        .lean()
        .exec(async function(err, rides) {
            if(err) return res.status(200).send({ code: 1, err })

            for(let i = 0; i < rides.length; i ++) {
                rides[i].as_driver = rides[i].driver._id == req.user._id ? true : false
                rides[i].is_repeated_ride = rides[i].repeated_ride ? true : false
                rides[i].days = []
                if(rides[i].repeated_ride) {
                    var repeatedRide = await RepeatedRide.findById(rides[i].repeated_ride)   
                    rides[i].days = repeatedRide.days
                    //console.log(repeatedRide)
                }
                //ride.driver.phone = "88555654"

                let userIds = rides[i].passengers.map((passenger) => {
                    return passenger._id
                })

                userIds.push(rides[i].driver._id)

                let users = await User.find({
                    _id: {
                        $in: userIds,
                    }
                }, 'phone')

                //console.log(users)    
                
                //let user = await User.findOne({ _id: rides[i].driver._id })
                rides[i].phones = users
                
            }
            /*_.forEach(rides, (ride, i) => {
                ride.as_driver = ride.driver._id == req.user._id ? true : false
                //ride.driver.phone = "88555654"
                //console.log(await User.findOne({ _id: ride.driver._id }).phone)
            })    */

            //console.log(rides)
            ///console.log('------------------------')
            
            return res.status(200).send({
                code: 0,
                rides
            })    
        })  
    /*User.findOne({ _id: "598026b0413db36e5edb1594" }, function (err, user) {
    //User.findOne({ _id: req.session.key._id }, function (err, user) {
        if(!user) {
            return res.status(200).send({
                code: 1,
            })
        }
        
    })*/
})

router.get('/', function (req, res) {
    User.findOne({ _id: "598026b0413db36e5edb1594" }, function (err, user) {
        if(err) return res.status(500).send({
            code: 1,
            message: 'User not found'
        })

        return res.status(200).send({
            code: 0,
            user
        })
    })
})

router.get('/public-profile', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    let user_id = req.query.id //"599fe2a603a5d51618529bee" 
    let blocked = {}
    //console.log("id == "+user_id)

    User.findOne(
        {
            '_id': req.user._id,
            'blocked_users': user_id
        },function (err, data) {
            if(err) return res.status(200).send({ code: 1, err})

            if(data){ blocked = true}
            else { blocked = false}
            
            User.findOne({ _id: user_id }, function (err, user) {
                if(err) return res.status(500).send({ code: 1 })

                Dashboard.findOne({ user_id: user_id }, function (err, dashboard) {
                    if(err) return res.status(500).send({ code: 1 })

                    return res.status(200).send({
                        code: 0,
                        user: {
                            about: user,
                            travel: dashboard.travel,
                            blocked : blocked
                        }
                    })
                })
            })
        }
    )
    
})

router.get('/get-my-profile', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    User.findOne({ _id: req.user._id }, function (err, user) {
        if(err) return res.status(500).send({
            code: 1,
            message: 'User not found'
        })
        return res.status(200).send({
            code: 0,
            user
        })
    })

})

router.post('/save-edit-profile-image', isAuthenticated, function (req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    let image = JSON.parse(req.body.data)
    let avatar_url = image.imageUrl

    Dashboard.findOneAndUpdate({user_id: req.user._id}, {
        avatar_url: avatar_url
    },{
        upsert : true,
        new : true
    }, function(err, user) {

        User.findOneAndUpdate({_id: req.user._id}, {
            avatar_url: avatar_url
        },{
            upsert : true,
            new : true
        }, function(err, user) {
            if (err) { return res.send({ code: 1}); }
            //console.log('edit profile image')
            req.session.user = user
            var token = jwt.encode(user.toObject(), "beecosecretkey")
            return res.status(200).send({
                code: 0,
                user,
                token
            })
        });
    })
})

router.post('/save-edit-profile', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    let doc = {
        last_name: req.body.data.lastname,
        first_name: req.body.data.firstname,
        birthday: req.body.data.birthday,
        gender: req.body.data.gender,
        description: req.body.data.description
    } 

    Dashboard.findOneAndUpdate({user_id: req.user._id}, {
        first_name: req.body.data.firstname,
        name: req.body.data.lastname
    }, function(err, changeUser) {
        User.findOneAndUpdate(
            {_id: req.user._id}, 
            doc, 
            { upsert : true,
              new : true 
            },function(err, user) {
            if (err) { res.send(err); }

            req.session.user = user
            var token = jwt.encode(user.toObject(), "beecosecretkey")
            return res.status(200).send({
                code: 0,
                user,
                token
            })
        });
    })
})

router.get('/terms-and-condition', isAuthenticated, function (req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    
    User.findOneAndUpdate(
            { _id: req.user._id }, 
            { terms_and_conditions: true },
            { upsert : true,
              new : true 
            },function(err, user) {
            if (err) { res.send(err); }

            return res.status(200).send({
                code: 0,
            }) 
    })
})

router.get('/ride-buddies', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    Buddy.findOne({ 
            'user_id': req.user._id,
        },function (err, user) {
            if(err) return res.status(200).send({ code: 1, err})
            
        let notBlockedUsers = _.difference(user.buddies, req.user.blocked_users)
    
        Dashboard.paginate({
                'user_id': {
                    $in: (req.query.filter == 1) ? notBlockedUsers : req.user.blocked_users
                }
            },{
                page: req.query.page,
                limit: 20,
            },function (err, users){
                if(err) return res.status(200).send({ code: 1, err})
                return res.status(200).send({
                    code: 0,
                    buddies : users 
                }) 
        })
    }) 
})

// router.get('/ride-buddies', isAuthenticated, function (req, res) {

//     if(!req.isAuthenticated()) {
//         return res.status(200).send({
//             code: 1,
//         })    
//     }

//     Buddy.findOne({ 
//             'user_id': req.user._id,
//         },function (err, user) {
//             if(err) return res.status(200).send({ code: 1, err})
            
//         let notBlockedUsers = _.difference(user.buddies, req.user.blocked_users)
    
//         Dashboard.paginate({
//                 'user_id': {
//                     $in: notBlockedUsers
//                 }
//             },{
//                 page: req.query.page,
//                 limit: 15,
//             },function (err, users){
//                 if(err) return res.status(200).send({ code: 1, err})

//                 Dashboard.paginate({
//                     'user_id': {
//                         $in: req.user.blocked_users
//                     }
//                 },{
//                     page: req.query.page,
//                     limit: 5,
//                 },function (err, blocked){
//                     if(err) return res.status(200).send({ code: 1, err})

//                     return res.status(200).send({
//                         code: 0,
//                         buddies : users,
//                         blockedBuddies: blocked
//                     }) 
//                 })
//             }
//         )
//     }) 
// })

router.get('/ride-buddies-blocked', isAuthenticated, function (req, res) {

    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    let query = {}
    let deleteId = {}

    if(req.query.data == "false") 
          query = { $push: { blocked_users : req.query.id } } 
    else  query = { $pull: { blocked_users : req.query.id } } 

    User.update({ 
        '_id': req.user._id },
        query,
        { upsert: true,
          new: true },
        function(err, result) {
        if(err) return res.status(200).send({ code: 1, err})

        if(req.query.data == "false") 
              deleteId = { $pull: { buddies: req.user._id } } 
        else  deleteId = { $push: { buddies: req.user._id } }

        Buddy.update({
            'user_id': req.query.id 
        },
        deleteId,
        function(err, result) {
            if(err) return res.status(200).send({ code: 1, err})

            //console.log('blocked')
            return res.status(200).send({  
            code: 0 
        })
        })
    })
})

function newUser(req, res){

    var newUser = {
        user_id: req.user._id,
        fb_id: req.user.facebook_connection.id,
        last_name: req.user.last_name,
        first_name: req.user.first_name,
    }

    Buddy.create(newUser, function (err, buddies) {
        if(err) return res.status(500).send({
            code: 1,
            message: 'Not found'
        })

         //console.log('greate')

    })

}

router.post('/fcm-token', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
    //console.log(req.body.token)
    //Check coupons push allready sented throught
    req.user.fcm_token = req.body.token
    req.user.save(function(err) {
        Coupon.isPushNotificationNotSented(req.user, function(coupons) {
            //console.log(coupons)
            console.log('is there any coupons = ' + coupons.length > 0 ? 'yes' : 'no')

            let ids = []

            if(coupons.length > 0) {
                // /coupons[0].coupon_data.push_notification_sented = true
                //coupons[0].save()
                sendRemoteNotification(req.user._id, {
                      title: "beeco - Замын унаа апп",
                      body: 'Beeco-г сонгосонд баярлалаа! Та апп-н УРАМШУУЛАЛ хэсгээс төрөл бүрийн хөнгөлөлтийн эрх аваарай.',
                      //large_icon: coupon.coupon_data.cover_url,
                }, { priority: "high" })

                sendRemoteNotificationToIOS(req.user._id, {
                      title: "beeco - Замын унаа апп",
                      body: 'Beeco-г сонгосонд баярлалаа! Та апп-н УРАМШУУЛАЛ хэсгээс төрөл бүрийн хөнгөлөлтийн эрх аваарай.',
                      //large_icon: coupon.coupon_data.cover_url,
                }, { priority: "high" })

                Coupon.update({
                    'coupon_data.user_id': req.user._id,
                    'coupon_data.push_notification_sented': false,
                }, {
                    $set: {
                        'coupon_data.push_notification_sented': true
                    }
                }, { multi: true }, function(err) {

                })
            }

            return res.status(200).send({
                code: 0,
                token: req.user.fcm_token
            })        
        })
    })
})

function sendRemoteNotificationToIOS(user_id, data, options) {
    User.findOne({
        _id: user_id,
        //phone_verified: true,
    }, 'fcm_token', function(err, user) {
        console.log(user)
        let tokens = []
        tokens.push(user.fcm_token)
        var payload = {
            //"content-available" : true,
            "notification": {
               ...data,
               // "show_in_foreground": true,
               //"click_action": "mn.beeco.ridesharing" // The id of notification category which you defined with FCM.setNotificationCategories
            }
        }
        //console.log(tokens)

        admin.messaging().sendToDevice(tokens, payload, options)
             .then(function(response) {
                console.log(response)
             })
             .catch(function(error) {
                console.log(error)
             })
    })
}

function sendRemoteNotification(user_id, data, options) {
    User.findOne({
        _id: user_id
    }, 'fcm_token', function(err, user) {
        let tokens = []
        tokens.push(user.fcm_token)
        var payload = {
            data: {
                badge: "0",
                custom_notification: JSON.stringify(Object.assign(data, {
                    sound: "default",
                    color: "#e0622e",
                    priority: "high",
                    icon: "ic_launcher",
                    show_in_foreground: true,
                }))
            }
        }

        admin.messaging().sendToDevice(tokens, payload, options)
             .then(function(response) {
                //console.log(response)
             })
             .catch(function(error) {
                //console.log(error)
             })
    })
}

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
