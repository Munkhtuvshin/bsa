var Conversation = require('./room/Conversation')
var Room = require('./room/Room')
var Chat = require('./room/Chat')
var Ride = require('./ride/Ride')
var RepeatedRide = require('./ride/RepeatedRide')
var RideHistory = require('./ride/RideHistory')
var Notify = require('./ride/Notify')
var User = require('./user/User')
var Coupon = require('./coupon/Coupon')
var Notification = require('./notification/Notification')
var Presence = require('./presence')
var Agenda = require('agenda')
var Agendash = require('agendash')
var moment = require('moment')
var _ = require('lodash')
var admin = require("firebase-admin")
var jwt = require('jsonwebtoken')
var globalIo = null
var mongoConnectionString = 'mongodb://' + process.env.DB_USER + ":" + process.env.DB_PASS + "@" + process.env.DB_HOST
//var mongoConnectionString = 'mongodb://localhost/beeco'
var serviceAccount = require("../beeco-156f5-firebase-adminsdk-rlduo-7b0487c3b6.json")

const translation = {
	title: "beeco - Замын унаа апп",
}

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: process.env.FB_HOST
})

//RIDE
function onRideDeleted(ride, passengers) {
	var userIds = passengers.map(function(passenger) {
		return passenger._id
	})

	createNotificationForUsers(ride, passengers)

	User.find({
		_id: {
			$in: userIds
		}
	}, 'fcm_token', function(err, users) {
		var registrationTokens = users.map(function(user) {
			return user.fcm_token
		})

		var payload = {
		  	data: {
			    badge: "0",
			    custom_notification: JSON.stringify({
			      	title: translation.title,
			    	body: ride.driver.last_name.substring(0, 1) +". " + ride.driver.first_name + " " + ride.driver.first_name + " " +ride.end_location.place_name + 
			    	" явах унаагаа цуцаллаа. Та өөр унаа хайна уу.",
			    	"sound": "default",
			    	color: "#e0622e",
			    	priority: "high",
			    	icon: "ic_launcher",
			    	large_icon: ride.driver.avatar_url
			    })
			}
		}

		var options = {
		  priority: "high",
		}

		if(registrationTokens.length > 0) {
			admin.messaging().sendToDevice(registrationTokens, payload, options)
				 .then(function(response) {
				    //console.log(response);
				 })
				 .catch(function(error) {
				   	//console.log(error);
				 })
		}
	})
}

function onRideToggleSeat(ride) {
	_.forEach(ride.passengers, (passenger, i) => {
		sendLocalNotification(passenger._id, 'ride edited', ride)
	})

	sendLocalNotification(ride.driver._id, 'ride edited', ride)
}

function onRideJoined(ride, seat, user) {
	//console.log(user)
	if(user) {
		Notification.create({
			type: 'JOINS_YOUR_RIDE',
			message: user.last_name.substring(0,1) + ". "+ user.first_name + " " + seat + " суудал захиаллаа.",
			user_id: ride.driver._id,
			data: {
				ride: {
					_id: ride._id,
					start_time: ride.start_time,
					available_seat: ride.available_seat,
				},
				passenger: {
					_id: user._id,
					first_name: user.first_name,
					last_name: user.last_name,
					avatar_url: user.avatar_url,
					seat_order: seat,
					blocked_users: [],
				},
			}
		}, function(err, notification) {
			sendLocalNotification(ride.driver._id, 'passenger joined', {
    			...notification.toObject(),
    			phone: user.phone
	    	}, function(res) {
	    		if(res.code != 0) {
	    			sendRemoteNotification(ride.driver._id, {
						title: translation.title,
		 				body: user.last_name.substring(0,1) + ". "+ user.first_name + " " + seat + ' суудал захиаллаа.',
		  				large_icon: user.avatar_url
					}, { priority: "high" })

					sendRemoteNotificationToIOS(ride.driver._id, {
						title: translation.title,
		 				body: user.last_name.substring(0,1) + ". "+ user.first_name + " " + seat + ' суудал захиаллаа.',
		  				large_icon: user.avatar_url
					}, { priority: "high" })
	    		}
			})
		})
	}
}

