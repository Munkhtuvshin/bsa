var express = require('express')
var router = express.Router()

var Notification = require('./Notification')
var _ = require('lodash')

router.delete('/', isAuthenticated, function (req, res) {
    Notification.findOne({
        _id: req.query.notification_id,
    }, function(err, notification) {
        if(err) throw err

        notification.remove(function(err) {
            return res.status(200).send({
                code: 0,
                notification
            })
        })
    })
})

router.post('/mark-as-read', isAuthenticated, function (req, res) {
    //console.log(req.body)
    Notification.findOne({
      _id: req.body.notification_id,
    }, function(err, notification) {
        notification.is_read = true
        notification.save(function(err) {
            return res.status(200).send({
              code: 0,
              notification
            })
        })
    })
})

router.get('/', isAuthenticated, function (req, res) {
    Notification.paginate({
        user_id: req.user._id,
    }, { 
        page: req.query.page, 
        limit: 5,
        sort: {
            created_at: -1,
        }
    }, function(err, result) {
        

        res.status(200).send({
            code: 0,
            result
        })
      // result.docs
      // result.total
      // result.limit - 10
      // result.page - 3
      // result.pages
    })
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
