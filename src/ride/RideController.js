
var express = require('express')
var router = express.Router()

var Dashboard = require('../dashboard/dashboard')
var Buddy = require('../user/RideBuddies')
var Ride = require('./Ride')
var RepeatedRide = require('./RepeatedRide')
var RideHistory = require('./RideHistory')
var Notify = require('./Notify')
var NotifyController = require('./NotifyController')
var User = require('../user/User')
var Room = require('../room/Room')
import Config from '../config/Config'
var _ = require('lodash')

import moment from "moment"

router.post('/order-add-seat', isAuthenticated, function (req, res) {
    Ride.findOne({
        _id: req.body.ride_id,
        'passengers._id': req.user._id,
    }, function (err, ride) {
        if(err) throw err
        if(!ride) {
            return res.status(200).send({
                code: 100,
                message: 'Ride not found',
            })
        }

        if(!ride.isAvailableForOrder(req.body.seat)) {
            return res.status(200).send({
                code: 101,
                ride,
                message: 'Not available'
            })
        }

        ride.orderAddSeat(req.user._id, req.body.seat, function(err, updatedRide) {
            return res.status(200).send({
                code: 0,
                ride: updatedRide,
            })
        })
    })
})

router.post('/order-cancel-seat', isAuthenticated, function (req, res) {
    Ride.findOne({
        _id: req.body.ride_id,
        'passengers._id': req.user._id,
    }, function (err, ride) {
        if(err) throw err
        if(!ride) {
            return res.status(200).send({
                code: 100,
                message: 'Ride not found',
            })
        }

        ride.orderCancelSeat(req.user._id, req.body.seat, function(err, updatedRide) {
            return res.status(200).send({
                code: 0,
                ride: updatedRide,
            })
        })
    })
})

router.post('/add-seat', isAuthenticated, function (req, res) {
    Ride.findOne({
        _id: req.body.ride_id,
    }, function (err, ride) {
        if(err) throw err
        if(!ride) {
            return res.status(200).send({
                code: 100,
                message: 'Ride not found',
            })
        }

        if(ride.driver._id != req.user._id) {
            return res.status(200).send({
                code: 101,
                message: 'Permission Denied',
            })
        }

        ride.addSeatBy(req.body.seat, function(err, updatedRide) {
            return res.status(200).send({
                code: 0,
                ride: updatedRide,
            })
        })
    })
})

router.post('/close-seat', isAuthenticated, function (req, res) {
    Ride.findOne({
        _id: req.body.ride_id,
    }, function (err, ride) {
        if(err) throw err
        if(!ride) {
            return res.status(200).send({
                code: 100,
                message: 'Ride not found',
            })
        }

        if(ride.driver._id != req.user._id) {
            return res.status(200).send({
                code: 101,
                message: 'Permission Denied',
            })
        }

        ride.closeSeatBy(req.body.seat, function(err, updatedRide) {
            return res.status(200).send({
                code: 0,
                ride: updatedRide,
            })
        })
    })
})

