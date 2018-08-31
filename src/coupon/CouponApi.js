import Config from '../config/Config.js'
import axios from 'axios'
import { couponCreate, createCoupons } from '../coupon/CreateCoupon' 
var User = require('../user/User')
const key = "coupon-code"
var Notification = require('../notification/Notification')
var Presence = require('../presence')

var admin = require("firebase-admin")
var serviceAccount = require("../../beeco-156f5-firebase-adminsdk-rlduo-507ea5f413.json")
// Bvrtgvvlj bgaa ued 

// admin.initializeApp({
//   credential: admin.credential.cert(serviceAccount),
//   databaseURL: process.env.FB_HOST
// })couponCreate

exports.couponApi = function(req, callback) {

    let phone = req.user.phone
    const achievement = req.achievement
    let io = req.io
    
    User.find({
        phone
    }, function(err, user){

        if(user.length == 0) return

        if(user.length > 1) {
            console.log("Бүртгэлтэй дугаар учир Coupon өгөх боломжгүй")
            return
        }

        newCoupon(req, achievement, io)
    })     
}

exports.couponLink = function(req, callback) {
    console.log('---')
//    couponLocal(req)         
}

// coupon awah
function couponLocal(req) {

    Config.findOne({
        key
    }, (err, cfg) => {
        let config = cfg.value
        
        axios.post("http://coupon.test:8000//api/coupon", {
            organization_id: 1,
            merchant_id: 1,
            coupon_template_id: "BT0001"
        },{
            headers: { 
            //  Authorization: 'Bearer ' + config.token,
              'Content-Type': 'application/x-www-form-urlencoded' 
            }
        })
          .then((res) => {
            
        })
          .catch((err) => {
              console.log(err)
              console.log("error")
        })                   
    }) 
}

// coupon awah
exports.newCouponForOldUsers = async function(user) {
    let cfg = await Config.findOne({
        key
    }).exec()

    let config = cfg.value
    let res = await axios.post(config.host, {
            organization_id: 1,
            merchant_id: 1,
            coupon_template_id: "BT0001"
        },{
            headers: { 
              Authorization: 'Bearer ' + config.token,
              'Content-Type': 'application/x-www-form-urlencoded' 
            }
        }, { timeout: 100000 })

    if(res.data.code == 0) {
        couponCreate({ result: res.data.result, user }, function(response){
            Notification.create({
              type: 'COUPON',
              //message: "Та урамшууллаа энд дарж, эсвэл Үндсэн цэсний Урамшуулал хэсгээс харна уу",
              message: response.coupons.coupon_data.short_description,
              user_id: user._id,
              data: {},
              icon: response.coupons.coupon_data.cover_url
            }, function(err, notification) {
                if(err) throw err
            })
        })
    }
}

exports.getMassCoupons = function(coupons, callback) {
    Config.findOne({
        key
    }, (err, cfg) => {
        let config = cfg.value

        axios.post(config.host, {
            organization_id: 1,
            merchant_id: 1,
            coupons,
        },{
            headers: { 
              Authorization: 'Bearer ' + config.token,
              'Content-Type': 'application/json' 
            }
        })
        .then((res) => {
              if(res.data.code != 0) {
                  console.log('There is some error during coupon.beeco.mn');
                  return
              }

              //console.log('host = ' + res.data.result.)

              callback(null, {
                  result: res.data.result
              })
        })
          .catch((err) => {
              console.log(err)
        })  
                 
    }) 
}

