module.exports = {
    jwtSecret: 'ashsdlashf-853690436-3486986-4-0dsfnfndfsjh50459--m0c95843783v587m58057839405904',
    facebookAuth : {
        clientId: '476017162774862',
        //clientId: '1549615252014368',
        clientSecret: '78ea17b4febd52405f5019a4d4dd563a',
        //clientSecret: '0c451692c82e35182f0084aedde8089e',
        callbackUrl: 'http://192.168.1.2:3000/auth/facebook/callback'
    },
    redis: {
    	host: "127.0.0.1",
		port: 6379,
    },
    mongoLab: {
        username: "tuvshinbat",
        password: "kNet.b1ad3mb",
        host: "mongodb://tuvshinbat:kNet.b1ad3mb@ds259855.mlab.com:59855/beeco"
    }

    
}