router.post('/order', isAuthenticated, function (req, res) {
    Ride.findOne({ 
        _id: req.body.ride_id,
    }, function (err, ride) {
        if(err) return res.status(500).send({
            code: 1,
            err,
        })

        if(!ride) {
            return res.status(200).send({
                code: 100,
                message: 'ride_not_found',
            })
        }

        if(!ride.isAvailableForOrder(req.body.seat)) {
            return res.status(200).send({
                code: 101,
                message: 'not_available',
                ride
            })
        }

        Ride.findOneAndUpdate({
            _id: ride._id
        }, {
            $push: {
                passengers: {
                    _id: req.user._id,
                    first_name: req.user.first_name,
                    last_name: req.user.last_name,
                    avatar_url: req.user.avatar_url,
                    seat_order: req.body.seat,
                    blocked_users: req.user.blocked_users,
                }
            },
            $inc: {
                available_seat: -req.body.seat,
            }
        }, { upsert: true, new: true }, function(err, updatedRide) {
            //console.log(updatedRide)
            if(err) {
                let code = 101

                if(err.message == "ride_not_found") {
                    code = 100
                }

                return res.status(200).send({
                    code,
                    message: err.message,
                })
            }

            if(updatedRide.available_seat < 0) {
                console.log('Seat not available for user')
                Ride.findOneAndUpdate({
                    _id: ride._id
                }, {
                    $pull: {
                        passengers: {
                            _id: req.user._id
                        } 
                    },
                    $inc: {
                        available_seat: req.body.seat,
                    }
                }, function(err, updatedRide) {
                    return res.json({
                        code: 101,
                        message: 'not_available',
                        ride
                    })
                })
            } else {
                let buddiesID = []
                ride.passengers.map((passenger, i) =>(
                    buddiesID.push(passenger._id),
                    Buddy.update(
                        { 'user_id': passenger._id },
                        { $addToSet: { buddies : req.user.id } },
                        function(err, result, user) {
                            if(err) return res.status(200).send({ code: 1, err})
                            //console.log('old passenger update') 
                    })
                ))
                buddiesID.push(ride.driver._id)

                let newBuddyList = []
                newBuddyList = _.union(req.buddies, buddiesID)

                Buddy.update(
                    { 'user_id': req.user.id },
                    { buddies : newBuddyList },
                    function(err, result, user) {
                        if(err) return res.status(200).send({ code: 1, err}) 
                    Buddy.update(
                        { 'user_id': ride.driver._id },
                        { $addToSet: { buddies : req.user.id } },
                        function(err, result, user) {
                        if(err) return res.status(200).send({ code: 1, err})
                            
                        Room.findOne({
                            ride_id: req.body.ride_id
                        }, function(err, room) {
                            req.user.addActiveRide(room._id, ride._id, function(err, updatedUser) {
                                 Room.addUser(updatedRide._id, req.user, function(err, room) {
                                    return res.status(200).send({
                                        code: 0,
                                        ride: updatedRide
                                    })
                                })
                            })
                        })
                    })
                })
            }
        })
    })
})

router.delete('/kick-passenger', isAuthenticated, function (req, res) {

    Ride.findByIdAndUpdate(req.query.ride_id, { 
        $pull: {
            passengers: {
                _id: req.query.user_id
            }, 
        },
        $set: {
            available_seat: 0
        }
    }, { new: true }, function(err, ride) {
        if(err) return res.json({ code: 1, err })
        User.update({
            _id: req.query.user_id
        }, {
            $pull: {
                active_rides: req.query.ride_id,
                rooms: { 
                    $elemMatch: { 
                        ride_id: req.query.ride_id,
                    }  
                } 
            }
        }, {
            multi: true
        }, function (err, updatedUser) {
            if(err) throw err
            Room.removeUser(ride._id, {_id: req.query.user_id}, function(err, room) {
                return res.status(200).send({
                    code: 0,
                    ride
                })    
            })
        })
    })
})

router.delete('/order', isAuthenticated, function (req, res) {
    Ride.findByIdAndUpdate(req.query.ride_id, { 
        $pull: {
            passengers: {
                _id: req.user._id
            }, 
        },        $inc: {
            available_seat: req.query.seat
        }
    }, { 
        new: true 
    }, function(err, ride) {
        if(err) throw err
        if(!ride) return res.json({
            code: 1,
            message: 'Ride not found'
        })
            
        User.update({
            _id: req.user._id
        }, {
            $pull: {
                active_rides: req.query.ride_id,
                rooms: { 
                    //$elemMatch: { 
                    ride_id: req.query.ride_id,
                    //}  
                } 
            }
        }, {
            multi: true
        }, function (err, updatedUser) {
            if(err) throw err
            Room.removeUser(ride._id, req.user, function(err, room) {
                return res.status(200).send({
                    code: 0,
                    ride
                })    
            })
        })
    })
})

