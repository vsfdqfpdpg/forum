1. Add custom attribute to a model and when need json or array data including this data.
```php
// model
protected $appends = ['favoritesCount','isFavorited'];

// custom attribute
public function getIsFavoritedAttribute(){
    return $this->isFavorited();
}

public function getFavoritesCountAttribute()
{
    return $this->favorites->count();
}
```

2. Vue create child component
```vue
import Favorite from './Favorite';
export default {
    components : { Favorite }
}
```

3. Vue computed property
```vue
computed: {
    classes() {
        return ['btn', this.active ? 'btn-primary' : 'btn-default'];
    },
    endpoint() {
        return '/replies/' + this.reply.id + '/favorites';
    }
}
```

```html
<button :class="classes" @click="toggle"> // computed property in html
```

```html
create() {
    axios.post(this.endpoint);  // computed property in javascript
    this.active = true;
    this.count++;
}
```

5. When reference a relationship twice, the second time will be the same as first one. When need a new instance, should call fresh method.
```php
$this->assertCount(0,$reply->fresh()->favorites);
```