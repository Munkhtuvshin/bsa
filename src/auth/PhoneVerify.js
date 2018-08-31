var mongoose = require('mongoose')
var _ = require('lodash')
var Schema = mongoose.Schema

var PhoneVerifySchema = new Schema({  
  phone: {
    type: String,
    unique: true,
    required: true,
  },
  verification_code: Number,
  created_at: {
    type: Date,
    default: Date.now
  }
}, {
  collection: 'phone_verify'
})

PhoneVerifySchema.statics.updateVerification = function (phone, verification_code, callback) {
  return this.update({ 
    phone 
  }, { 
    verification_code
  }, { 
    upsert: true, 
    new: true 
  }, callback)
}


module.exports = mongoose.model('PhoneVerify', PhoneVerifySchema)
