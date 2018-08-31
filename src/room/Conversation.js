var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema

var ConversationSchema = new Schema({  
  room_id: String,
  createdAt: Date,
  text: String,
  user: {
  	_id: String,
    name: String,
    avatar: String,
  }
})

ConversationSchema.pre('save', function(next) {
    var RoomModel = mongoose.model('Room')
    var ChatModel = mongoose.model('Chat')
    var self = this
    RoomModel.findById(
        self.room_id, function(err, room) {

        if(room) {
          room.updated_at = new Date()
          room.users.forEach((user) => {
              user.deleted = false
          })
          
          room.save(function(err, row) {
              next()  
          })
        } else {
          ChatModel.findById(
             self.room_id, function(err, room) {
                if(room) {
                  room.updated_at = new Date()
                  room.users.forEach((user) => {
                      user.deleted = false
                  })
                  
                  room.save(function(err, row) {
                      next()  
                  })  
                } else {
                  next()
                }
             }
          )
        }
    })
})

ConversationSchema.plugin(mongoosePaginate)
mongoose.model('Conversation', ConversationSchema)

module.exports = mongoose.model('Conversation')