function onRideCancel(ride, user) {	
	//console.log(user)
	Notification.create({
		type: 'LEFT_YOUR_RIDE',
		message: user.last_name.substring(0,1) + ". "+ user.first_name + "  унаагаа цуцаллаа.",
		user_id: ride.driver._id,
		data: {
			ride: {
				_id: ride._id,
				start_time: ride.start_time,
				available_seat: ride.available_seat,
			},
			passenger: {
				_id: user._id,
				first_name: user.first_name,
				last_name: user.last_name,
				avatar_url: user.avatar_url,
			},
		}
	}, function(err, notification) {
   		sendLocalNotification(ride.driver._id, 'passenger cancel', notification, function(res) {
   			if(res.code != 0) {
   				sendRemoteNotification(ride.driver._id, {
					title: translation.title,
					body: user.last_name.substring(0,1) + ". "+ user.first_name + "  унаагаа цуцаллаа.",
					large_icon: user.avatar_url
				}, { priority: "high" })

	   			sendRemoteNotificationToIOS(ride.driver._id, {
					title: translation.title,
					body: user.last_name.substring(0,1) + ". "+ user.first_name + "  унаагаа цуцаллаа.",
					large_icon: user.avatar_url
				}, { priority: "high" })
   			}
   		})
	})
}

function createNotificationForUsers(ride, passengers) {
	passengers.forEach(function(passenger, i) {
		Notification.create({
			type: 'YOUR_RIDE_DELETED',
			message: ride.start_location.place_name + " - "+ ride.end_location.place_name + " явах унаагаа цуцаллаа. Та өөр унаа хайна уу.",
			user_id: passenger._id,
			data: {
				ride: {
					_id: ride._id,
					start_time: ride.start_time,
				},
				driver: {
					_id: ride.driver._id,
					first_name: ride.driver.first_name,
					last_name: ride.driver.last_name,
					avatar_url: ride.driver.avatar_url,
				}
			}
		}, function(err, notification) {
	   		sendLocalNotification(passenger._id, 'your ride deleted', notification)
		})
	})
}

/*title: user.first_name + " " + user.last_name,
 	body: seat + ' суудал захиалсан байна',
  	large_icon: user.avatar_url
var options = {
		  priority: "high",
		}
  	*/

function kickPassenger(ride, user_id) {
	Notification.create({
		type: 'YOUR_RIDE_DELETED',
		message: ride.start_location.place_name + " - "+ ride.end_location.place_name + " явах унаа цуцлагдлаа. Та өөр унаа хайна уу.",
		user_id: user_id,
		data: {
			ride: {
				_id: ride._id,
				start_time: ride.start_time,
			},
			driver: {
				_id: ride.driver._id,
				first_name: ride.driver.first_name,
				last_name: ride.driver.last_name,
				avatar_url: ride.driver.avatar_url,
			}
		}
	}, function(err, notification) {
   		sendLocalNotification(user_id, 'your ride deleted', notification, function(res) {
   			if(res.code != 0) {
   				//should be send as Push Notification
   				sendRemoteNotification(user_id, {
					title: translation.title,
					body: ride.driver.last_name.substring(0,1) + ". "+ ride.driver.first_name + "  унаагаа цуцаллаа.",
					large_icon: ride.driver.avatar_url
				}, { priority: "high" })

				sendRemoteNotificationToIOS(user_id, {
					title: translation.title,
					body: ride.driver.last_name.substring(0,1) + ". "+ ride.driver.first_name + "  унаагаа цуцаллаа.",
					large_icon: ride.driver.avatar_url
				}, { priority: "high" })
   			}
   		})
	})
}

