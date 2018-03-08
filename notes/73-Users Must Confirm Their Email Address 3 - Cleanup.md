1. Show all registered route.
```php
php artisan route:list
```

2. Set up factory state for rewrite.
```php
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'confirmed' => true
    ];
});

$factory->state(App\User::class,'unconfirmed',function(){
   return [
       'confirmed' => false
   ];
});
```
3. Change user confirmed status when create a user.
```php
$user = factory('App\User')->states('unconfirmed')->create();
$this->signIn($user);
```