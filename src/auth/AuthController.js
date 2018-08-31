var Buddy = require('../user/RideBuddies')
var Dashboard = require('../dashboard/dashboard')
var User = require('../user/User')
var Ride = require('../ride/Ride')
var RideHistory = require('../ride/RideHistory')
var PhoneVerify = require('./PhoneVerify')
var moment = require('moment')
const MessageFactory = require('../system_message/MessageFactory').default
var jwt = require('jwt-simple')
import { copyPhoto } from '../photos/PhotoCopy' 
import { cryptPassword, comparePassword} from './Encryption' 
import { mgsLog } from '../system_message/MsgLogger' 
import _ from 'lodash'
import axios from 'axios'
import { couponApi, newCouponV2 } from '../coupon/CouponApi' 

var fs = require('fs')
var request = require('request');

module.exports = function (app, passport, io) {

    app.get('/history-job', function(req, res) {
        Ride.find({
        start_time: {
          $lt: moment().subtract(10, 'minutes')
        }
      }, function(err, rides) {
        let ride_ids = rides.map(ride => ride._id)

        for(let i = 0; i < rides.length; i ++) {
            _.forEach(rides[i].passengers, (passenger) => {
                //console.log(rides[i]._id + " => " + passenger._id)
                /*User.update({
                    _id: passenger._id,
                }, {
                    $pull: {
                        active_rides: ride._id,
                    },
                    $push: {
                        history_rides: ride._id,
                    }
                })*/
            })

            //console.log(rides[i].driver._id + " => " + rides[i]._id)
            /*User.update({
                _id: rides[i].driver._id,
            }, {
                $pull: {
                    active_rides: rides[i]._id,
                },
                $push: {
                    history_rides: rides[i]._id,
                }
            })*/
        } 

        return res.status(200).send({ code: 0, })

        /*Ride.remove({
            _id: {
                $in: ride_ids
            }
        }, function(err, result) {
            RideHistory.insertMany(rides, function(err, rideHistories) {
                for(let i = 0; i < rides.length; i ++) {
                    _.forEach(rides[i].passengers, (passenger) => {
                        ////console.log(ride._id + " => " + passenger)
                        User.update({
                            _id: passenger._id,
                        }, {
                            $pull: {
                                active_rides: ride._id,
                            },
                            $push: {
                                history_rides: ride._id,
                            }
                        })
                    })

                    User.update({
                        _id: rides[i].driver._id,
                    }, {
                        $pull: {
                            active_rides: rides[i]._id,
                        },
                        $push: {
                            history_rides: rides[i]._id,
                        }
                    })
                } 
            })   
        })*/
/*
        

        

           */       
      })
    })

    app.post('/logout', isAuthenticated, function (req, res) {


        return res.status(200).send({
            code: 0,
            message: 'Succesfully Logout',
        })
    })

    app.post('/check-phone-number', function (req, res) {
        
        let { phone, step } = req.body
            // step 1 register
            // step 2 change phone number
            // step 3 forgot password

        let query = {}
        let query2 = {}

        if(step == 3) {
            query = {
                phone: phone.phone,
                birthday: phone.birthday,
                delete_account: false,
                direct_login: true
            },
            query2 = { phone: phone.phone }
            phone = phone.phone
        }
        else {
            query = { phone }, 
            query2 = { phone }
        }
        
        User.findOne(
            query,
        function(err, user) {
            if(!user) {
                if( step == 3 ) {
                    return res.status(200).send({
                        code: 1,
                        message: 'check phone number',
                    })
                }
            }

            let verification_code = Math.floor(1000 + Math.random() * 9000)
            //let verification_code = "9999"
            let message = "[www.beeco.mn] " + verification_code + " batalgaajuulah code."
            MessageFactory(phone).sendMessage({ phone, message, verification_code })
            //console.log(message)
            //MessageFactory(phone).sendMessage({ phone, message, verification_code })
            //console.log(message)
            PhoneVerify.findOneAndUpdate(
                query2,
            {  
                verification_code 
            }, { 
                new: true, 
                upsert: true
            }, function(err, phone) {
                if (err) throw err
                return res.status(200).send({
                    code: 0,
                    verification_code: phone.verification_code,
                    //message: 'Available',
                })
            })
        })
    })

    app.post('/signUp', function(req, res) {
       
        User.findOneAndUpdate(
            { phone: req.body.phone, phone_verified: true },
            { phone_verified: false }, 
            function(err, oldUser){
            if (err) return res.status().send({ code: 1, message: err}) 

            var newUser = new User()
            newUser.birthday = req.body.birthday
            newUser.first_name = req.body.first_name
            newUser.last_name = req.body.last_name
            newUser.phone = req.body.phone
            newUser.phone_verified = true
            newUser.gender = req.body.gender
            newUser.direct_login = true
            newUser.terms_and_conditions = true
            newUser.delete_account = false
            newUser.avatar_url = "avatar-image-"
            cryptPassword(req.body.password, function(err, hash) {
                newUser.password = hash
                newUser.save(function(err, existUser) {
                    if (err) throw err
                    req.session.user = newUser
                    var token = jwt.encode(newUser.toObject(), "beecosecretkey")
                    createUserCollections(newUser)
                    
                    newCouponV2({
                        user: newUser,
                        achievement: 'Signup',
                        io,
                    }, function(response){
                    })
                    
                    mgsLog(req.body.phone, "Дугаар амжилттай баталгаажлаа")
                    return res.status(200).send({
                            code: 0,
                            user: newUser,
                            token
                    })
                })    
            })
        })
    })

    app.post('/admin-login', function(req, res) {
        const {
            email,
            password,
        } = req.body

        if(email == 'admin@gmail.com' && password == 'devs.pts') {
            return res.json({
                code: 0,
                user: {
                    _id: 1,
                },
                token: 'Testtoken',
                message: 'Successfully logged in', 
            })
        }

        return res.json({
            code: 1,
            message: 'Check username or password'
        });
    })

    app.post('/login', function(req, res) {  
        User.find({
            phone: req.body.phone,
            direct_login: true,
            delete_account: false
        }, function(err, user) {
            if(err) { return res.status(403).send({ code: 1,}) }
            
            //console.log(req.body.password)

            if(user.length == 0) {
                console.log('user not found')
                return res.status(200).send({
                    code: 1,
                    message: 'Check phone or password'
                })
            }
            let count = 0
            _.find(user, (user_data) => {
                count = count + 1 // tuhain utasnii dugaartai niit hereglegch hurtel nemegdene ( direct login )
                if(user_data && user_data.compareHash(req.body.password)) {
                    req.session.user = user_data
                    var token = jwt.encode(user_data.toObject(), "beecosecretkey")
                    return res.status(200).send({
                        code: 0,
                        user: user_data,
                        token
                    })
                }else
                    if(count == user.length) { 
                        console.log('Check phone or password')
                        return res.status(200).send({
                            code: 1,
                            message: 'Check phone or password'
                        })
                    }
            })

        })
    })

    app.post('/login/facebookSignUp', function(req, res) {
        User.findOne({ 
            'facebook_connection.id': req.body.id,
            'delete_account': false }, function(err, user) {
            if (err) return res.status(200).send({ code: 1, err })

            if (user) {
                //console.log('burtgeltei bn')
                return res.status(200).send({ code: 1, message: "Бүртгэлтэй байна" })
            }else{

                User.findOneAndUpdate(
                    { phone: req.body.phone, phone_verified: true },
                    { phone_verified: false }, 
                    function(err, oldUser){
                    if (err) return res.status().send({ code: 1, message: err}) 
                    
                    var newUser = new User()
                    newUser.email = req.body.email
                    newUser.avatar_url = "https://graph.facebook.com/" + req.body.id +"/picture?width=720"
                    newUser.gender = req.body.gender
                    newUser.birthday = req.body.birthday
                    newUser.first_name = req.body.first_name
                    newUser.last_name = req.body.last_name
                    newUser.phone = req.body.phone
                    newUser.phone_verified = true
                    newUser.direct_login = false
                    newUser.terms_and_conditions = true
                    newUser.delete_account= false
                    newUser.fcm_token = ""
                    newUser.facebook_connection = {
                        id: req.body.id,
                        access_token: req.body.token,
                        is_connected: true,
                    }

                    req.session.key = req.body.token
                    req.session.user = newUser

                    newUser.save(function(err, existUser) {
                        if (err) throw err
                        
                        mgsLog(req.body.phone, "Дугаар амжилттай баталгаажлаа")
                        downloadFacebookImage(existUser, res)
                        createUserCollections(newUser)
                        
                    })

                })
                //console.log(" new facebook account ")
                
            }
        })
    })

	app.post('/login/facebook', function(req, res) {
        User.findOne({ 
            'facebook_connection.id' : req.body.id,
            'delete_account': false
            }, function(err, user) {
            if (err) return res.status(200).send({ code: 1, err })

            if (user) {
                ////console.log(req.body.token)
                user.facebook_connection.access_token = req.body.token
                user.save(function(err, updatedUser) {
                    if (err) throw err
                    req.session.key = req.body.token
                    req.session.user = updatedUser
                    return res.status(200).send({
                        code: 0,
                        user: updatedUser
                    })    
                })
            } else {
                return res.status(200).send({
                    code: 1,
                    user: 'Burtgelgui'
                })
            } 
        })
	})
	/*app.get('/login/facebook', passport.authenticate('facebook', { 
		//scope: ['email', 'user_friends', 'gender', 'user_about_me', 'user_birthday'] 
		scope: ['email', 'user_friends', 'public_profile']
	}))*/

    app.get('/change-password', isAuthenticated, function (req, res) {

        if(!req.isAuthenticated()) {
            return res.status(200).send({
                code: 1,
            })    
        }
    
        let oldPass = req.query.oldPassword
        let newPass = req.query.newPassword

        User.findOne({
            _id: req.user._id
        }, function(err, user) {
            if(err) { return res.status(403).send({ code: 1, }) }

            if(user && user.compareHash(oldPass)) {
                cryptPassword(newPass, function(err, hash) {
                    let doc = { password: hash } 
                    User.update({_id: req.user._id}, doc, function(err, callback) {
                        if (err) { res.send({ code: 1, message: err }); }
                        //console.log('Succesfully change password')
                        return res.status(200).send({
                            code: 0,
                            message: 'Succesfully'
                        })
                    });
                })
            } else {
                //console.log('Нууц үгээ шалгана уу!')
                return res.status(200).send({
                    code: 1,
                    message: 'Нууц үгээ шалгана уу!'
                }) 
            }
        })
    })

    app.post('/forgot-password', function (req, res) {

        cryptPassword(req.body.password, function(err, hash) {
            if (err) { res.status(403).send({ code: 1, message: err}); }
                   
            User.findOneAndUpdate(
                { phone: req.body.phone, phone_verified: true },
                { phone_verified: false }, 
                function(err, oldUser){
                if (err) return res.status().send({ code: 1, message: err}) 

                let doc = { password: hash, phone_verified: true }
                User.findOneAndUpdate({
                    phone: req.body.phone,
                    direct_login: true,
                    delete_account: false,
                    birthday: req.body.birthday
                },  doc, 
                {
                    new: true
                },function(err, user) {
                    if (err) { return res.status(403).send({ code: 1, message: err}); }
                    if(!user) { return res.status(403).send({ code: 2, message: 'Burtgel alga' }) } 

                    req.session.user = user
                    var token = jwt.encode(user.toObject(), "beecosecretkey")
                    return res.status(200).send({
                        code: 0,
                        user,
                        token
                    })
                })
            }) 
        })
    })

    app.get('/change-phone-number', isAuthenticated, function(req, res){
        if(!req.isAuthenticated()) {
            return res.status(200).send({
                code: 1,
            })    
        }

        User.findOneAndUpdate(
            { phone: req.query.phone, phone_verified: true },
            { phone_verified: false }, 
            function(err, oldUser){
            if (err) return res.status().send({ code: 1, message: err}) 

            let doc = { phone: req.query.phone, phone_verified: true }
            User.findOneAndUpdate({
                    _id: req.user._id 
                },  doc, 
                {
                    new: true
                },function(err, user){
                    if (err) return res.status().send({ code: 1, message: err}) 
                    
                    req.session.user = user
                    var token = jwt.encode(user.toObject(), "beecosecretkey")

                    mgsLog(req.query.phone, "Дугаар амжилттай баталгаажлаа")
                    return res.status(200).send({
                        code: 0,
                        message: 'Succesfully',
                        user,
                        token
                    })
                }
            )
        })     
    })

    app.post('/delete-account', isAuthenticated, function(req, res){
        if(!req.isAuthenticated()) {
            return res.status(200).send({
                code: 1,
            })    
        }   

        User.findOneAndUpdate(
            { _id: req.body.id },
            { 'delete_account': true,
              'fcm_token': '' }, 
            { new: true },
            function(err, oldUser){
            if (err) return res.status().send({ code: 1, message: err}) 

                return res.status(200).send({
                    code: 0,
                    message: 'Succesfully',
                })
            }
        )   
    })

    function downloadFacebookImage(existUser, resp) {
        var key = existUser._id + '-' + Date.now() + Math.floor(Math.random() * 8999)

        axios
        .get(existUser.avatar_url, {
          responseType: 'arraybuffer'
        })
        .then(response => {
            let buffer = new Buffer.from(response.data, 'binary')//Buffer(response.data, 'binary').toString('base64')
            copyPhoto({buffer: buffer, key, name: 'avatar', bucketName: 'beeco-avatar'}, function(response){
              var token = jwt.encode(existUser.toObject(), "beecosecretkey")
                console.log(response.imageUrl)
                existUser.avatar_url = response.imageUrl
                existUser.save()
                console.log('facebook succes')
                newCouponV2({ user: existUser, achievement: 'Signup', io }, function(response){
                })

                return resp.status(200).send({
                        code: 0,
                        user: existUser,
                        message: 'Амжилттай нэвтэрлээ',
                        token
                })
            })
        })
        .catch(error => {
            console.log(error)
        })
    }

    function createUserCollections(newUser) {
        createBuddyCollection(newUser)
        createDashboardCollection(newUser)
    }

    function createDashboardCollection(req){

        var newUser = {
            user_id: req._id,
            fb_id: req.facebook_connection.id,
            name: req.last_name,
            first_name: req.first_name,
            avatar_url: req.avatar_url,
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
        })
    }

    function createBuddyCollection(newUser) {

        var user = {
            user_id: newUser._id,
            fb_id: newUser.facebook_connection.id,
            last_name: newUser.last_name,
            first_name: newUser.first_name,
        }

        Buddy.create(user, function (err, buddies) {
            if(err) console.log(err)
        })
    }

    function isAuthenticated(req, res, next) {
        req.verifyTokenIfAny(req, res, next)
    }
}