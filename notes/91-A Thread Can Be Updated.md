1. Make a test.
```php
php artisan make:test UpdateThreadTest
```

2. Tap
```php
tap($thread->fresh(),function($thread){
    $this->assertEquals('Changed',$thread->title);
    $this->assertEquals('Changed body',$thread->body);
});
```

3. Test
```php
use RefreshDatabase;
```