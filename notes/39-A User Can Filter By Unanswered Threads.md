1. Create replies for a latest thread.
```php
factory('App\Reply',30)->create(['thread_id' => App\Thread::latest()->first()->id]);
```

2. Model event auto increment and decrement.
```php
 protected static function boot()
{
    parent::boot();
    static::created(function($reply){
        $reply->thread->increment('replies_count');
    });

    static::deleted(function($reply){
        $reply->thread->decrement('replies_count');
    });
}
```