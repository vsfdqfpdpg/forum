1. Create a middleware
```php
php artisan make:middleware RedirectIfEmailNotConfirmed
```

2. Register a middleware in [Kennel.php](../app/Http/Kernel.php)
```php
protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'must-be-confirmed' => RedirectIfEmailNotConfirmed::class
    ];
```

3. Using middleware in route file 
```php
Route::post('/threads','ThreadController@store')->middleware('must-be-confirmed');
```