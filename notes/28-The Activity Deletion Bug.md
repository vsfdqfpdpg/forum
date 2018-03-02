1. A higher order messaging on laravel collections
```php
static::deleting(function($thread){
    $thread->replies->each->delete();
    /*
        $thread->replies->each(function ($reply){
            $reply->delete();
        });
    */
});
```

2. Model deleting event.
```php
static::deleting(function($model){
    $model->activity()->delete();
});
```