function onFeedBack(data) {
	Notification.create({
		type: 'DRIVER_FEEDBACK',
		message: 'Таны ' + data.start_location + ' - ' + data.end_location + ' авч явсан зорчигчид үнэлгээ өгч таны аялсан зам ' + data.ride_km + 'км-р нэмэгдлээ',
		user_id: data.driver_id,
		data: {
			start_location: data.start_location,
			end_location: data.end_location,
			ride_km: data.ride_km
		}
	}, function(err, notification) {
   		sendLocalNotification(data.driver_id, 'driver feedback', notification, function(res) {
			if(res.code != 0) {
				sendRemoteNotification(data.driver_id, {
					title: translation.title,
	 				body: 'Таны ' + data.start_location + ' - ' + data.end_location + ' авч явсан зорчигчид үнэлгээ өгч таны аялсан зам ' + data.ride_km + 'км-р нэмэгдлээ',
	  				large_icon: ''
				}, { priority: "high" })

		   		sendRemoteNotificationToIOS(data.driver_id, {
					title: translation.title,
	 				body: 'Таны ' + data.start_location + ' - ' + data.end_location + ' авч явсан зорчигчид үнэлгээ өгч таны аялсан зам ' + data.ride_km + 'км-р нэмэгдлээ',
	  				large_icon: ''
				}, { priority: "high" })
			}
		})
	})
}

function getUser(socket) {
	if(socket.tokenizer) {
		return socket.user
	} else {
		return socket.request.session.user
	}
}

