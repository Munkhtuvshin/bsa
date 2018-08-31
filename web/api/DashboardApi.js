import axios from 'axios'
import * as api_hosts from './env.js'
export default class IntercityApi {
	static getTotalCountBoth(params) {
		//192.168.0.123:3000
		// return axios.get('http://192.168.0.123:3000/api/total-count')
		return axios.get('http://'+api_hosts.API+'/api/total-count')
	}

	static getUserImprovement(params) {
		return axios.get('http://'+api_hosts.API+'/api/user-improvement')
	}

	static getRideCollision(params) {
		// return axios.get('http://localhost:3000/api/ride-collisions', {
		// 	params,
		// })
		return axios.get('http://'+api_hosts.API+'/api/ride-collisions', {
			params,
		}) //104.199.164.101
	}
}	