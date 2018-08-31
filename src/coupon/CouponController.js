var _ = require('lodash')
var express = require('express')
var router = express.Router()
var Coupon = require('./Coupon')
var jwt = require('jwt-simple')
var User = require('../user/User')
var Notification = require('../notification/Notification')
var sleep = require('sleep')

import {
    newCouponForOldUsers,
    getMassCoupons
} from './CouponApi'

router.get('/mass-pushnotification', function(req, res) {
    // _id: {
    //         $in: ['5a3b8187cc532a79954c4521', '5b3987f1894d3f2ea6519e0d']
    //     }
    User.find({
        _id: {
            $in: ['5b3987f1894d3f2ea6519e0d']
        }
    }, function(err, users) {
        var existing_users = []
        var counter = 0

        let coupons = [{
          template_id: 'BT0002',
          count: users.length,
        }]

        let couponsInstances = []
        let notificationInstances = []

        //console.log(users);

        // return res.json({
        //     code: 0,
        //     users_lenght: users.length
        // })

        getMassCoupons(coupons, function(err, response) {
            if(err) throw err
            
            let coupons = response.result['BT0002'].coupons
            console.log('total coupon = ' + coupons.length)
            let template = response.result['BT0002'].template
            //console.log(coupons)

            if(response.result['BT0002'] = null) 
                return res.json({
                    code: 1,
                    message: 'Coupon template not found'
                })

            if(users.length > coupons.length) 
                return res.json({
                    code: 1,
                    message: 'There is coupon count is wrong.'
                })

            users.forEach((user, i) => {
                let coupon = coupons[i]
                couponsInstances.push({
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
                        push_notification_sented: true,
                    } 
                })

                notificationInstances.push({
                    type: 'COUPON',
                    message: template.short_description,
                    user_id: user._id,
                    data: {},
                    icon: template.cover_url,
                })
            })

            Coupon.insertMany(couponsInstances, function (err) {
                if(err) throw err
                Notification.insertMany(notificationInstances, function (err) {
                    if(err) throw err
                    return res.json({
                        code: 0,
                        message: 'successfully sent.'
                    })
                })
            })            
        })
    })
})

router.get('/get-coupon', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({ code: 1 })    
    }

    Coupon.find({
        'coupon_data.user_id': {
            $in: req.user._id
        },
        'coupon_data.redeemed_at': null
    },function (err, coupons) {
        if(err) return res.status(200).send({ code: 1, err})

        return res.status(200).send({
            code: 0,
            coupons
        }) 
    })
})
// coupon-redeemed
router.get('/coupon-status-changed', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({ code: 1 })    
    }

    let promo_code = "T14DM"
    let redeemed_at = new Date()
    
    Coupon.findOneAndUpdate({
        'coupon_data.promo_code': promo_code,
        'coupon_data.redeemed_at': null
    },{
        "coupon_data.redeemed_at": redeemed_at
    }, function (err, coupons) {
        if(err) return res.status(200).send({ code: 1, err})
        console.log(coupons)
        return res.status(200).send({
            code: 0,
            coupons: []
        }) 
    })
})

router.post('/change-type-coupon', function(req, res) {
    try {
        let token = req.headers.authorization
        // Token buruu ued catch - ruu orno
        var coupon_token = jwt.decode(token, "coupon key_secret beeco")

        let coupon = {
            "id" : 'coupon id',
            "type": "json",
            "key": "beeco coupon"
        }

        var beeco_token = jwt.encode(coupon, "coupon key_secret beeco")
        
        if( beeco_token != token ) {
            console.log('header token buruu bn')    
            return res.status(404).send({
                code: 0,
                message: "алдаа гарлаа"
            })
        }

        let body_key = "coupon data_key_secret beeco"
        let data = req.body.coupons
        let coupon_data = jwt.decode(data, body_key)
        let coupon_data_obj = JSON.parse(coupon_data)
        updateCoupon(coupon_data_obj, res)
        
    } catch (err) { // Also tried JwtException
        console.log(err)
        return res.status(404).send({
            code: 0,
            message: "алдаа гарлаа"
        })
    }
})

function updateCoupon(coupon_data_obj, res) {

    let couponCode = []
    coupon_data_obj.map((coupon) => {
        couponCode.push(coupon.promo_code)
    })
    console.log("Coupons ==> " + couponCode.length)
  
    if(couponCode.length == 0){
        return res.status(200).send({
            code: 0,
            message: "Амжилттай"
        }) 
    }

    Coupon.update({
        'coupon_data.promo_code': {
            $in: couponCode
        }
    },{
        $set: {
            'coupon_data.redeemed_at': new Date()
        }
    }, { 
        upsert: true,
        new: true
    }, function (err, result_coupons) {
        if(err) return res.status(200).send({ code: 1, err})

        return res.status(200).send({
            code: 0,
            message: "Амжилттай"
        }) 
    })
}

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router