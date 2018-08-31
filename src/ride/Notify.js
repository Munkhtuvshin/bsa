var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var _ = require('lodash')
var Schema = mongoose.Schema

import {
  //sendRemoteMessage,
  sendRemoteNotification,
  sendRemoteNotificationToIOS
} from '../presence/PushMessage'

var NotifySchema = new Schema({ 
  user: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User',
  },
  start_location: {
  	place_name: String,
  	coordinate: {
        type: [Number],
        required: true,
        index: "2dsphere"
    }
  },
  end_location: {
  	place_name: String,
  	coordinate: {
        type: [Number],
        required: true,
        index: "2dsphere"
    }
  },
  status: {
    type: String,
    default: 'created',
  }, //sented, seen, not seen
  start_time: Date,
  end_time: Date,
  created_at: {
    type: Date,
    default: new Date(),
  },
}, {
  collection: 'notify'
})

NotifySchema.statics.matchNotify = function(ride) {
  let DISTANCE = 1 / 6378.1

  this
  .find({
     start_time: {
        $lte: ride.start_time,
     },
     end_time: {
        $gte: ride.start_time
     },
     "start_location.coordinate": {
        $geoWithin: { 
          $centerSphere: [
            ride.start_location.coordinate, 
            DISTANCE,
          ] 
        }
      },
      "end_location.coordinate": {
        $geoWithin: { 
          $centerSphere: [
            ride.end_location.coordinate, 
            DISTANCE,
          ] 
        }
      }
  }, function(err, notifies) {
    if(err) throw err
    let suggested_ride = {
       _id: ride._id,
       start_location: ride.start_location,
       end_location: ride.end_location,
       start_time: ride.start_time,
       price_per_person: ride.price_per_person,
       available_seat: ride.available_seat,
    }

    //let notify

    //Тэндээс тийэшээ явах унаа олдлоо. Та энд дарж суудал захиалах боломжтэй
    //Таны хайсан цагт явах унаа олсонгүй. Та дараа дахин хайж үзээрэй 

    console.log(ride.start_time)
    console.log('lenght = ' + notifies.length)

    notifies.forEach((notify) => {
      sendRemoteNotification(notify.user, {
          title: "beeco - Замын унаа апп",
          body: '"' + notify.start_location.place_name + '"-ээс "' + notify.end_location.place_name + '"-рүү явах унаа олдлоо. Та энд дарж суудал захиалах боломжтой',
          large_icon: ride.driver.avatar_url,
          suggested_ride,
          notify,
          targetScreen: "notify"
      }, { priority: "high" })

      sendRemoteNotificationToIOS(notify.user, {
          title: "beeco - Замын унаа апп",
          body: '"' + notify.start_location.place_name + '"-ээс "' + notify.end_location.place_name + '"-рүү явах унаа олдлоо. Та энд дарж суудал захиалах боломжтой',
      }, { priority: "high" }, {
        suggested_ride,
        notify,
        targetScreen: "notify"
      })
    })
    //console.log(notifies)
  })
}

NotifySchema.plugin(mongoosePaginate)
module.exports = mongoose.model('Notify', NotifySchema)
