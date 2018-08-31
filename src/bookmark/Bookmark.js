var mongoose = require('mongoose')
var _ = require('lodash')
var Schema = mongoose.Schema

var BookmarkSchema = new Schema({  
  user_id: String,
  name: String,
  place_name: String,
  coordinate: {
    latitude: Number,
    longitude: Number,
  },
})

BookmarkSchema.methods.isAvailableForOrder = function(seat) {
  var totalSeatOffer = 0
  _.forEach(this.passengers, (passenger) => {
      totalSeatOffer += passenger.seat_order
  })

  if(totalSeatOffer + seat <= this.available_seat)
      return true

  return false
}

module.exports = mongoose.model('Bookmark', BookmarkSchema)
