1. Get vue parent data by using $parent syntax.
```html
<p v-if="$parent.locked"> This thread has been locked. No more replies are allowed.</p>
<new-reply @created="add" v-else></new-reply>
```

2. Vue pass data

> shared state   
> event passing   
> props pass down   
> vuex   
> $parent  
> vue.prototype