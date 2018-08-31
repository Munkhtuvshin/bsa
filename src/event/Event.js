var mongoose = require('mongoose')
var _ = require('lodash')
var Schema = mongoose.Schema

var EventSchema = new Schema({  
  cover_url: String,
  title: String,
  description: String,  
  start_at: Date,
  finish_at: Date,
  event_start_at: Date,
  event_finish_at: Date,
  location: {
    latitude: Number,
    longitude: Number,
  },
})

module.exports = mongoose.model('Event', EventSchema)
