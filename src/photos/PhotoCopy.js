var sharp = require('sharp')
import { googleCloudBuffer } from './GoogleCloud' 

exports.copyPhoto = function(req, callback) {
  sharpBufferPhoto(req, callback, 100, true)
  let size = [720, 200, 50, 30]
  setTimeout(async () => otherPhotos(req, callback, size), 2000)
}

exports.copyCarPhoto = function(req, callback) {
  sharpBufferPhoto(req, callback, 100, true)
  let size = [720, 200, 50]
  setTimeout(async () => otherPhotos(req, callback, size), 2000)
}

function otherPhotos(req, callback, size) {
    for(let i = 0; i < size.length; i++ ) {
      sharpBufferPhoto(req, callback, size[i], false)
    } 
}

function sharpPhoto(req, callback, size, last) {
  sharp(req.file.path)
    .resize(size, size)
    .toFile( req.file.destination + req.file.fieldname + '-'+ req.key + '-' + size +'.jpg', function (err) 
    { 
      if (err) throw err
      if(last){
          return callback({
            imageUrl: req.folder + '/' + req.file.fieldname + '-'+ req.key + '-'
          })
      }
    })
}

function sharpBufferPhoto(req, callback, size, first) {
  sharp(req.buffer)
    .rotate()
    .resize(size, size)
    .toBuffer()
    .then( data => {
      var image=  req.name + "-" + req.key + "-" + size + ".jpg"
       googleCloudBuffer({buffer: data, name: image, bucketName: req.bucketName}, function(response){
          if(first){
        //    console.log(response)
            return callback({
              imageUrl: req.name + "-" + req.key + "-"
            })
          }
      })
    })
    .catch( err => {
        return callback({ err })
    });
}

