const { createLogger, format, transports } = require('winston')
const mobicomRegex = ["99", "95", "94", "85", "75"]

const skytel = createLogger({
  level: 'info',
  format: format.json(),
  transports: [
    new transports.File({ filename: 'error_msg_skytel.log', level: 'error' }),
    new transports.File({ filename: 'combined_skytel.log' })
  ]
})

const mobicom = createLogger({
  level: 'info',
  format: format.json(),
  transports: [
    new transports.File({ filename: 'error_msg_mobicom.log', level: 'error' }),
    new transports.File({ filename: 'combined_mobicom.log' })
  ]
})

exports.mgsMobicomLog = function(phone, message ) {
   	mobicom.log('info', phone + " -> " + message + " : " + new Date())
}

exports.mgsSkytelLog = function(phone, message ) {
   	skytel.log('info', phone + " -> " + message + " : " + new Date())
}

exports.mgsLog = function(phone, message ) {
	let prefex = phone.substring(0, 2)
	if(mobicomRegex.includes(prefex)) {
		return mobicom.log('info', phone + " -> " + message + " : " + new Date())
	}
   	skytel.log('info', phone + " -> " + message + " : " + new Date())
}

exports.mgsMobicomError = function(phone, message) {
    mobicom.error(phone + " -> " + message + " : " + new Date())
}

exports.mgsSkytelError = function(phone, message) {
    skytel.error(phone + " -> " + message + " : " + new Date())
}