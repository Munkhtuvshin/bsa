var _ = require('lodash')
var express = require('express')
var Event = require('./Event')
var router = express.Router()
var multer  = require('multer')
var XLSX = require('xlsx');
var fs = require("fs");

var moment = require('moment')
//var User = require('../user/User')

// router.get('/', isAuthenticated, function (req, res) {
//     return res.json({
//         code: 0,
//     })
// })
var storage = multer.diskStorage({
    destination: 'public/event',
    filename: function (req, file, cb) {
      cb(null, file.fieldname +'-'+file.originalname)
    }
})

const upload = multer({
    storage:storage
}).single('cover_url');

router.get('/', function (req, res) {
    Event
    .find({})
    .sort({
        start_at: -1
    })
    .limit(10)
    .exec(function(err, events) {
      return res.json(events);  
    });
})


router.post('/checkEqual',upload, function(req, res){
    var BreakException = {};
    console.log('control')
    console.log(req.body)
    console.log(req.file)
    Event
    .find({})
    .sort({
        start_at: -1
    })
    .exec(function(err, events) {
        let counter=0, pre=0;
        
        try {
            events.forEach(function(event){
                // console.log(moment(event.finish_at).toDate().getTime())
                // console.log(moment(req.body.start_at).toDate().getTime())
                let a =moment(event.finish_at).toDate().getTime();
                let b =moment(event.start_at).toDate().getTime();
                let c =moment(req.body.start_at).toDate().getTime();
                let d =moment(req.body.finish_at).toDate().getTime();
                console.log(event.title)
                if(b<c & a>c | d<a & d>b | a==d & b==c | a<d & a>c | b>c & b<d){ // | a<d & a>c | b>c & b<d
                    pre++;
                }
                counter++;
                if(pre==1) throw BreakException;
            })
        } catch (e) {
          if (e !== BreakException) throw e;
        }
        console.log('pre variable: '+pre)
        if(pre>0){
            return res.json({
                code:1,
                count:counter
            });            
        }else{
            Event.create( {title: req.body.title, start_at: req.body.start_at, finish_at: req.body.finish_at, 
              location:{ latitude: req.body.latitude, longitude: req.body.longitude }, 
              cover_url: 'http://localhost:3000/event/'+req.file.filename, event_start_at:req.body.event_start_at,
              event_finish_at: req.body.event_finish_at }, (err, event) => {
                console.log(err)
                console.log('loc')
                // var writeStream = fs.createWriteStream("test.xlsx");
                if(typeof require !== 'undefined') XLSX = require('xlsx');
                var wb = XLSX.readFile('test.xlsx');
                var ws = wb.Sheets[wb.SheetNames[0]];
                XLSX.utils.sheet_add_aoa(ws, [
                  [ 1, 2, 3]
                ], {origin: -1});
                
                XLSX.writeFile(wb, 'new.xlsx');

              return res.json({
                code:0,
                event:req.body,
                cover_url:'http://localhost:3000/event/'+req.file.filename
              });
            })
        } 
    })
})

router.put('/:id',upload, function (req, res) {
    if(typeof req.file == 'undefined'){
        var BreakException = {};
        console.log('control')
        console.log(req.body)
        console.log(req.file)
        Event
        .find({})
        .sort({
            start_at: -1
        })
        .exec(function(err, events) {
            let counter=0, pre=0;
            
            try {
                events.forEach(function(event){
                    let a =moment(event.finish_at).toDate().getTime();
                    let b =moment(event.start_at).toDate().getTime();
                    let c =moment(req.body.start_at).toDate().getTime();
                    let d =moment(req.body.finish_at).toDate().getTime();
                    console.log(event.title)
                    console.log(event.id)
                    console.log(req.params.id)
                    if(event._id != req.params.id){
                        if(b<c & a>c | d<a & d>b | a==d & b==c | a<d & a>c | b>c & b<d){ // | a<d & a>c | b>c & b<d
                            pre++;
                        }
                    }
                    counter++;
                    if(pre==1) throw BreakException;
                })
            } catch (e) {
              if (e !== BreakException) throw e;
            }
            console.log('pre variable: '+pre)
            if(pre>0){
                return res.json({
                    code:1,
                    count:counter
                });            
            }else{
                Event.findOneAndUpdate( { _id:req.params.id }, { $set: {title: req.body.title, start_at: req.body.start_at, finish_at: req.body.finish_at, 
                    location:{ latitude: req.body.latitude, longitude: req.body.longitude }, 
                    cover_url: req.body.cover_url, event_start_at:req.body.event_start_at,
                    event_finish_at: req.body.event_finish_at } }, (err, event) => {
                    console.log(err)
                    console.log('loc')
                    return res.json({
                        code:0,
                        event:req.body,
                        cover_url:req.body.cover_url
                    });
                })
            } 
        })
    }
    else{

    }
})
    // if(typeof req.file !== 'undefined'){
    //     Event.
    //     findOneAndUpdate( { _id:req.params.id }, { $set: {title: req.body.title, start_at: req.body.start_at, 
    //       finish_at: req.body.finish_at, location:{ latitude: req.body.latitude, longitude: req.body.longitude },
    //       cover_url: 'http://localhost:3000/event/'+req.file.filename, event_finish_at:req.body.event_finish_at, 
    //       event_start_at:req.body.event_start_at } }, 
    //       (err, event) => {
    //         console.log(err)
    //         return res.json(event)
    //     })
    // }
    // else{
    //     Event.
    //     findOneAndUpdate( { _id:req.params.id }, { $set: {title: req.body.title, start_at: req.body.start_at, 
    //       finish_at: req.body.finish_at, location:{ latitude: req.body.latitude, longitude: req.body.longitude },
    //       cover_url: req.body.cover_url, event_finish_at:req.body.event_finish_at, 
    //       event_start_at:req.body.event_start_at } }, 
    //       (err, event) => {
    //         console.log(err)
    //         return res.json(event)
    //     })
    // }
