import Config from '../../config/Config.js'
import axios from 'axios'
const queryString = require('query-string')
const key = "sms-skytel"
import { mgsSkytelLog, mgsSkytelError } from '../MsgLogger' 

export class Skytel {
	sendMessage({ phone, message, }) {
		Config.findOne({
			key
		}, (err, cfg) => {
			let config = cfg.value
			let params = {
				token: config.token,
				sendto: phone,
				message: message,
			}	

			mgsSkytelLog(phone,  message)

			axios.get(config.host + 'apiSend?' + queryString.stringify(params))
				 .then((res) => {
				 //	console.log(res.data)
				 	mgsSkytelLog(phone , "Амжилттай илгээлээ")
				 })
				 .catch((err) => {
				 	mgsSkytelError(phone , JSON.stringify(err) )
				 })
		})
	}
}

export let skytel = new Skytel()