import * as types from './AuthConstant'
import AuthApi from './AuthApi'

export function onLoginAction(data) {
	return dispatch => {
		dispatch({ type: types.ON_LOGIN_ACTION })
		AuthApi
		.loginAction(data)
		.then(res => {
			if(res.data.code != 0) {
				alert(res.data.message)
				dispatch({
					type: types.ON_LOGIN_ACTION_FAILED,
				})
			} else {
				dispatch({
					type: types.ON_LOGIN_ACTION_FULFILLED,
					payload: res.data
				})

				sessionStorage.setItem('accessToken', res.data.token)
			}
		})
		//dispatch({})
	}
}