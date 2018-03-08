1. Export a js mould.
```javascript
let user = window.App.user;
module.exports = {
    updateReply(reply){
        return reply.user_id === user.id;
    }
};
```

2. Rest Parameters
```javascript
window.Vue.prototype.authorize = function (...params) {
    if(!window.App.signedIn) return false;

    if(typeof params[0] === 'string'){
        return authorizations[params[0]](params[1]);
    }

    return params[0](window.App.user);
}
```