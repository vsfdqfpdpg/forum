1. Create a notification in tinker.
```php
App\User::first()->notify(new App\Notifications\ThreadWasUpdated(App\Thread::first(),App\Reply::first()));
```

2. Create a notification factory model.
```php
$factory->define(\Illuminate\Notifications\DatabaseNotification::class,function(Faker\Generator $faker){
   return [
     'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
     'type' => 'App\Notifications\ThreadWasUpdated',
     'notifiable_id' => function(){
       return auth()->id() ?: factory('App\User')->create()->id;
     },
    'notifiable_type' => 'App\User',
    'data' => ['foo' => 'bar']
   ];
});
```