var ioEvents = function(io) {
	globalIo = io
	io.use(function(socket, next){
		if (socket.handshake.query && socket.handshake.query.token) {
			if (socket.handshake.query.token.indexOf("FACEBOOK") !== -1) {
			    User.findOne({
			        'facebook_connection.access_token': String(socket.handshake.query.token.split(" ")[1])
			    }, (err, user) => {
			    	if(err) throw err
			    	if(!user) {
			      	  	return next(new Error('Authentication error'))	
			      	}
			       	socket.user = user
				    socket.tokenizer = true
				    next();   
			    })
            } else {
            	jwt.verify(socket.handshake.query.token, "beecosecretkey", function(err, decoded) {
				    if(err) return next(new Error('Authentication error'));
				      //console.log(decoded)
				    User.findById(decoded._id, (err, user) => {
				      	  if(err) throw err
				      	  if(!user) {
				      	  	  return next(new Error('Authentication error'))	
				      	  }
					      socket.user = user
					      socket.tokenizer = true
					      next();
					})
			    });
            }
		} else {
			socket.tokenizer = false
			next()
			//next(new Error('Authentication error'));
		}
	})
	io.on('connection', (socket) => {
		if(socket.user) {
			Presence.upsert(socket.user._id.toString(), {
				connection: socket.id,
			})
			console.log('user registered with token as ' + socket.user.first_name)
		} else {
			if(socket.request.session.user != null) {
				Presence.upsert(socket.request.session.user._id.toString(), {
					connection: socket.id,
				})
				console.log('user registered as ' + socket.request.session.user.first_name)
			} else {
				console.log('user registered empty user')
			}
		}

	    socket.on('disconnect', function() {
	    	//console.log('disconnect')
	    	if(socket.tokenizer) {
	    		console.log('disconnect with token')
		        Presence.remove(socket.user._id.toString())
	    	} else {
	    		console.log('disconnect with session')
	    		if(socket.request.session.user != null) {
		        	Presence.remove(socket.request.session.user._id.toString())
		        }	
	    	}
	    })

	    // socket.on('ping', () => {
	    // 	console.log('ping from client')
	    // 	socket.emit('pong')
	    // })
	    socket.on('kick passenger', (ride, user_id) => kickPassenger(ride, user_id))
	    socket.on('feed back', (data) => onFeedBack(data))
	    socket.on('userJoined', (userId) => onUserJoined(userId, socket))
	    socket.on('ride cancel', (ride) => onRideCancel(ride, getUser(socket)))
	    socket.on('ride delete', (ride, passengers) => onRideDeleted(ride, passengers))
	    socket.on('ride joined', (ride, seat) => onRideJoined(ride, seat, getUser(socket))) 
	    socket.on('ride toggle seat', (ride) => onRideToggleSeat(ride))
	    socket.on('join chat', function(_id) {
			Chat.findOne({
				_id
			}, function(err, chat){
				if(err) throw err
				if(!chat) {
					socket.emit('updateUsersList', { error: 'Room doesnt exist.' });
				} else {
					// Check if user exists in the session
					if(getUser(socket) == null) {
						//console.log("session not found")
						return
					}

					////console.log("user joined room ...")
					socket.join(chat._id)
					socket.broadcast.to(chat._id).emit('updateUsersList', getUser(socket))
					/*room.addUser(socket, function(err, newRoom){

						// Join the room channel
						socket.join(newRoom._id)
						//console.log('user joined = ' + newRoom._id)
						Room.getUsers(newRoom, socket, function(err, users, cuntUserInRoom){
							if(err) throw err
							
							// Return list of all user connected to the room to the current user
							socket.emit('updateUsersList', users, true)

							// Return the current user to other connecting sockets in the room 
							// ONLY if the user wasn't connected already to the current room
							if(cuntUserInRoom === 1){
								socket.broadcast.to(newRoom.id).emit('updateUsersList', users[users.length - 1])
							}
						})
					})*/
				}
			})
		})

	    // Join a chatroom
		socket.on('join group', function(_id) {
			Room.findOne({
				_id
			}, function(err, room){
				if(err) throw err
				if(!room) {
					socket.emit('updateUsersList', { error: 'Room doesnt exist.' });
				} else {
					// Check if user exists in the session
					if(getUser(socket) == null) {
						//console.log("session not found")
						return
					}

					socket.join(room._id)
					socket.broadcast.to(room._id).emit('updateUsersList', getUser(socket))
					/*room.addUser(socket, function(err, newRoom){

						// Join the room channel
						socket.join(newRoom._id)
						//console.log('user joined = ' + newRoom._id)
						Room.getUsers(newRoom, socket, function(err, users, cuntUserInRoom){
							if(err) throw err
							
							// Return list of all user connected to the room to the current user
							socket.emit('updateUsersList', users, true)

							// Return the current user to other connecting sockets in the room 
							// ONLY if the user wasn't connected already to the current room
							if(cuntUserInRoom === 1){
								socket.broadcast.to(newRoom.id).emit('updateUsersList', users[users.length - 1])
							}
						})
					})*/
				}
			})
		})
		socket.on('newMessage', function(room, message, roomType = 'Group') {
	        Conversation.create({
	            room_id: room._id,
	            createdAt: new Date(),
	            text: message.text,
	            user: message.user,
	        }, function(err, conversation) {
	        	////console.log(users)
	        	let offlineUsers = []
	        	room.users.forEach((user) => {
	        		if(user._id == message.user._id) return
	        		let parameter = {
		    			conversation,
		    			room,
		    			type: roomType,
		    			buddy: user,
		    		}
	        		sendLocalNotification(user._id, 'addMessage global', parameter)
		    		offlineUsers.push(user._id)
	        	})

	        	if(offlineUsers.length > 0) {
	        		User.find({
	        			_id: {
	        				$in: offlineUsers
	        			}
	        		}, 'fcm_token', function(err, users) {
	        			
	        			let tokens = users.map((user) => {
	        				return user.fcm_token
	        			})

	        			var iosPayload = {
	        				notification: {
	        					title: translation.title,
						      	//title: message.user.name,
						    	body: message.user.name + ': " ' + message.text + ' "',
						    	//"sound": "default",
						    	//color: "#e0622e",
						    	//priority: "high",
						    	//icon: "ic_launcher",
						    	large_icon: message.user.avatar
	        				}
	        			}

	        			var payload = {
						  	data: {
							    badge: "0",
							    custom_notification: JSON.stringify({
							      	title: translation.title,
							      	//title: message.user.name,
							    	body: message.user.name + ': " ' + message.text + ' "',
							    	"sound": "default",
							    	color: "#e0622e",
							    	priority: "high",
							    	icon: "ic_launcher",
							    	large_icon: message.user.avatar
							    })
							}
						}

						var options = {
						  priority: "high",
						}

						admin.messaging().sendToDevice(tokens, payload, options)
							 .then(function(response) {
							    //console.log(response);
							 })
							 .catch(function(error) {
							   	//console.log(error);
							 })
	        		})
	        	}
	        	socket.broadcast.to(room._id).emit('addMessage', conversation)
	        })		    
		})
	})	
}

