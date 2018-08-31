var express = require('express')
var router = express.Router()
var _ = require('lodash')
var multer = require('multer')
var upload = multer({ dest: 'public/avatar/' })
var upload2 = multer({ dest: 'public/car/' })
import { copyPhoto, copyCarPhoto } from './PhotoCopy' 
import { googleCloud, googleCloudBuffer } from './GoogleCloud' 

var key 

var upload = multer({ 
    storage: 
      multer.diskStorage({
        destination: function (req, file, cb) {
          cb(null, 'public/avatar/')
        },
        filename: function (req, file, cb) {
          key = req.user._id + '-' + Date.now() + Math.floor(Math.random() * 8999)
          cb(null, file.fieldname + '-' +  key + '-720.jpg')
        }
      }) 
})

var upload2 = multer({ 
    storage: 
      multer.diskStorage({
        destination: function (req, file, cb) {
          cb(null, 'public/car/')
        },
        filename: function (req, file, cb) {
          key = req.user._id + '-' + Date.now() + Math.floor(Math.random() * 8999)
          cb(null, file.fieldname + '-' +  key + '-720.jpg')
        }
      }) 
})

router.post('/', isAuthenticated, function (req, res, next ) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }
        
    var uploadAvatarImage = multer({ 
      storage: multer.memoryStorage()
    }).single('avatar')

    uploadAvatarImage(req, res, function(err) {
        var buffer = req.file.buffer
        console.log(buffer)
        key = req.user._id + '-' + Date.now() + Math.floor(Math.random() * 8999)
        copyPhoto({buffer: buffer, key, name: 'avatar', bucketName: 'beeco-avatar'}, function(response){
          return res.status(200).send(response)
        })
    })
})

router.post('/car', isAuthenticated, function (req, res, next ) {
  if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    var uploadCarImage = multer({ 
      storage: multer.memoryStorage()
    }).single('car')
    
    uploadCarImage(req, res, function(err) {
        var buffer = req.file.buffer
        key = req.user._id + '-' + Date.now() + Math.floor(Math.random() * 8999)
        copyCarPhoto({buffer: buffer, key, name: 'avatar', bucketName: 'beeco-car'}, function(response){
          return res.status(200).send(response)
        })

    })
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
