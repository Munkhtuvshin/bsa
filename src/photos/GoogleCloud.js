// Imports the Google Cloud client library
const Storage = require('@google-cloud/storage')
const format = require('util').format
var serviceAccount = require("../../beeco-156f5-firebase-adminsdk-rlduo-507ea5f413.json")
// Your Google Cloud Platform project ID
const projectId = 'copper-diorama-182804'

// Creates a client
const storage = new Storage({
  projectId: projectId,
  keyFileName: serviceAccount
});

exports.googleCloudBuffer = function(req, callback) {

  const bucket = storage.bucket(req.bucketName);
  const blob = bucket.file(req.name);
  const blobStream = blob.createWriteStream();

  blobStream.on('error', (err) => {
    console.log(err);
  });

  blobStream.on('finish', () => {
    // The public URL can be used to directly access the file via HTTP.
    const publicUrl = format(`https://storage.googleapis.com/${bucket.name}/${blob.name}`);
    return callback({ imageUrl: publicUrl })
  });

  blobStream.end(req.buffer);
}

exports.googleCloud = function(req, callback) {
  // Creates the new bucket
  console.log(req.file.fieldname);
  storage
  .bucket('bimage') // req.bucketName
  .upload(req.file.destination + req.file.fieldname + '-'+ req.key + '-' + 720 +'.jpg')
  .then((results) => {
    console.log(results[0].metadata.mediaLink);
    return callback({
      imageUrl: results[0].metadata.mediaLink
    })
  })
  .catch(err => {
    console.error('ERROR:', err);
  });
}