var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var _ = require('lodash')
var Schema = mongoose.Schema

var SearchHistorySchema = new Schema({  
  user_id: {
      type: String,
  },
  from_distination_filled: {
      type: Boolean,
      default: false,
  },
  to_distination_filled: {
      type: Boolean,
      default: false,
  },
  from_distination: {
  	place_name: String,
  	coordinate: {
        type: [Number],
        required: false,
        index: "2dsphere"
    }
  },
  to_distination: {
  	place_name: String,
  	coordinate: {
        type: [Number],
        required: false,
        index: "2dsphere"
    }
  },
  result: Number,
  created_at: {
    type: Date,
    default: new Date(),
  },
}, {
  collection: 'search_history'
})

SearchHistorySchema.plugin(mongoosePaginate)
module.exports = mongoose.model('SearchHistory', SearchHistorySchema)
