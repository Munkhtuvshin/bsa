var mongoose = require('mongoose')
var _ = require('lodash')
var moment = require('moment')
var User = require('../user/User')
var Ride = require('../ride/Ride')
var Room = require('../room/Room')
var Notify = require('../ride/Notify')
var Schema = mongoose.Schema

var RepeatedRideSchema = new Schema({  
  user: {
    type: mongoose.Schema.Types.ObjectId,
    ref: 'User', 
  },
  days: [String],
  ride_template: {
    start_location: {
      place_name: String,
      poi_distance: Number,
      coordinate: {
          type: [Number],
          required: true,
          index: "2dsphere"
      }
    },
    end_location: {
      place_name: String,
      poi_distance: Number,
      coordinate: {
          type: [Number],
          required: true,
          index: "2dsphere"
      }
    },
    driver: {
      _id: { type: String },
      avatar_url: String,
      first_name: String,
      last_name: String,
      rating: Number,
      ride_count: Number,
      car: {
        car_avatar_url: String,
        plateNumber: String,
        plateText: String,
      },
      blocked_users: [String],
    },
    passengers: [{
      _id: String,
      first_name: String,
      last_name: String,
      avatar_url: String,
      seat_order: Number,
      blocked_users: [String]
    }],
    start_time: Date,
    price_per_person: Number,
    total_distance: Number,
    available_seat: Number,
    offer_seat: Number,
    blocked_seat: [{
      _id: String,
      first_name: String,
      last_name: String,
      avatar_url: String,
      seat_order: Number,
      message: String,
    }],
    closed_seat: {
      type: Number,
      default: 0,
    },
    has_additional_number: Boolean,
    additional_number: String,
    is_repeat: Boolean,
    created_at: {
      type: Date,
      default: Date.now
    }
  }
}, {
  collection: 'repeated_ride'
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

RepeatedRideSchema.statics.createObjectId = function() {
  return mongoose.Types.ObjectId()
}

RepeatedRideSchema.methods.isCollisionAppears = function({ start_time, is_repeat, repeat_days }) {
  const different = 10
  let startTime = moment(this.ride_template.start_time)
  let compareTime = moment(this.ride_template.start_time)
  compareTime.hours(moment(start_time).hours())
  compareTime.minutes(moment(start_time).minutes())
  compareTime.seconds(0).seconds(0)
  compareTime.milliseconds(0).milliseconds(0)

  let isTimeCollision = moment(compareTime).isSameOrAfter(moment(startTime).add(-different, 'minutes')) && moment(startTime).add(different, 'minutes').isSameOrAfter(compareTime)
  //console.log('isTimeCollision = ' + isTimeCollision)
  if(!isTimeCollision) return false

  isTimeCollision = false

  if(is_repeat) {
    //console.log(repeat_days)
    //console.log(this.days)
    repeat_days.forEach((currentDay) => {
        let correct = _.findIndex(this.days, (day) => { return day == currentDay })
        if(correct != -1) {
            isTimeCollision = true
        }
    })
  } else {
    console.log('week = ' + weekToDay(moment(start_time).weekday()))
    let correct = _.findIndex(this.days, (day) => { return day == weekToDay(moment(start_time).weekday())})
    isTimeCollision = correct == -1 ? false : true
  } 

  return isTimeCollision
}

RepeatedRideSchema.methods.publishNextRide = function(day_diff = 0) {
  return new Promise((resolve, reject) => {
      //console.log('day_diff = ' + day_diff)
      const next7Days = day_diff + 7
      let nextRideDay = moment()

      console.log('start = ' + moment().add((day_diff + 1), 'days').format('YYYY/MM/DD'))
      console.log('end = ' + moment().add(next7Days, 'days').format('YYYY/MM/DD'))

      for(let i = day_diff + 1; i <= next7Days; i ++) {
          let nextDay = moment().add(i, 'days')
          let nextWeekday = nextDay.weekday()
          //console.log('week = ' + nextWeekday)
          let is_existing_day = _.findIndex(this.days, (week) => { return week == weekToDay(nextWeekday)})
          //console.log('is_existing_day = ' + is_existing_day)
          if(is_existing_day != -1) {
              nextRideDay = nextDay
              break
          }
      } 

      nextRideDay.hours(moment(this.ride_template.start_time).hours())
      nextRideDay.minutes(moment(this.ride_template.start_time).minutes())
      nextRideDay.seconds(0)
      nextRideDay.milliseconds(0)

      //console.log('next days = ' + nextRideDay.format('YYYY-MM-DD HH:MM'))

      let {
        start_location,
        end_location,
        driver,
        price_per_person,
        total_distance,
        available_seat,
        offer_seat,
        blocked_seat,
        closed_seat,
        has_additional_number,
        additional_number
      } = this.ride_template

      let rideParameters = {
          repeated_ride: this._id,
          start_location: start_location,
          end_location: end_location,
          driver: driver,
          passengers: [],
          start_time: nextRideDay,
          price_per_person: price_per_person,
          total_distance: total_distance,
          available_seat: available_seat,
          offer_seat: offer_seat,
          blocked_seat: blocked_seat,
          closed_seat: closed_seat,
          has_additional_number: has_additional_number,
          additional_number: additional_number,
          is_repeat: true,
      }

      //console.log(rideParameters)
      //console.log(' ==========> ')

      User.findById(this.ride_template.driver._id, function(err, user) {
         if(err) throw err
         //console.log(user)
         Ride.create(rideParameters, function (err, ride) {
            if(err) {
              ///console.log('There is error something in create new ride')
              throw err
            }
            //console.log(ride)
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
                user.save(function(err) {
                    if(err) throw err   
                    resolve({
                        nextRide: ride.toObject(),
                        user,
                    })
                })
            })
        })
      })
  })
}

module.exports = mongoose.model('RepeatedRide', RepeatedRideSchema)
