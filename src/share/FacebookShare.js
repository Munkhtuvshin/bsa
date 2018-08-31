var express = require('express')
var router = express.Router()
var useragent = require('useragent')

var path = require("path")

// import App from './App';
// import Html from './Html';

// import { renderToString } from 'react-dom/server'

router.get('/', function (req, res){
	console.log(req.query)
	//res.sendFile(path.join(__dirname, '../../public', 'share.html'));

	const title = req.query.title
	const content = req.query.content

	res.send(renderFullPage(title, content))
})

function renderFullPage(title, content) {
  return `
    <!doctype html>
    <html>
	  <head>
	  		<meta charset="utf-8">
		  	<meta content="text/html; charset=utf-8" http-equiv="content-type"><!-- /Added by HTTrack -->
	  		<meta content="width=device-width, initial-scale=1" name="viewport">
				<!--=== Mobile specific metas ===-->
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1">

			<link rel="icon" type="image/png" href="img/favicon.png">
			<title>${title}</title>

			<meta property="al:ios:url" content="applinks://docs" />
			<meta property="al:ios:app_store_id" content="12345" />
			<meta property="al:ios:app_name" content="App Links" />
			<meta property="al:android:url" content="https://play.google.com/store/apps/details?id=com.beeco.ridesharing&hl=en" />
			<meta property="al:android:app_name" content="Ridesharing" />
			<meta property="al:android:package" content="com.beeco.ridesharing" />
			<meta property="al:web:url"
					content="http://applinks.org/documentation" />
		</head>
		<body>
			<img src="img/favicon.png"/>
			Hello, world!
			${content}
		</body>
	</html>
    `
}

router.get('/share', function (req, res){

	console.log('1')
	var agent = useragent.parse(req.headers['user-agent']);
    console.log('^^^^^^^^^^^^' + agent.device.toString())
	// console.log(io)
	// console.log(agent.toAgent())
	// console.log(agent.device.toString())
	
	var android = useragent.is(req.headers['user-agent']).android
	if(android)  
		return res.redirect('market://details?id=com.beeco.ridesharing&referrer=BlaBla')

	//var iPhone = stripos(useragent.parse(req.headers['user-agent']),"iPhone")
	//console.log(" 11 - " + iPhone)
	
	res.redirect('https://itunes.apple.com/lb/app/truecaller-caller-id-number/id448142450?mt=8')
	//res.redirect('https://play.google.com/store/apps/details?id=com.beeco.ridesharing&referrer=BlaBla')
	//res.redirect('https://www.beeco.mn')
})

module.exports = router
