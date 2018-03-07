1. Database version
```php
php artisan migrate:refresh
```

2. Add a column to a thread table
```php
$table->unsignedInteger('visits_count')->default(0);

```

3. Incrementing each time thread is read
```php
$thread->increment('visits_count');
```

4. Get default value either call fresh() method on object or set default value on model factory
```php
$factory->define(App\Thread::class,function(Faker\Generator $faker){
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'channel_id' => function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $faker->sentence,
        'body'  => $faker->paragraph,
        'visits_count' => 0
    ];
});

// $thread = create('App\Thread')->fresh(); // Get default value on datebase.
```