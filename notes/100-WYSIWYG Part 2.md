1. Ignore escape html entity.
```html
{!! $thread->body !!}
```

2. Watch property
```html
this.$watch('shouldClear',()=>{
    this.$refs.trix.value = '';
});
```