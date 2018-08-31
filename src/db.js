const mongoose = require('mongoose')

mongoose.Promise = global.Promise

/*async function run() {
  await mongoose.connect('mongodb://localhost/beeco', { 
  	useMongoClient: true 
  })
}*/

async function run() {
  await mongoose.connect('mongodb://' + process.env.DB_USER + ":" + process.env.DB_PASS + "@" + process.env.DB_HOST, { 
  	useMongoClient: true      
})}

// async function run() {
//   await mongoose.connect('mongodb://localhost:27017/demo', { 
//   	useMongoClient: true 
//   })
// }
run().catch(error => console.error(error.stack))