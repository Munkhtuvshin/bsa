var mongoose = require('mongoose')
var _ = require('lodash')
var moment = require('moment')
var Schema = mongoose.Schema

var RideSchema = new Schema({  
  repeated_ride: {
    type: String,
    default: '',
  },
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
}, {
  usePushEach: true
})

RideSchema.statics.createObjectId = function() {
  return mongoose.Types.ObjectId()
}

RideSchema.static.getNewRideData = function(params, start_time, repeat_id) {
  try {
    let object = {
      repeated_ride: repeat_id,
      start_location: params.start_location,
      end_location: params.start_location,
      driver: params.driver,
      passengers: [],
      start_time,
      price_per_person: params.price_per_person,
      total_distance: params.total_distance,
      available_seat: params.available_seat,
      offer_seat: params.offer_seat,
      blocked_seat: params.blocked_seat,
      closed_seat: params.closed_seat,
      has_additional_number: params.has_additional_number,
      additional_number: params.additional_number,
      is_repeat: true,
    }
    console.log(object)
    return object
  } catch(e) {
    console.log(e)
  }
}

RideSchema.methods.isAvailableForOrder = function(seat) {
  return this.available_seat >= seat
}

RideSchema.methods.orderCancelSeat = function (user_id, seat, callback) {
  var passenger = _.find(this.passengers, (passenger) => {
    return passenger._id == user_id
  })

  if(passenger) {
      passenger.seat_order -= seat
      this.available_seat += seat
      this.save(callback)
  }
}

RideSchema.methods.orderAddSeat = function (user_id, seat, callback) {
  var passenger = _.find(this.passengers, (passenger) => {
    return passenger._id == user_id
  })

  if(passenger) {
      passenger.seat_order += seat
      this.available_seat -= seat
      this.save(callback)
  }
}

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

RideSchema.methods.isCollisionAppears = function({ start_time, is_repeat, repeat_days }) {
  const different = 10
  if(is_repeat) {
    let startTime = moment(this.start_time)
    let compareTime = moment(this.start_time)
    compareTime.hours(moment(start_time).hours())
    compareTime.minutes(moment(start_time).minutes())
    compareTime.seconds(0).seconds(0)
    compareTime.milliseconds(0).milliseconds(0)

    //console.log('startTime = ' + startTime.format('YYYY/MM/DD hh:mm'))
    //console.log('compareTime = ' + compareTime.format('YYYY/MM/DD hh:mm'))

    let isTimeCollision = compareTime.isSameOrAfter(moment(startTime).add(-different, 'minutes')) && moment(startTime).add(different, 'minutes').isSameOrAfter(compareTime)
    //console.log('isTimeCollision = ' + isTimeCollision)
    if(!isTimeCollision) return false

    let week = weekToDay(moment(this.start_time).weekday())
    //console.log('week = ' + week)
    let correct = _.findIndex(repeat_days, (day) => {
      return day == week
    })
    return correct != -1 
  } else {
    return moment(start_time).isSameOrAfter(moment(this.start_time).add(-different, 'minutes')) && moment(this.start_time).add(different, 'minutes').isSameOrAfter(moment(start_time))
  }
}

RideSchema.methods.closeSeatBy = function(seat, callback) {
  this.closed_seat += seat
  this.available_seat -= seat
  this.save(callback)
}

RideSchema.methods.addSeatBy = function(seat, callback) {
  this.closed_seat -= seat
  this.available_seat += seat
  this.save(callback)
}

RideSchema.methods.orderSeat = function(user, seat, callback) {
  this.passengers.push({
      _id: user._id,
      first_name: user.first_name,
      last_name: user.last_name,
      avatar_url: user.avatar_url,
      seat_order: seat,
      blocked_users: user.blocked_users,
  })
  this.save(callback)
}

module.exports = mongoose.model('Ride', RideSchema)
