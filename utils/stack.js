/** A stack created with variable size working on FIFO */
let stack = { limit: 20, __store:{}, stack:[],
  add:function(id,data) {
    let sym=':|:', l=this.limit-1,s=this.__store;
    /*shift elements based on FIFO within `limit`*/
    (this.stack=[id+sym+(s[id]=data)].concat(this.stack.slice(0, l))).length==l&&delete s[l]
  },
  has:function(id) { return this.__store[id] }
};