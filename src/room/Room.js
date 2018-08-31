var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema
var _ = require('lodash')


var RoomSchema = new Schema({  
  //title: String,
  ride_id: String,
  start_location: String,
  end_location: String,
  created_at: {
    type: Date,
    default: Date.now
  },
  updated_at: {
    type: Date,
    default: Date.now
  },
  users: [{
    _id: String,
    socket_id: String,
    first_name: String,
    last_name: String,
    avatar_url: String,
    is_driver: Boolean,
    deleted: {
      type: Boolean,
      default: false,
    },
    deleted_at: {
      type: Date,
      default: null,
    }
  }]
})

RoomSchema.statics.removeUser = function(ride_id, user, callback) {
  return this.update({ 
    ride_id,
  }, {
    $pull: {
        users: {
            _id: user._id,
        }
    }
  }, {
    multi: true
  }, callback)
}

RoomSchema.statics.addUser = function(ride_id, user, callback) {
  return this.findOne({  
      ride_id,
  }, function(err, room) {
      room.users.push({
          _id: user._id,
          //socket_id: socket.id,
          first_name: user.first_name,
          last_name: user.last_name,
          avatar_url: user.avatar_url,
          is_driver: false,    
      })
      room.save(callback)
  })
}

/*RoomSchema.methods.addUser = function(socket, callback) {
  var user = socket.request.session.user
  var conn = { 
    _id: user._id,
    socket_id: socket.id,
    first_name: user.first_name,
    last_name: user.last_name,
    avatar_url: user.avatar_url,
    is_driver: false,
  }

  this.users.push(conn)
  this.save(callback)
}*/

RoomSchema.plugin(mongoosePaginate)
mongoose.model('Room', RoomSchema)

module.exports = mongoose.model('Room')