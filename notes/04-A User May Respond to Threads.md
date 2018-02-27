1. Create a partial and include a it.
```php
@include('threads.reply')
```

2. Filter a single test
```php
vendor/bin/phpunit --filter a_thread_has_a_creator
```

3. Create a test for participate in forum. Filename need include Test
```php
php artisan make:test ParticipateInForumTest
```

4. an_authenticated_user_may_participate_in_forum_thread 

> Given we have an authenticated user
> And an existing thread
> When the user adds a reply to the thread
> Then their reply should be visible on the page.

5. Throw Exception when is in testing mode. [Handler.php](../app/Exceptions/Handler.php)
```php
public function render($request, Exception $exception)
{
    if (app()->environment() === 'testing') throw $exception;
    return parent::render($request, $exception);
}
```

6. MassAssignmentException
```php
protected $guarded = [];
protected $fillable = ['body','user_id'];
```

7. Controller setup middleware
```php
public function __construct()
{
    $this->middleware('auth');
}
```

8. Phpunit catch specific exception
```php
$this->expectException('Illuminate\Auth\AuthenticationException');
``` 