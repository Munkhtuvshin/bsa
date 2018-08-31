var mongoose = require('mongoose')
var mongoosePaginate = require('mongoose-paginate')
var Schema = mongoose.Schema

var CouponSchema = new Schema({  

  coupon_data: {
      user_id: {
        type: mongoose.Schema.Types.ObjectId,
        ref: 'User'
      },
      coupon_id: String,
      is_simple: {
        type: Boolean,
        default: false,
      },
      has_middle_image: {
        type: Boolean,
        default: true,
      },
      has_value: {
        type: Boolean,
        default: true,
      },
      has_footer: {
        type: Boolean,
        default: true,
      },
      short_description: String,
      long_description: String,
      promo_code: {
          type: String,
      },
      expired_at: String,
      cover_url: String,
      middle_image_url: String,
      value: String,
      title: String,
      redeemed_at: String,
      push_notification_sented: {
          type: Boolean,
          default: true,
      },
  }  
}, {
  collection: 'coupons'
})

CouponSchema.statics.isPushNotificationNotSented = function(user, callback) {
    this.find({
        'coupon_data.user_id': user._id,
        'coupon_data.push_notification_sented': false,
    }, function(err, coupons) {
        callback(coupons)
    })
}

CouponSchema.plugin(mongoosePaginate)
module.exports = mongoose.model('coupons', CouponSchema)

