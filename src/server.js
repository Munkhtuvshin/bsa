var app = require('./app')
var express = require('express')
var server = require('http').Server(app)
var session = require('express-session')
var bodyParser = require('body-parser')
var redis = require('redis')

var io = require('socket.io')(server, {
  pingInterval: 10000,
  pingTimeout: 1000,
})

const adapter = require('socket.io-redis')

const redisClient = redis.createClient(
  process.env.REDIS_PORT || '6379',
  process.env.REDIS_HOST || '127.0.0.1',
  {
    auth_pass: process.env.REDIS_PASS,
    return_buffers: true
  }
).on('error', (err) => console.error('ERR:REDIS:', err))

const redisUri = {
    host: process.env.REDIS_HOST || '127.0.0.1', 
    port: process.env.REDIS_PORT || '6379',
    pass: process.env.REDIS_PASS,
}

redisClient.on('connect', function () {
    console.log('Connected to Redis')
})

io.adapter(adapter(redisUri))

var passport = require('passport')
var RedisStore = require('connect-redis')(session)
var User = require('./user/User')
var jwt = require('jwt-simple')
var JwtStrategy = require('passport-jwt').Strategy
var ExtractJwt = require('passport-jwt').ExtractJwt

app.use(passport.initialize())

var sessionMiddleware = session({
    store: new RedisStore(redisUri),
    secret: 'beecosecretkey',
    resave: true,
    saveUninitialized: true,
    cookie: {
        secure: false
    },
})

app.use(sessionMiddleware)

io.use(function(socket, next) {
    sessionMiddleware(socket.request, socket.request.res, next)
})

var verifyFacebookToken = function(req, res, next) {
    //req.session.user
    //console.log(req.session.key)
    /*if(req.session.key === String(req.headers.authorization.split(" ")[1])) {
        req.isAuthenticated = function() { return true }            
        req.user = req.session.user
    }*/
    //console.log(req.headers.authorization)
    
    User.findOne({
        'facebook_connection.access_token': String(req.headers.authorization.split(" ")[1])
    }, (err, user) => {
        if(user) {

            req.user = user
            req.session.key = req.headers.authorization.split(" ")[1]
            req.session.user = user
            req.isAuthenticated = function() { return true }            
        }

        return next()    
    })
}

var tokenVerifier = function (req, res, next) {
    req.isAuthenticated = function() { return false }
    req.verifyTokenIfAny = function (req, res, next) {
        req.isAuthenticated = function() { return false }
        //console.log('Token checker')
        if(req.headers.authorization) {
            if (req.headers.authorization.indexOf("FACEBOOK") !== -1) {
                verifyFacebookToken(req, res, next)
            } else {
                var decoded = jwt.decode(req.headers.authorization, "beecosecretkey")
                //console.log(decoded)
                if(decoded) {
                    User.findOne({
                        '_id': decoded._id,
                    }, (err, user) => {
                        if(user) {
                            req.user = user
                            //req.session.key = req.headers.authorization
                            req.session.user = user
                            //console.log('session approved = ' + req.user.first_name)
                            req.isAuthenticated = function() { return true }            
                            return next()
                        } else {
                            return res.status(403).send({ 
                                code: 403, 
                                message: 'Wrong token.', 
                            })        
                        }
                    })
                } else {
                    return res.status(403).send({ 
                        code: 403, 
                        message: 'No token provided.', 
                    })    
                }
            }
        } else {
            return next()
        }
    }
    
    //console.log('test')
    return next()
}

app.use(tokenVerifier)
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: false }))
app.use(express.static("public"))

require('./socket')(app, io)
require('./passport')(passport)
require('./auth/AuthController.js')(app, passport, io)

app.use(function (req, res, next) {

    // Website you wish to allow to connect
    res.setHeader('Access-Control-Allow-Origin', 'http://localhost:3000');

    // Request methods you wish to allow
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');

    // Request headers you wish to allow
    res.setHeader('Access-Control-Allow-Headers', 'X-Requested-With,content-type');

    // Set to true if you need the website to include cookies in the requests sent
    // to the API (e.g. in case you use sessions)
    res.setHeader('Access-Control-Allow-Credentials', true);

    // Pass to next layer of middleware
    next();
});

app.use('/admin', require('./admin/AdminController'))
app.use('/api', require('./admin/WebController'))
app.use('/ride', require('./ride/RideController'))
app.use('/notify', require('./ride/NotifyController'))
app.use('/search', require('./search/SearchController'))
app.use('/user', require('./user/UserController'))
app.use('/intercityRide', require('./intercityRide/intercityRideController'))
app.use('/dashboard', require('./dashboard/dashboardController'))
app.use('/notification', require('./notification/NotificationController'))
app.use('/photo', require('./photos/Photos'))
app.use('/car', require('./car/CarController'))
app.use('/event', require('./event/EventController'))
app.use('/bookmark', require('./bookmark/BookmarkController'))
app.use('/notification', require('./notification/NotificationController'))
app.use('/config', require('./config/ConfigController'))
app.use('/facebook', require('./share/FacebookShare'))
app.use('/coupon', require('./coupon/CouponController'))

//require('./agenda')(app)

var port = process.env.PORT || 3000

server.listen(port, function() {
  console.log('Express server listening on port ' + port)
})

