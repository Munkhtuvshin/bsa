var admin = require("firebase-admin")
var serviceAccount = require("../../beeco-156f5-firebase-adminsdk-rlduo-507ea5f413.json")

var User = require('../user/User')

export function sendRemoteNotificationToIOS(user_id, data, options, extraData = {}) {
  console.log('user = ' + user_id)
  User.findOne({
    _id: user_id
  }, 'fcm_token', function(err, user) {
    if(err) throw err
    if(user == null) {
      console.log('User not found')
      return
    }
    if(user.fcm_token == null) {
      console.log('user token not found')
      return
    }

    let tokens = []
    tokens.push(user.fcm_token)
    var payload = {
      //"content-available" : true,
      "data": {
        sound: "default",
        color: "#e0622e",
        priority: "high",
        icon: "ic_launcher",
        data: JSON.stringify(extraData),
      },
      "notification": {
          ...data,
          sound: "default",
          //"click_action": "mn.beeco.ridesharing" // The id of notification category which you defined with FCM.setNotificationCategories
      }
    }

    //console.log(payload)

    admin.messaging().sendToDevice(tokens, payload, options)
       .then(function(response) {
        console.log(response)
       })
       .catch(function(error) {
        console.log(error)
       })
  })
}

export function sendRemoteNotification(user_id, data, options) {
  console.log('user = ' + user_id)
  User.findOne({
    _id: user_id
  }, 'fcm_token', function(err, user) {
    if(err) throw err
    if(user == null) {
      console.log('User not found')
      return
    }
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
            //console.log(response)
       })
       .catch(function(error) {
            //console.log(error)
       })
  })
}