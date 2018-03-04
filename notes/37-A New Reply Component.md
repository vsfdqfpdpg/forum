1. Add and remove from object
```html
methods : {
    add(reply){
        this.items.push(reply);
        this.$emit('added');
    },
    remove(index){
        this.items.splice(index,1);
        this.$emit('removed');
        flash('Reply was deleted.');
    }
}
```

2. Axios post
```html
addReply(){
    axios.post(this.endpoint,{ body : this.body})
        .then( response => {
           this.body = '';
           flash('Your reply has been posted.');
           this.$emit('created',response.data);
        });
}
```

3. Hidden a table filed.
```php
protected $hidden = [
        'password', 'remember_token','email'
    ];
```