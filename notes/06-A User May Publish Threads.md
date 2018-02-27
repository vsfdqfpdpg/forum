1. Create a test named [CreateThreadsTest](../tests/Feature/CreateThreadsTest.php)
```php
php artisan make:test CreateThreadsTest
```
> Given we have an sign in user
> When we hit the endpoint to create a new thread
> Then, when we visit the thread page.
> We should see the new thread.
2. dd
```php
dd($request->all());
```

3. Make Raw Create
```php

factory('App\Thread')->make();   // Create an object but not store to database. 

factory('App\Thread')->raw();    // Create data and return an array

factory('App\Thread')->create(); // Create an object and save to database

// These two methods do two different things, “create” attempts to store it in the database and is the same as saving in Eloquent. 
// Make on the other hand creates the model but doesn’t actually insert.
```

4 Middleware only for specific method
```php
public function __construct()
{
    $this->middleware('auth')->only('store');
}
```

5 Model create an record.
```php
public function store(Request $request)
{
    $thread =Thread::create([
        'user_id' => auth()->id(),
        'title'   => request('title'),
        'body'    => request('body')
    ]);

    return redirect($thread->path());
}
```