var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema
var _ = require('lodash')

var RideSchema = new Schema({  
  
  driver: {
  	_id: { type: String },
    avatar_url: String,
    first_name: String,
    last_name: String,
  },
  from : String,
  to : String,
  text : String,
  price : Number,
  phoneNumber : Number,
  time : String,
  //day : String, 
  day: {
    type: Date,
    default: Date.now
  },
  created_at: {
    type: Date,
    default: Date.now
  }
})


RideSchema.plugin(mongoosePaginate)
var IntercityRides = module.exports = mongoose.model('intercityRides', RideSchema)

module.exports = mongoose.model('intercityRides')

module.exports.postDelete = (id, callback)=>{
	IntercityRides.remove({'_id':id.id}, callback);  // delete
}

module.exports.getFilterRides = (data, callback)=>{

  var query = {from: data.from, to: data.to, day: { $gte: data.date } }

  IntercityRides.paginate(
          query,
          {
            limit: 5,
            page: data.page,
            sort: { day: 1, time: 1 }
          },
          callback
      )
}

// total
// docs
// pages