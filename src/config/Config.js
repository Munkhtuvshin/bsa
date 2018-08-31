var mongoose = require('mongoose')
var _ = require('lodash')
var Schema = mongoose.Schema

var ConfigSchema = new Schema({  
  key: {
    type: String,
    unique: true,
    required: true,
  },
  value: {},
  adjustment: [{
    user_id: {
      type: String,
      ref: 'User'
    },
    modified_at: {
      type: String,
      default: Date.now
    }, 
    old_value: {}
  }]
})

module.exports = mongoose.model('Config', ConfigSchema)