module.exports = function (app, io) {
	/*io.set('transports', ['websocket'])
	*/
	

	ioEvents(io)

	var agenda = new Agenda({
      db: {
        address: mongoConnectionString
      }
    })

    agenda.define('ride ready to go', function(job, done) {
      //console.log(moment().add(15, 'minutes').format("HH:mm"))
      //console.log(moment().seconds(0).milliseconds(0).add(15, 'minutes').utc().format())
      Ride.find({
      	start_time: moment().seconds(0).milliseconds(0).add(15, 'minutes').utc().format()
      }, function(err, rides) {
      	  let userIds = []
      	  //console.log(rides)
      	  rides.forEach((ride) => {
      	  	  userIds.push(ride.driver._id)

      	  	  userIds.push(ride.passengers.map((passenger) => {
      	  	  	return passenger._id
      	  	  }))
      	  })

      	  User.find({
      	  	_id: {
      	  		$in: userIds
      	  	},
      	  }, 'fcm_token', function(err, users) {
		    
      	  		if(!users || users.length == 0) {
      	  			done()
      	  			return
      	  		}

		      	var registrationTokens = users.map(function(user) {
					return user.fcm_token
				})

				var iosPayload = {
					notification: {
						title: translation.title,
						body: "Таны унаа хөдлөхөд 15 минут үлдсэн байна.",
						//icon: "ic_launcher",
					}
				}

		      	var payload = {
				  	data: {
					    badge: "0",
					    custom_notification: JSON.stringify({
					      	title: translation.title,
					    	body: "Таны унаа хөдлөхөд 15 минут үлдсэн байна.",
					    	"sound": "default",
					    	color: "#e0622e",
					    	priority: "high",
					    	icon: "ic_launcher",
					    	//large_icon: ride.driver.avatar_url
					    })
					}
				}

				var options = {
				  priority: "high",
				}

				if(registrationTokens.length > 0) {
					admin.messaging().sendToDevice(registrationTokens, iosPayload, options)
						 .then(function(response) {
						    //console.log(response);
						 })
						 .catch(function(error) {
						   	//console.log(error);
						 })

					admin.messaging().sendToDevice(registrationTokens, payload, options)
						 .then(function(response) {
						    //console.log(response);
						 })
						 .catch(function(error) {
						   	//console.log(error);
						 })
				}

				done()
      	  })
      })
    })

    agenda.define('delete past notify', function(job, done) {
    	Notify
    	.find({
    		end_time: {
    			$lt: moment(),
    		},
    	}, function(err, notifies) {
    		if(err) throw err
    		let notifyIds = []
    		notifies.forEach((notify) => {
    		  notifyIds.push(notify._id)
		      sendRemoteNotification(notify.user, {
		          title: "beeco - Замын унаа апп",
		          body: 'Таны хайсан цагт явах унаа олсонгүй. Та дараа дахин хайж үзээрэй',
		      }, { priority: "high" })

		      sendRemoteNotificationToIOS(notify.user, {
		          title: "beeco - Замын унаа апп",
		          body: 'Таны хайсан цагт явах унаа олсонгүй. Та дараа дахин хайж үзээрэй',
		      }, { priority: "high" })
		    })

		    Notify.remove({
		    	_id: {
		    		$in: notifyIds
		    	}
		    }, function(err) {
		    	done()
		    })
    	})
    })

    agenda.define('move rides to history', function(job, done) {
      //console.log('JOB HIRING ...')
      Ride.find({
        start_time: {
          $lt: moment().subtract(10, 'minutes')
        }
      }, function(err, rides) {
        let ride_ids = []
        let repeated_rides_ids = []

        _.forEach(rides, (ride) => {
        	ride_ids.push(ride._id)
        	if(ride.repeated_ride) {
        		repeated_rides_ids.push(ride.repeated_ride)
        	}
        })

        //console.log(repeated_rides_ids)

        RepeatedRide.find({
        	_id: {
        		$in: repeated_rides_ids
        	}
        }, function(err, repeated_rides) {
        	if(err) throw err

        	//console.log('r rides = ' + repeated_rides.length)

        	_.forEach(repeated_rides, async (repeatedRide) => {
        		let { nextRide, user } = await repeatedRide.publishNextRide()
        		sendRemoteNotification(user._id, {
					title: translation.title,
					body: "Таны " + moment(nextRide.start_time).format('YYYY/MM/DD HH:mm') + "-д явах унаа амжилттай нийтлэгдлээ. Та энэ унааг давтан явахаар санал болгосон учир автоматаар нийтлэгдсэн. Идэвхтэй аяллын жагсаалтанд та санал болгосон унаагаа харж болно.",
					large_icon: user.avatar_url
				}, { priority: "high" })

	   			sendRemoteNotificationToIOS(user._id, {
					title: translation.title,
					body: "Таны " + moment(nextRide.start_time).format('YYYY/MM/DD HH:mm') + "-д явах унаа амжилттай нийтлэгдлээ. Та энэ унааг давтан явахаар санал болгосон учир автоматаар нийтлэгдсэн. Идэвхтэй аяллын жагсаалтанд та санал болгосон унаагаа харж болно.",
					large_icon: user.avatar_url
				}, { priority: "high" })
        	})
        
        	Ride.remove({
		        _id: {
		            $in: ride_ids
		        }
		    }, function(err, removed) {
		    	RideHistory.insertMany(rides, function(err, rideHistories) {
		    		_.forEach(rides, async (ride) => {
		    			let passengersIds = ride.passengers.map((passenger) => passenger._id)
		    			passengersIds.push(ride.driver._id)

		    			await User.update({
	             			_id: {
	             				$in: passengersIds
	             			},
	             		}, {
	             			$pull: {
	             				active_rides: ride._id,
	             			},             			
	             			$push: {
	             				history_rides: ride._id,
	             			}
	             		}, {
	             			multi: true
	             		})
		            })
		            //console.log('JOB HIRED ...')
		            done()	
			    })  
		    })
        })
      })
    })

    agenda.on('ready', function() {
      agenda.every('one minute', 'move rides to history', { priority: 'high' })
      agenda.every('one minute', 'ride ready to go', { priority: 'high' })
      agenda.every('5 minutes', 'delete past notify', { priority: 'high' })
      agenda.start()
    })

    app.use('/dash', Agendash(agenda))
}

