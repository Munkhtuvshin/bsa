var mongoose = require('mongoose')
var _ = require('lodash')
var Schema = mongoose.Schema

var BeecoPoiSchema = new Schema({  
  type: String,
  coordinate: {
        type: [Number],
        required: true,
        index: "2dsphere"
  },
  area_id: String,
  display_name: String,
  variatians: [{
    type: String,
  }],
  zoom_lvl: Number,
  poi_flag: Number,
  show_flag: Number,
  search_flag: Number,
}, {
  collection: 'beeco_poi'
})

module.exports = mongoose.model('BeecoPoi', BeecoPoiSchema)
