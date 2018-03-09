1. Refactor
```html
let user = window.App.user;
module.exports = {
    owns(model,prop='user_id'){
        return model[prop] == user.id;
    }
};
```

```html
<div class="panel-footer level" v-if="authorize('owns',reply) || authorize('own',reply.thread)">
```