var _ = require('lodash')
var express = require('express')
var Config = require('./Config')
var router = express.Router()

router.get('/', isAuthenticated, function (req, res) {
    Config.find({}, function (err, configs) {
        if(err) throw err
        //console.log(bookmarks)
        res.status(200).send({
            code: 0,
            configs
        })
    })
})

router.post('/set', isAuthenticated, function (req, res) {
    let { key, value } = req.body
    Config.update({
        key
    }, {
        value
    }, {
        upsert: true
    }, function(err, config) {
        res.status(200).send({
            code: 0,
            config
        })
    })
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
