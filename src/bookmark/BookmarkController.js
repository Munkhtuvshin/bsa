var _ = require('lodash')
var express = require('express')
var Bookmark = require('./Bookmark')
var router = express.Router()
var User = require('../user/User')

router.get('/', isAuthenticated, function (req, res) {
     if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    Bookmark.find({
        user_id: req.user._id,
    }, function (err, bookmarks) {
        if(err) throw err
            User.findOne({
                 _id: req.user._id,
            }, function(err, user) {
                res.status(200).send({
                    code: 0,
                    bookmarks,
                    phone_verified: user.phone_verified,
                    terms_and_conditions: user.terms_and_conditions
                })
            })
        //console.log(bookmarks)
    })
})

router.delete('/', isAuthenticated, function (req, res) {
    Bookmark.findByIdAndRemove(req.query._id, function(err) {
        if(err) throw err

        return res.status(200).send({
            code: 0,
            message: 'Success'
        })
    })
})

router.post('/', isAuthenticated, function (req, res) {
    //console.log("DAMN IT")
    /*console.log({
        ...req.body,
        user_id: req.user._id,
    })*/
    console.log(req.body)

    Bookmark.findOne({
        user_id: req.user_id,
        'coordinate.latitude': req.body.coordinate.latitude,
        'coordinate.longitude': req.body.coordinate.longitude,
    }, function(err, bookmark) {
        if(err) throw err

        if(bookmark) {
            bookmark.name = req.body.name
            bookmark.save(function(err) {
                return res.status(200).send({
                    code: 0,
                    bookmark
                })
            })
        } else {
            Bookmark.create({
                ...req.body,
                user_id: req.user._id,
            }, function (err, bookmark) {
                if(err) throw err
                res.status(200).send({
                    code: 0,
                    bookmark
                })
            })
        }
    })
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