// })
router.delete('/:id', function (req, res) {
    Event
    .findOne({ _id:req.params.id })
    .remove()
    .exec(function(err, event){
      return res.json(req.params.id);
    });
})

router.get('/create', function(req, res) {
    const parameters = {
        title: 'Ibiza',
        cover_url: 'https://scontent.fuln6-1.fna.fbcdn.net/v/t1.0-9/35559117_1792254947501493_8721706099901726720_o.jpg?_nc_cat=0&oh=03e2de1167c939a9a8152e4fc66cb2aa&oe=5B9DE9DB',
        desription: '',
        location: {
            latitude: 47.924230,
            longitude: 107.140507,
        },
        start_at: moment(),
        finish_at: moment().add(2, 'days'),
        event_start_at: moment().add(-2, 'days'),
        event_finish_at: moment().add(2, 'days'), 
    }

    Event.create(parameters, function(err, event) {
        return res.json({
            code: 0,
            event
        })
    })
})
//ininidfin change example commt
router.get('/current-event', isAuthenticated, function(req, res) {
    //console.log('That"s what the heck is this')
    // return res.json({
    //     code: 0,
    //     is_available: false,
    //     event: null
    // })
    let tonight = moment()
    tonight.hour(12)
    tonight.minutes(0)
    tonight.seconds(0)
    //console.log(tonight.format())
    Event.find({
        start_at: {
            $lte: tonight
        },
        finish_at: {
            $gte: tonight
        }
    }, function(err, events) {
        if(err) throw err

        return res.json({
            code: 0,
            is_available: events.length > 0 ? true : false,
            event: events.length > 0 ? events[0] : null
        })
    })
})
// router.post('/',upload, function (req, res) {
//     console.log('add event:')
//     console.log(req.body)
//     console.log(req.file)
//     if(typeof req.file == 'undefined') {
//         Event.create( {title: req.body.title, start_at: req.body.start_at, finish_at: req.body.finish_at, 
//           location:{ latitude: req.body.latitude, longitude: req.body.longitude }, 
//           cover_url: 'http://localhost:3000/event/'+req.body.cover_url, event_start_at:req.body.event_start_at,
//           event_finish_at: req.body.event_finish_at }, (err, event) => {
//           return res.json(event);
//         })
//     }
//     else{
//         Event.create( {title: req.body.title, start_at: req.body.start_at, finish_at: req.body.finish_at, 
//           location:{ latitude: req.body.latitude, longitude: req.body.longitude }, 
//           cover_url: 'http://localhost:3000/event/'+req.file.filename, event_start_at:req.body.event_start_at,
//           event_finish_at: req.body.event_finish_at }, (err, event) => {
//           return res.json(event);
//         })
//     }
// })
// router.delete('/', isAuthenticated, function (req, res) {
//     return res.json({
//         code: 0,
//     })
// })

// router.post('/', isAuthenticated, function (req, res) {
//     return res.json({
//         code: 0,
//     })
// })

function isAuthenticated(req, res, next)  {
    req.verifyTokenIfAny(req, res, next)
}

module.exports = router
