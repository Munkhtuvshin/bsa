
import { skytel, mobicom } from './providers'

//const mobicomRegex = ["99", "95", "94", "85"]
const mobicomRegex = ["99", "95", "94", "85", "75"]

export default function MessageFactory(phone) {
	let prefex = phone.substring(0, 2)
	//console.log(prefex)

	if(mobicomRegex.includes(prefex)) {
		return mobicom	
	}

	return skytel
}