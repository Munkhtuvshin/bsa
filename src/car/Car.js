var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema

var CarSchema = new Schema({  
  user_id: String,
  car_avatar_url: String,
  filename: String,
  path: String,
  plateNumber: Object,
  plateTextIndex: Object,
  plateText: Object,
  redirects: String,
}, {
	collection: 'cars'
})

CarSchema.plugin(mongoosePaginate)
module.exports = mongoose.model('cars', CarSchema)

