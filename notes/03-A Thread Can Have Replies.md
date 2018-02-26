1. Set up a test from thread
> Given we have a thread   
> And that thread includes replies   
> When we visit a thread page   
> Then we should see the replies. 

2. Overwrite test class setUp method, this setUp method like constructor.
```php
protected function setUp()
{
    parent::setUp();
    $this->thread = factory('App\Thread')->create();
}
```   

3. Make a [Reply Unit Test](../tests/Unit/ReplyTest.php)
```php
php artisan make:test ReplyTest --unit
```

4. Test a single unit file
```php
vendor/bin/phpunit tests/Unit/ReplyTest.php
``` 

5. Setup Reply and User relationship.
```php
public function owner(){
    // if function name is not the same as table foreignKey plus id, you need provide foreign key as second parameter.
    return $this->belongsTo(User::class,'user_id');
}
```