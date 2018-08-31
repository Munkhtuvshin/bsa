var FacebookStrategy = require('passport-facebook').Strategy
var JwtStrategy = require('passport-jwt').Strategy
var ExtractJwt = require('passport-jwt').ExtractJwt
var env = require('./env')
var User = require('./user/User')

module.exports = function(passport) {

	passport.serializeUser(function(user, done) {
        done(null, user.id)
    })

    passport.deserializeUser(function(id, done) {
        User.findById(id, function(err, user) {
            done(err, user)
        })
    })

    var opts = {};
    opts.jwtFromRequest = ExtractJwt.fromAuthHeader()
    opts.secretOrKey = 'secret'
    passport.use(new JwtStrategy(opts,
        function(jwt_payload, done) {
          
        /*var query = { }*/
        /*query['_id'] = jwt_payload.id;*/
        User.findOne({}, function(err, users) {
              if (err) {
                  return done(err, false);
              }

              if (users) {
                
                  done(null, users[0])
              } else {
                  done(null, false)
              }
        })
    }))

    passport.use(new FacebookStrategy({
        clientID: env.facebookAuth.clientId,
        clientSecret: env.facebookAuth.clientSecret,
        callbackURL: env.facebookAuth.callbackUrl,
        profileFields: ['id', 'displayName', 'photos', 'email', 'gender', 'first_name', 'last_name', 'birthday'],
        passReqToCallback : true
    },
    function(req, token, refreshToken, profile, done) {
        /*if (req.isAuthenticated()){
            User.findOne({ _id : req.user._id }, function(err, user) {
                if (err) return done(err);
                else if (user) {
                    user.facebook_connection = {
                        id: profile.id,
                        access_token: token
                    };

                    user.save(function(err) {
                        if (err) throw err;
                        return done(null, user);
                    })
                }
            })
        } else {*/

            User.findOne({ 'facebook_connection.id' : profile.id }, function(err, user) {
                if (err)  return done(err);
                
                if (user) {
                    return done(null, user);
                } else {
                    var newUser = new User()
					newUser.first_name = profile.name.givenName
					newUser.last_name = profile.name.familyName
                    newUser.avatar_url = profile.photos.length > 0 ? profile.photos[0].value: ""
                    newUser.email = profile.emails.length > 0 ? profile.emails[0].value : "";
                    newUser.gender = profile.gender
                    newUser.facebook_connection = {
                    	is_connected: true,
                    	access_token: token,
                    	id: profile.id,
                    }


                    newUser.save(function(err) {
                        if (err) throw err
                        return done(null, newUser)
                    })
                }
            })
        /*}*/
    }))
}