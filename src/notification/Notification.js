var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var _ = require('lodash')
var Schema = mongoose.Schema

var NotificationSchema = new Schema({  
  user_id: String,
  type: String,
  data: {},
  message: String,
  icon: String,
  created_at: {
    type: Date,
    default: Date.now
  },
  is_read: {
    type: Boolean,
    default: false,
  },
})

NotificationSchema.methods.markAsRead = function(callback) {
  this.is_read = true
  this.save(callback)
}

NotificationSchema.plugin(mongoosePaginate)
module.exports = mongoose.model('Notification', NotificationSchema)
