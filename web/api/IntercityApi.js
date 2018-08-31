import axios from 'axios'

const BASE_URI = process.env.REDIS_HOST

export class IntercityApi {
	getPopularRides(params) {
		//192.168.0.123:3000
		//return axios.get('http://192.168.0.123:3000/intercityRide/popular', {params})
		return axios.get('http://localhost:3000/intercityRide/popular', {params})
	}
	getAllRides(params) {
		return axios.post('http://localhost:3000/intercityRide/intercity-all-ride', params)
	}
	getDateFilter(params) {
		return axios.post('http://localhost:3000/intercityRide/intercity-date-filter', params)
	}
}	

export let intercityApi = new IntercityApi()