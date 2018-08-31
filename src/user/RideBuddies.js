var mongoose = require('mongoose')
var Schema = mongoose.Schema

var BuddiesSchema = new Schema({  
  first_name: String,
  last_name: String,
  user_id: String,
  //buddies: [{ type: String, ref: 'Buddy' }],
  buddies: [{ type: String, }],
}, {
	collection: 'ride_buddies'
})

mongoose.model('RideBuddies', BuddiesSchema)

module.exports = mongoose.model('RideBuddies')