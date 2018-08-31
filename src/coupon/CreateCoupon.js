var Coupon = require('./Coupon')

exports.couponCreate = function(req, callback) {
	create(req, callback)
}

exports.createCoupons = function(req, callback) {
	const {
		result,
		user,
		achievement
	} = req

    let coupons = []
    for (var property in result) {
      if (result.hasOwnProperty(property)) {
          coupons.concat(result[property].coupons)
          let template = result[property].template
          result[property].coupons.forEach((coupon) => {
          	  coupons.push({
          	    coupon_data: {
					user_id: user._id,
					coupon_id: coupon.id,
					is_simple: template.is_simple,
					has_middle_image: template.has_middle_image,
					has_value: template.has_value,
					has_footer: template.has_footer,
				    short_description: template.short_description,
				    long_description: template.long_description,
				    promo_code: coupon.promo_code,
				    expired_at: coupon.expired_at.date,
				    cover_url: template.cover_url,
				    middle_image_url: template.middle_image_url,
				    title: template.title,
				    value: template.value,
				    redeemed_at: null,
				    push_notification_sented: false,
				} 	
          	  })
          })
      }
    }

    Coupon.insertMany(coupons, function (err, newCoupons) {
        if (err) console.log(err)
        return callback({
          coupons: newCoupons
        })
    })
}

function create( req, callback) {

    var newUser = {
		coupon_data: {
			user_id: req.user._id,
			coupon_id: req.data.coupon.id,
		    short_description: req.data.template.short_description,
		    long_description: req.data.template.long_description,
		    promo_code: req.data.coupon.promo_code,
		    expired_at: req.data.coupon.expired_at.date,
		    cover_url: req.data.template.cover_url,
		    title: req.data.template.title,
		    value: req.data.template.value,
		    redeemed_at: null,
		    push_notification_sented: req.achievement == 'Signup' ? false : true
		}  
    }

    Coupon.create(newUser, function (err, coupons) {
        if (err) { console.log(err) }
     //   console.log(coupons)
        return callback({
          coupons: coupons
        })
    })
}
// import { couponCreate } from '../coupon/CreateCoupon' 
// couponCreate({data: "data", user: req.user }, function(response){
//       console.log('butslaa')
//   })