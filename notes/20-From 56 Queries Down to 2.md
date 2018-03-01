1. Install [laravel-debugbar](https://github.com/barryvdh/laravel-debugbar/tree/2.4) and register in [AppServiceProvider.php](../app/Providers/AppServiceProvider.php)
```php
composer require barryvdh/laravel-debugbar:~2.4

// register
public function register()
{
    if ($this->app->isLocal()){
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
    }
}
```

2. Cache Database result. [AppServiceProvider.php](../app/Providers/AppServiceProvider.php)
```php
public function boot()
{
    Schema::defaultStringLength(191);
    \View::composer('*',function ($view){ // This will run only when the view is loaded.
        $channels = Cache::rememberForever('channels',function (){
            return Channel::all();
        });
        $view->with('channels',$channels);
    });
}
```

3. [Thread](../app/Thread.php) Eager loading
```php
public function replies(){
    return $this->hasMany(Reply::class)
        ->withCount('favorites')
        ->with('owner');
}
```

