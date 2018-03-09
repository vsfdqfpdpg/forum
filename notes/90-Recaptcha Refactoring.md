1. Make a rule
```php
php artisan make:rule Recaptcha
```

2. Mock Recaptcha rule class, when call passes method return true
```php
app()->singleton(Recaptcha::class,function(){
    return \Mockery::mock(Recaptcha::class,function ($m){
        $m->shouldReceive('passes')->andReturn(true);
    });
});
```

3. Unbind from app container will execute passes method
```php
unset(app()[Recaptcha::class]);
```