function sendLocalNotification(user_id, action, paramater, callback = null) {
	Presence.get(user_id, function(data) {
		if(data) {
			globalIo.to(data.meta.connection).emit(action, paramater)
			if(callback) callback({ code: 0, })
		} else {
			if(callback) callback({ code: 1, })
		}
	})
}

function sendRemoteNotificationToIOS(user_id, data, options) {
	User.findOne({
		_id: user_id,
		//phone_verified: true,
	}, 'fcm_token', function(err, user) {
		//console.log(user)
		let tokens = []
		tokens.push(user.fcm_token)
		var payload = {
			//"content-available" : true,
		  	"notification": {
		       ...data,
		       sound: "default",
		       //show_in_foreground: true,
		       //"click_action": "mn.beeco.ridesharing" // The id of notification category which you defined with FCM.setNotificationCategories
			},
		}
		//console.log(tokens)

		admin.messaging().sendToDevice(tokens, payload, options)
			 .then(function(response) {
			 	//console.log(response)
			 })
			 .catch(function(error) {
			 	//console.log(error)
			 })
	})
}

function sendRemoteNotification(user_id, data, options) {
	User.findOne({
		_id: user_id
	}, 'fcm_token', function(err, user) {
		let tokens = []
		tokens.push(user.fcm_token)
		var payload = {
		  	data: {
			    badge: "0",
			    custom_notification: JSON.stringify(Object.assign(data, {
					sound: "default",
			    	color: "#e0622e",
			    	priority: "high",
			    	icon: "ic_launcher",
			    	show_in_foreground: true,
			    }))
			}
		}

		admin.messaging().sendToDevice(tokens, payload, options)
			 .then(function(response) {
			 	//console.log(response)
			 })
			 .catch(function(error) {
			 	//console.log(error)
			 })
	})
}