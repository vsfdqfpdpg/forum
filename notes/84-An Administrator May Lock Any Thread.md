1.  Add locked function
```php
php artisan make:test LockThreadsTest
```

2.  Add lock to thread table
```php
$table->boolean('locked')->default(false);


$factory->define(App\Thread::class,function(Faker\Generator $faker){
    $title = $faker->sentence;
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'channel_id' => function(){
            return factory('App\Channel')->create()->id;
        },
        'title' => $title,
        'body'  => $faker->paragraph,
        'visits_count' => 0,
        'slug' => str_slug($title),
        'locked' => false // If not specified here, You need a fresh copy of the model
    ];
});
```