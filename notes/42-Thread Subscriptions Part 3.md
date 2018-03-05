1. Rollback recent migration.
```php
php artisan migrate:rollback
```

2. Model append custom getter.
```php
protected $appends = ['isSubscribedTo'];

public function getIsSubscribedToAttribute(){
    return $this->subscriptions()->where('user_id',auth()->id())->exists();
}

// call in controller.
$thread->append('isSubscribedTo');
```

3. Toggle boolean value.
```html
this.active = ! this.active ;
```

4. Vue bind json value.
```html
<subscribe-button :initial-active="{{ json_encode($thread->isSubscribedTo) }}" ></subscribe-button>
```

5. Avoid mutating a prop directly since the value will be overwritten whenever the parent component re-renders. Instead, use a data or computed property based on the prop's value
```html
props:[ 'initialActive' ],
data(){
  return { active : this.initialActive };
}
```