router.delete('/repeat', isAuthenticated, function(req, res) {
    Ride.findOne({
        _id: req.query.ride_id,
    }, function(err, ride) {
        if(err) throw err

        if(ride.driver._id != req.user._id) {
            return res.status(200).send({
                code: 101,
                message: 'Permission Denied',
            })
        }

        let passengers = ride.passengers
        ride.remove(function (err) {
            RepeatedRide.remove({
                _id: ride.repeated_ride,
            }, function(err) {
                User.update({}, {
                    $pull: { 
                        active_rides: req.query.ride_id,
                    }
                }, {
                    multi: true
                }, function (err, users) {
                    if(err) throw err
                    return res.status(200).send({
                        code: 0,
                        passengers,
                        ride,
                        message: 'Successfully deleted.'
                    })
                })
            })
        })
    })
})

router.delete('/current', isAuthenticated, function(req, res) {
    Ride.findOne({
        _id: req.query.ride_id,
    }, function(err, ride) {
        if(err) throw err

        if(ride.driver._id != req.user._id) {
            return res.status(200).send({
                code: 101,
                message: 'Permission Denied',
            })
        }

        let passengers = ride.passengers

        RepeatedRide.findById(ride.repeated_ride, async function(err, repeatedRide) {
            const day_diff = moment(ride.start_time).diff(moment(), 'hours')
            //const dif = day_diff < 24 ? 0 : (Math.ceil(day_diff / 24))
            let { nextRide } = await repeatedRide.publishNextRide(parseInt(day_diff / 24))
            ride.remove(function (err) {
                User.update({}, {
                    $pull: { 
                        active_rides: req.query.ride_id,
                    }
                }, {
                    multi: true
                }, function (err, users) {
                    if(err) throw err

                    nextRide.as_driver = true
                    nextRide.is_repeated_ride = true
                    nextRide.days = repeatedRide.days
                    nextRide.phones = [{
                        _id: req.user._id,
                        phone: req.user.phone,
                    }]

                    //console.log(nextRide)

                    return res.status(200).send({
                        code: 0,
                        passengers,
                        ride,
                        nextRide,
                        message: 'Successfully deleted.'
                    })
                })
            })
        })  
    })
})

router.delete('/history', isAuthenticated, function(req, res) {
    User.update({
        _id: req.user._id,
    }, {
        $pull: {
            history_rides: req.query.ride_id
        }
    }, {
        multi: true
    }, function (err, users) {
        if(err) throw err

        return res.status(200).send({
            code: 0,
            message: 'Successfully deleted.'
        })
    }) 
})

router.delete('/', isAuthenticated, function (req, res) {
    //history
    Ride.findOne({
        _id: req.query.ride_id,
    }, function(err, ride) {
        if(err) throw err
        if(!ride) {
            return res.status(200).send({
                code: 101,
                message: 'Ride not found',
            })
        }

        if(ride.driver._id != req.user._id) {
            return res.status(200).send({
                code: 101,
                message: 'Permission Denied',
            })
        }

        let passengers = ride.passengers

        ride.remove(function (err) {
            User.update({}, {
                $pull: { 
                    active_rides: req.query.ride_id,
                    // rooms: { 
                    //     $elemMatch: { 
                    //         ride_id: req.query.ride_id,
                    //     }  
                    // } 
                }
            }, {
                multi: true
            }, function (err, users) {
                if(err) throw err

                return res.status(200).send({
                    code: 0,
                    passengers,
                    ride,
                    message: 'Successfully deleted.'
                })
            })
        })
    })
})

function weekToDay(day) {
    switch(day) {
        case 1:
            return 'Mon'
        case 2:
            return 'Tue'
        case 3:
            return 'Wed'
        case 4:
            return 'Thu'
        case 5:
            return 'Fri'
        case 6:
            return 'Sat'
        case 0:
            return 'Sun'
        default:
            return 'Mon'
    }
}

