var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema
var _ = require('lodash')

var ChatSchema = new Schema({  
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
    deleted: {
      type: Boolean,
      default: false,
    },
    deleted_at: {
      type: Date,
      default: null,
    }
  }],
})

ChatSchema.plugin(mongoosePaginate)
mongoose.model('Chat', ChatSchema)

module.exports = mongoose.model('Chat')