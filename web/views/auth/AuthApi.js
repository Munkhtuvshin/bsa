import axios from 'axios'

export default class AuthApi {
	static loginAction(data) {
		return axios.post('http://localhost:3000/admin-login', data)
		// return axios.post('http://104.199.164.101/admin-login', data)
	}
}