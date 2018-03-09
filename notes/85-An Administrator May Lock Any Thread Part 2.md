1. Make a controller and middleware 
```.php
php artisan make:controller LockedThreadController
php artisan make:middleware Administrator
```

2. Register middleware [Kernel.php](../app/Http/Kernel.php)
```php
protected $routeMiddleware = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
    'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'can' => \Illuminate\Auth\Middleware\Authorize::class,
    'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
    'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    'must-be-confirmed' => RedirectIfEmailNotConfirmed::class,
    'admin' => Administrator::class
];
```

3. Factory make a model state, overwrite default value.
```php
factory->state(App\User::class,'administrator',function(){
    return [
        'name' => 'JohnDoe'
    ];
});

$this->signIn(factory('App\User')->states('administrator')->create());
```