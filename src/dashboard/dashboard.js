var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema

var DashboardSchema = new Schema({  
  
  user_id: String,
  fb_id: String,
  name: String,
  first_name: String,
  avatar_url: String,
  travel: {
    ration: Number,
    costumer_label: String,
    asDriver: {
      rating: Number,
      rating_count: Number,
      travel_count: Number,
      total_distance: Number,
      income: Number,
    },
    asPassenger: { 
      travel_count: Number,
      total_distance: Number,
      total_cost: Number,
    }
  }
}, {
  collection: 'user_info'
})

DashboardSchema.plugin(mongoosePaginate)
module.exports = mongoose.model('Userinfo', DashboardSchema)

