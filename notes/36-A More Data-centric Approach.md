1. Pass data to parent vue component by using $emit
* Listening on deleted event.
```html
<reply :data="reply" @deleted="remove(index)"></reply>
```

* reply emit a delete event.
```html
destroy() {
    axios.delete('/replies/' + this.data.id);
    this.$emit('deleted', this.data.id);
}
```

* remove defined as method of parent vue component of Replies
```html
methods : {
    remove(index){
        this.items.splice(index,1);
        this.$emit('removed');
        flash('Reply was deleted.');
    }
}
```

2. v-for 
```html
<div v-for="(reply,index) in items">
    <reply :data="reply" @deleted="remove(index)"></reply>
</div>
```

3. add a function to vue. pass callback as parameter.
```html
window.Vue.prototype.authorize = function (handle) {
    var user = window.App.user;
    return user ? handle(user) : false;
};

// Call this function
    return this.authorize(user => this.data.user_id == user.id);
}
```

4. Vue camelCased props need to use their kebab-case equivalents when using in-DOM templates.
```html
props : ['initialRepliesCount'],
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
```