exports.newCouponV2 = function(req, achievement, io) {
    Config.findOne({
        key
    }, (err, cfg) => {
        let config = cfg.value

        axios.post(config.host, {
            organization_id: 1,
            merchant_id: 1,
            coupons: [{
              template_id: 'BT0001',
              count: 1,
            }, {
              template_id: 'BT0002',
              count: 1,
            }]
        },{
            headers: { 
              Authorization: 'Bearer ' + config.token,
              'Content-Type': 'application/json' 
            }
        })
          .then((res) => {
              if(res.data.code != 0) {
                  return
              }
              
              createCoupons({
                  result: res.data.result, 
                  user: req.user,
                  achievement,
              }, function(response) {
                  let notifications = []
                  response.coupons.forEach((coupon) => {
                      Notification.create({
                        type: 'COUPON',
                        //message: "Та урамшууллаа энд дарж, эсвэл Үндсэн цэсний Урамшуулал хэсгээс харна уу",
                        message: coupon.coupon_data.short_description,
                        user_id: req.user._id,
                        data: {},
                        icon: coupon.coupon_data.cover_url
                      }, function(err, notification) {
                          if(err) throw err

                          //if(!achievement == 'Signup') {
                              sendRemoteNotification(req.user._id, {
                                  title: "beeco - Замын унаа апп",
                                  body: 'Beeco-г сонгосонд баярлалаа! Та апп-н УРАМШУУЛАЛ хэсгээс төрөл бүрийн хөнгөлөлтийн эрх аваарай.',
                                  //large_icon: coupon.coupon_data.cover_url,
                              }, { priority: "high" })

                              sendRemoteNotificationToIOS(req.user._id, {
                                  title: "beeco - Замын унаа апп",
                                  body: 'Beeco-г сонгосонд баярлалаа! Та апп-н УРАМШУУЛАЛ хэсгээс төрөл бүрийн хөнгөлөлтийн эрх аваарай.'
                                  //large_icon: coupon.coupon_data.cover_url,
                              }, { priority: "high" })
                              console.log('amjilttai coupon burtgelee')
                          //}
                      })
                  })
              })
        })
          .catch((err) => {
              console.log(err)
        })  
                 
    }) 
}
// coupon awah
function newCoupon(req, achievement, io) {
    Config.findOne({
        key
    }, (err, cfg) => {
        let config = cfg.value
        
        axios.post(config.host, {
            organization_id: 1,
            merchant_id: 1,
            coupon_template_id: "BT0001"
        },{
            headers: { 
              Authorization: 'Bearer ' + config.token,
              'Content-Type': 'application/x-www-form-urlencoded' 
            }
        })
          .then((res) => {
              if(res.data.code != 0) {
                  return
              }
              
              couponCreate({
                  data: res.data, 
                  user: req.user,
                  achievement,
              }, function(response){
                  Notification.create({
                    type: 'COUPON',
                    //message: "Та урамшууллаа энд дарж, эсвэл Үндсэн цэсний Урамшуулал хэсгээс харна уу",
                    message: response.coupons.coupon_data.short_description,
                    user_id: req.user._id,
                    data: {},
                    icon: response.coupons.coupon_data.cover_url
                  }, function(err, notification) {
                      if(err) throw err

                      //locall notification
                      // console.log('TRYING TO SEND LOCAL')
                      // setTimeout(() => {
                      //     Presence.get(req.user._id, function(data) {
                      //         console.log(data)
                      //         if(data) {
                      //             io.to(data.meta.connection).emit('coupon received', { cover_url: response.coupons.coupon_data.cover_url, notification })
                      //             //if(callback) callback({ code: 0, })
                      //         }
                      //     })
                      // }, 3000)
                      
                        //Эхэлж бүртгүүлсэн үед push илгээж амжихгүй учир сүүлд илгээнэ
                      if(!achievement == 'Signup') {
                          sendRemoteNotification(req.user._id, {
                              title: "beeco - Замын унаа апп",
                              body: response.coupons.coupon_data.short_description,
                              large_icon: response.coupons.coupon_data.cover_url,
                          }, { priority: "high" })

                          sendRemoteNotificationToIOS(req.user._id, {
                              title: "beeco - Замын унаа апп",
                              body: response.coupons.coupon_data.short_description,
                              large_icon: response.coupons.coupon_data.cover_url,
                          }, { priority: "high" })
                          console.log('amjilttai coupon burtgelee')
                      }
                  })

              })
        })
          .catch((err) => {
              console.log(err)
        })  
                 
    }) 
}

function sendRemoteNotificationToIOS(user_id, data, options) {
  User.findOne({
    _id: user_id
  }, 'fcm_token', function(err, user) {
    console.log(user)
    if(user.fcm_token == null) {
      console.log('user token not found')
      return
    }

    let tokens = []
    tokens.push(user.fcm_token)
    var payload = {
      //"content-available" : true,
        "notification": {
           ...data,
           //"click_action": "mn.beeco.ridesharing" // The id of notification category which you defined with FCM.setNotificationCategories
      },
    }

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
    if(user.fcm_token == null) {
      console.log('user token not found')
      return
    }

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
          }))
      }
    }

    admin.messaging().sendToDevice(tokens, payload, options)
       .then(function(response) {
            console.log(response)
       })
       .catch(function(error) {
            console.log(error)
       })
  })
}
