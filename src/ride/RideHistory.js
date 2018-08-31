var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var _ = require('lodash')
var Schema = mongoose.Schema

var RideHistorySchema = new Schema({  
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
  driver: {
    _id: { type: String },
    avatar_url: String,
    first_name: String,
    last_name: String,
    is_feedback_recieved: {
      type: Boolean,
      default: false,
    },
    rating: Number,
    ride_count: Number,
    car: {
      car_avatar_url: String,
      plateNumber: String,
      plateText: String,
    }
  },
  passengers: [{
    _id: String,
    first_name: String,
    last_name: String,
    avatar_url: String,
    seat_order: Number,
    blocked_users: [String],
    dirty: {
      type: Boolean,
      default: true,
    },
    is_give_feedback: {
      type: Boolean,
      default: false,
    },
    feedback: {
        rating: Number,
        is_ride_going: {
          type: Boolean,
          default: true,
        },
        reason: {
          type: {
             type: Number,
             default: 0,
          },
          description: {
            type: String,
          }
        },
        created_at: {
          type: Date,
          default: new Date()
        }
    }
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
    default: new Date(),
  },
}, {
  collection: 'ride_history'
})

RideHistorySchema.plugin(mongoosePaginate)
module.exports = mongoose.model('RideHistory', RideHistorySchema)
