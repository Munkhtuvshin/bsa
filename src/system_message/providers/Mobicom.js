import Config from '../../config/Config.js'
import axios from 'axios'
const queryString = require('query-string')
const key = "sms-mobicom"
import { mgsMobicomLog, mgsMobicomError } from '../MsgLogger' 
//curl http://27.123.214.168/smsmt/mt?servicename=prime -d"username=prime&from=151161&to=99956960&msg=test22 abc"
//http://27.123.214.168/smsmt/mt?servicename=prime&username=prime&from=99111111&to=99956960&msg=hell
//http://27.123.214.168/smsmt/mt?servicename=prime&username=prime&from=151161&to=9xxxxxxx&msg=hell
export class Mobicom {
	async getConfig() {
		let config = {}
		await Config.findOne({
			key
		}, (err, cfg) => {
			config = cfg
		})
		return config.value
	}

	sendMessage({ phone, message, verification_code }) {
		Config.findOne({
			key
		}, (err, cfg) => {
			let config = cfg.value
			//console.log(config)
			let params = {	
				servicename: config.service_name,
				username: config.username,
				from: config.from,
				to: phone,
				msg: verification_code + " batalgaajuulah code.",
			}	
			
			mgsMobicomLog(phone, message)

			axios({
				method: 'get',
				url: config.host + 'smsmt/mt?' + queryString.stringify(params),
				headers: {
					'Content-type': 'application/x-www-form-urlencoded',
				}
			})
			.then((res) => {
			 	console.log(res)
			 	mgsMobicomLog(phone , "Амжилттай илгээлээ" )
			 })
			 .catch((err)=>{
			 	//console.log(err)
			 	mgsMobicomError(phone , JSON.stringify(err) );
			 })
		})		
	}
}

export let mobicom = new Mobicom()