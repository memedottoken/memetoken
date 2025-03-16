let fs     = require('fs'),
    http   = require('http'),
    path   = require('path'),
    file   = path.join(require('./utils/rootDir')(__dirname), './sql_ui_config.json'),
    config = fs.existsSync(file)&&require(file)||{...process.env},
    mime   = require('mime-types'),
    scktio = require('socket.io'),
    { urlParts, parseMultipart } = require('./utils/utils'),
    stream = require('./stream'),
    server;
    
    config.PORT||=3000;

    const jobs   = {
      GET:function(req, res, parts, fxn) {
        /** middlewares that respond to GET requests are called here */
        fxn = fs.existsSync(fxn='.'+parts.url+'.js')&&require(fxn),
        req.query = parts.params, fxn&&fxn(req, res);
        return !!fxn;
      },
      POST:function(req, res, parts, fxn, buffer) {
        fxn = fs.existsSync(fxn='.'+parts.url+'.js')&&require(fxn), buffer=[],
        req.on('data', chunk=>buffer.push(chunk)),

        req.on('end', function(data) {
            data = Buffer.concat(buffer).toString('utf-8'),
            /** create req.body and res.json because invoked modules in Vercel require them to be defined */
            req.body = /multipart/.test(req.headers['content-type'])  ? parseMultipart(req, data)
            : (/** urlParts obtains the parameters for other enctypes as used below */
            /\{|\}/.test(data) ? JSON.parse(data)
            : (parts = urlParts('?'+data)).params),

          fxn&&fxn(req, res)
        });
        /* no issue of returning early before the callback above since fxn gets its value early on*/
        if(!fxn) res.end();
        /** decided to return true instead of !!fxn since POST requests are not expected to GET html resources */
        return !!fxn;
      }
    },
    cache  = {}; /** to store the strings of data read from files */

(server = http.createServer((req, res, url, parts, data, verb)=>{
  ({ url } = parts =  urlParts(req.url)),
  
  res.json=obj=>res.end(JSON.stringify(obj)), // for Vercel functions
  data = jobs[verb=req.method](req, res, parts),

  url = url === '/' ? 'index.html' : url,
  /** comment "data ||" out if your middlewares are built to return values to be sent as responses and not send back responses by themselves */
  data || new Promise((resolve, rej, cached)=>{
    if (data) { resolve(/*dynamic data, exit*/); return; }

    /*(cached=cache[req.url])?resolve(cached):*/fs.readFile(path.join('./', url), (err, buf)=>{
      if(err) rej(err);
      else resolve(cache[req.url]=buf)
    })
  }).then(cached=>{
    res.writeHead(200, {
      'Access-Control-Allow-Origin': '*',
      'Content-type': mime.lookup(url) || 'application/octet-stream'
   }),
   /** return dynamic data or static file that was read */
    // console.log("::PROMISE", [url]),
    res.end(cached)
  }).catch((err, str)=>{
    str='::ERROR:: '+err,
    // console.error(str='::ERROR:: '+err, [url])
    res.end(str)
  })
})).listen(config.PORT, _=>{
  console.log(`Server listening on PORT ${config.PORT}`)
});

(io = scktio(server)).on('connection', stream);

const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8080 });
/*simulate "stack"ing data to websocket server*/

wss.on('connection', (ws) => {
  ws.on('message', (data, id) => {
    
  });

  ws.on('close', () => {
    /** */
  });
})