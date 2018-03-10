1. Make a test
```php
php artisan make:test SearchTest
```

2. Scout search
```php
$threads = Thread::search($search)->paginate(30);
```

3. Setup scout driver for testing
```php
<env name="SCOUT_DRIVER" value="null"></env>
```

4. Change scout driver on the fly
```php
config(['scout.driver' =>'algolia']);
```

5. Remove testing thread when it done.
```php

$desiredThreads = create('App\Thread',['body' => "A thread with the {$search} term."],2);

$desiredThreads->unsearchable();
Thread::latest()->take(4)->unsearchable();
```