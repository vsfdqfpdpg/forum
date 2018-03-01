1. Share variable to specific views. Registered in [AppServiceProvider](../app/Providers/AppServiceProvider.php)
```php
public function boot()
{
    Schema::defaultStringLength(191);
    \View::composer(['threads.create','layouts.app'],function ($view){
        $view->with('channels',Channel::all());
    });
}
```

2. Share variables to all views.
```php
public function boot()
{
    Schema::defaultStringLength(191);
    \View::composer('*',function ($view){ // This will run only when the view is loaded.
        $view->with('channels',Channel::all());
    });
}
```

```php
public function boot()
{
    Schema::defaultStringLength(191);
    \View::share('channels',Channel::all()); // This will run before Database Migrations
}
```