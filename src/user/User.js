var mongoose = require('mongoose')
var Schema = mongoose.Schema
var _ = require('lodash')
var bcrypt = require('bcrypt')

var UserSchema = new Schema({  
  first_name: String,
  last_name: String,
  avatar_url: String,
  email: String,
  description: String,
  birthday: Date,
  phone: String,
  gender: String,
  password: String,
  direct_login: {
    type: Boolean,
    default: false,
  },
  facebook_connection: {
  	 id: String,
  	 access_token: String,	 
  	 is_connected: Boolean,
  },
  cars: [{ type: String, }],
  blocked_users: [{ type: String }],
  active_rides: [{ type: String, }],
  history_rides: [{ type: String, }],
  intercity_rides: [{ type: String, }],
  rooms: [{ 
    _id: {
      type: String,
    },
    ride_id: {
      type: String,
    },
  }],
  private_connections: [{
    type: String,
  }],
  fcm_token: String,
  active_rides: [{ type: String, }],
  last_read_message: {
    type: String,
    default: new Date(),
  },
  last_read_notification: {
    type: String,
    default: new Date(),
  },
  phone_verified: {
    type: Boolean,
    default: false
  },
  terms_and_conditions: {
    type: Boolean,
    default: false
  },
  delete_account: {
    type: Boolean,
    default: false
  },
  created_at: {
    type: Date,
    default: Date.now
  },
  created_by: String,
  
}, {
  usePushEach: true
})

UserSchema.methods.generateHash = function(password, callback) {
  bcrypt.genSalt(10, function(err, salt) {
    if (err) 
      return callback(err)

    bcrypt.hash(password, salt, function(err, hash) {
      return callback(err, hash)
    })
  })
}

UserSchema.methods.compareHash = function(password, callback) {
  return bcrypt.compareSync(password, this.password)
} 

UserSchema.methods.addActiveRide = function(room_id, ride_id, callback) {
  this.active_rides.push(ride_id)
  this.rooms.push({
    _id: room_id,
    ride_id,
  })
  this.save(callback)
}

UserSchema.methods.addintercityRide = function(ride_id, callback) {
  this.intercity_rides.push(ride_id)

  this.save(callback)
}

module.exports = mongoose.model('User', UserSchema)