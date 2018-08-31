var _ = require('lodash')
var express = require('express')
var router = express.Router()
var Car = require('./Car')
var User = require('../user/User')

router.get('/get-car', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({ code: 1 })    
    }
 
    Car.find({
        '_id': {
                $in: req.user.cars
            }
    },function (err, cars) {
        if(err) return res.status(200).send({ code: 1, err})
        //    console.log(cars)
        return res.status(200).send({
            code: 0,
            cars
        }) 
    })
})

router.get('/delete-car', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    var user = req.user
    user.cars.pull(req.query.id)
    user.save(function(err){
        if(err) return  {
            code: 1,
            message: err,
        }
        
        Car.find({
            '_id': {
                $in: req.user.cars
            }
        },function (err, cars) {
            if(err) return res.status(200).send({ code: 1, err})
            return res.status(200).send({
                code: 0,
                cars
            }) 
        })
    })
})

router.post('/add-car', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    //console.log(req.body)
    let car = {}

    if(req.body.carData.data){
        car = JSON.parse(req.body.carData.data)
    }
    
    let newCar = {
       user_id : req.user._id,
       car_avatar_url: (car.imageUrl) 
                        ? car.imageUrl
                        : "car-default-image-",
       plateNumber: req.body.plateNumber,
       plateTextIndex: req.body.plateTextIndex,
       plateText: req.body.plateText
    }

    Car.create(newCar, function (err, car) {
        var user = req.user
        user.cars.push(car._id)
        user.save(function(err) {
            if(err) return  {
                code: 1,
                message: err,
            }
            
            Car.find({
                '_id': {
                    $in: req.user.cars
                }
            },function (err, cars) {
                if(err) return res.status(200).send({ code: 1, err})

                return res.status(200).send({
                    code: 0,
                    cars
                }) 
            })
        }) 
    })
})

router.post('/update-car', isAuthenticated, function(req, res) {
    if(!req.isAuthenticated()) {
        return res.status(200).send({
            code: 1,
        })    
    }

    let car = {}
  //  console.log(req.body)
    if(req.body.carData.data){
        car = JSON.parse(req.body.carData.data)
    }
    
    let docCar = {
       user_id : req.user._id,
       car_avatar_url: (req.body.photoChange) 
                     ? car.imageUrl
                     : req.body.imageData,
       plateNumber: req.body.plateNumber,
       plateTextIndex: req.body.plateTextIndex,
       plateText: req.body.plateText
    }

    Car.findOneAndUpdate({_id: req.body._id}, 
        docCar, function (err, car) {
        if(err) return  { code: 1, message: err }

        Car.find({
            '_id': {
                $in: req.user.cars
            }
        },function (err, cars) {
            if(err) return res.status(200).send({ code: 1, err})

            return res.status(200).send({
                code: 0,
                cars
            }) 
        })
    })
    
})

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
