let args = {
  "headers": {
    "accept": "*/*",
    "accept-language": "en-US,en;q=0.9",
    "if-none-match": "W/\"475-jQTOONAcGudKmUTHT+66zkC3n3g\"",
    "priority": "u=1, i",
    "sec-ch-ua": "\"Chromium\";v=\"134\", \"Not:A-Brand\";v=\"24\", \"Brave\";v=\"134\"",
    "sec-ch-ua-mobile": "?0",
    "sec-ch-ua-platform": "\"Windows\"",
    "sec-fetch-dest": "empty",
    "sec-fetch-mode": "cors",
    "sec-fetch-site": "same-site",
    "sec-gpc": "1"
  },
  "referrer": "https://pump.fun/",
  "referrerPolicy": "strict-origin-when-cross-origin",
  "body": null,
  "method": "GET",
  "mode": "cors",
  "credentials": "omit"
}, wrap=(promise, cb=_=>_, obj={})=>promise.then(data=>obj.data=data).catch(err=>obj.err="An error occured when fetching data")
  .finally(_=>cb(obj)),

  fetches = {
    comments: cb=>(wrap(fetch("https://frontend-api-v3.pump.fun/replies/5LJMJyR8MtAkbtpf8kFUV7S9oFG3xaGDdcnFxYt9pump?limit=1000&offset=0"))),
    alike: cb=>wrap(fetch("https://frontend-api-v3.pump.fun/coins/similar?mint=5LJMJyR8MtAkbtpf8kFUV7S9oFG3xaGDdcnFxYt9pump&limit=100")),
    king: cb=>wrap(fetch('https://frontend-api-v3.pump.fun/coins/king-of-the-hill?includeNsfw=false').then(res=>res.json()), cb),
    coin: mint=>fetch(`https://frontend-api.pump.fun/coins/${mint||"CPBQqugWWCcyehezHf4uSJtET2kmYNqPuhyb57H5pump"}`).then(res=>res.json()),
    sift: (opts, cb)=>(opts||={}, wrap(fetch(`https://frontend-api-v3.pump.fun/coins/for-you?offset=${opts.offset||0}&limit=${opts.limit||4}&includeNsfw=${opts.nsfw||"false"}`, args).then(res=>res.json()), cb)),
    latest: cb=>wrap(fetch("https://frontend-api-v3.pump.fun/coins/latest", args).then(res=>res.json()), cb)
};

module.exports = fetches
  // fetch('https://www.google.com/tia/tia.png').then(res=>res.blob()).then(blob=>require('fs').writeFileSync('tia.png', Buffer(blob)))