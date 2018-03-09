1. Cast value whenever get a value from model.
```php
protected $casts = ['locked' => 'boolean'];
```

2. Ternary
```html
<button class="btn btn-default" v-if="authorize('isAdmin')" @click="toggleLock" v-text="locked ? 'Unlock' : 'Lock'"></button>
axios[this.locked ? 'delete' : 'post']('/locked-threads/'+this.thread.slug);
```