1. PHPUnit test command
```php
vendor/bin/phpunit
```

2. Setup unit test by using sqlite in memory database within [phpunit.xml](../phpunit.xml) .
```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
    <env name="CACHE_DRIVER" value="array"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="QUEUE_DRIVER" value="sync"/>
</php>
```

3. Add threads route to [web.php](../routes/web.php)
```php
Route::get('/threads','ThreadController@index');
Route::get('/threads/{thread}','ThreadController@show');
```

4. Setup scaffolding by running `php artisan make:auth`

5. Create index and show view template files.

6. ThreadController@index show all threads
```php
$threads = Thread::latest()->get();
return view('threads.index',compact('threads'));
```

7 ThreadController@show show single thread
```php
public function show(Thread $thread)
{
    return $thread; // Route model binding...
}
```

8. Setup unit test
```php
use DatabaseMigrations;
/** @test */
public function a_user_can_view_all_threads () {
    $thread = factory('App\Thread')->create();
    $response = $this->get('/threads');
    $response->assertSee($thread->title);
}

/** @test */
public function a_user_can_read_a_single_thread()
{
   $thread = factory('App\Thread')->create();
   $response = $this->get('/threads/'.$thread->id);
   $response->assertSee($thread->title);
}
```