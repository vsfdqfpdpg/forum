1. Create a test for thread testing relationship between thread and channel.
```php
/** @test */
public function a_thread_belongs_to_a_channel (){
    $this->assertInstanceOf('App\Channel',$this->thread->channel);
}
```

2. Create a Channel Model
```php
php artisan make:model Channel -m
```

3. Setup relationship between thread and channel
```php
public function channel(){
    return $this->belongsTo(Channel::class);
}
```

4. Add channel_id to create thread table otherwise there is not link between thread and channel.
```php
Schema::create('threads', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('user_id');
    $table->unsignedInteger('channel_id');
    $table->string('title');
    $table->text('body');
    $table->timestamps();
});
```

5. Change Thread's blueprint and add Channel blueprint
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
        'body'  => $faker->paragraph
    ];
});

$factory->define(App\Channel::class,function(Faker\Generator $faker){
    $name = $faker->name;
    return [
        'name' => $name,
        'slug' => $name
    ];
});
```

5. Setup Channel table with its columns.
```php
Schema::create('channels', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name',50);
    $table->string('slug',50);
    $table->timestamps();
});
```

6. Route's parameter numbers must be match associated controller's number.
```php
Route::get('/threads/{channel}/{thread}','ThreadController@show');

public function show($channelId,Thread $thread)
{
    return view('threads.show',compact('thread'));
}
    
Route::post('/threads/{channel}/{thread}/replies','ReplyController@store');

public function store($channelId,Thread $thread){
    $thread->addReply([
        'body' => request('body'),
        'user_id' => auth()->id()
    ]);

    return back();
}
```

7. Get header from http response.
```php
public function an_authenticated_user_can_create_new_forum_threads (){
    $this->signIn();
    $thread = make('App\Thread');
    $response = $this->post('/threads',$thread->toArray());

    $this->get($response->headers->get('Location'))
        ->assertSee($thread->title)
        ->assertSee($thread->body);
}
```