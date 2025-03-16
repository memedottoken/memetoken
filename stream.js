let fetches = require('./fetches'),
    tokens  = require('./memecoins');
    /**coin data to use as filler */

const stream = socket=>{
  /** this endpoint is expected to be hit once for each session of a client  */
  socket.on('mint', _=>fetches.sift({ limit:20 }, fill=>socket.emit('mint', fill))),
  /** is expected to be spammed multiple times */
  socket.on('latest', _=>fetches.latest(data=>socket.emit('latest', data))),
  socket.on('king', _=>fetches)
  socket.on('disconnect', _=>{
    console.log('DISCONNECT::WebSocket')
  })
}

module.exports = stream;