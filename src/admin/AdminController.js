var _ = require('lodash')
var path = require("path")
var express = require('express')
var mongoose = require('mongoose')
var router = express.Router()

var User = require('../user/User')
var Ride = require('../ride/Ride')
var RideHistory = require('../ride/RideHistory')

// * solison
router.get('*', function(req, res) {
    res.sendFile(path.join(__dirname, '../../public', '/index.html'));
})

module.exports = router