router.post('/', isAuthenticated, function (req, res) {
    Config.findOne({
        key: "start-offer-ride-range",
    }, (err, cfg) => {
        let config = cfg

        if(moment(req.body.start_time).diff(moment(), 'minute') <= config.value) {
            return res.status(200).send({
                code: 1,
                message: "start_time_error",
            })
        }

        Ride.find({
            _id: {
                $in: req.user.active_rides
            }
        }, function(err, my_rides) {
            if(err) throw err
            let isCollisionAppears = false
            let repeatedRideIds = []
            my_rides.forEach((ride) => {
                if(ride.repeated_ride) {
                    repeatedRideIds.push(ride.repeated_ride)
                }
                if(ride.isCollisionAppears(req.body)) {
                    isCollisionAppears = true
                }
            })

            if(isCollisionAppears) {
                return res.status(200).send({
                    code: 1,
                    message: "start_time_collision",
                }) 
            }

            RepeatedRide.find({
                _id: {
                    $in: repeatedRideIds
                }
            }, function(err, repeatedRides) {
                if(err) throw err

                repeatedRides.forEach((repeatedRide) => {
                    if(repeatedRide.isCollisionAppears(req.body)) {
                        isCollisionAppears = true
                    }
                })

                if(isCollisionAppears) {
                    return res.status(200).send({
                        code: 1,
                        message: "start_time_collision",
                    }) 
                }

                Dashboard.findOne({ user_id: req.user._id }, function (err, dashboard) {
                    if(err) throw err
                
                    let newRide = {}
                    const {
                        is_repeat,
                        repeat_days,
                    } = req.body

                    req.body.driver.blocked_users = req.user.blocked_users
                    req.body.driver.rating = dashboard.travel.asDriver.rating
                    req.body.driver.ride_count = dashboard.travel.asDriver.rating_count

                    // console.log({
                    //     is_repeat,
                    //     repeat_days
                    // })

                    var rideParameters = req.body
                    let nextRideDay = moment(req.body.start_time)
                    var repeated_ride_id = RepeatedRide.createObjectId()
                    //console.log(moment(req.body.start_time))
                    if(is_repeat) {
                        rideParameters.repeated_ride = repeated_ride_id
                    }

                    rideParameters.start_time = nextRideDay

                    Ride.create(rideParameters, function (err, ride) {
                        var user = req.user
                        user.active_rides.push(ride._id)
                        Room.create({
                            ride_id: ride._id,
                            start_location: ride.start_location.place_name,
                            end_location: ride.end_location.place_name,
                            created_at: new Date(),
                            users: [{
                                _id: user._id,
                                first_name: user.first_name,
                                last_name: user.last_name,
                                avatar_url: user.avatar_url,
                                is_driver: true,
                            }]
                        }, function (err, room) {
                            if(err) throw err
                            Notify.matchNotify(ride)
                            
                            user.rooms.push({
                                _id: room._id,
                                ride_id: ride._id,
                            })
                            user.save(function(err, newUser) {
                                if(err) throw err
                                if(is_repeat) {
                                    RepeatedRide
                                    .create({
                                        _id: repeated_ride_id,
                                        user: user._id,
                                        ride_template: ride,
                                        days: repeat_days
                                    }, function(err, repeat) {
                                        if(err) throw err
                                        res.status(200).send({
                                            code: 0,
                                            _id: ride._id,
                                            user: newUser
                                        })
                                    })
                                } else {
                                    res.status(200).send({
                                        code: 0,
                                        _id: ride._id,
                                        user: newUser
                                    })
                                }
                            })
                        })
                    }) 
                })    
            })
        })
    })
})

router.get('/', function (req, res) {
	Ride.find({}, function (err, users) {
        if (err) return res.status(500).send("There was a problem finding the users.");
        res.status(200).send(users);
    });
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
