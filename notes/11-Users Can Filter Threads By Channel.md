1. Get channel data by using channel slug
```php
public function index($channelSlug = null)
{
    if ($channelSlug){
        $channelId = Channel::where('slug',$channelSlug)->first()->id;
        $threads = Thread::where('channel_id',$channelId)->latest()->get();
    }else{
        $threads = Thread::latest()->get();
    }
    return view('threads.index',compact('threads'));
}
```
2. Get channel data by using Rout model binding, need change [route key name](../app/Channel.php), because we give slug instead of default primary key.
```php
public function index(Channel $channel)
{
    if ($channel->exists){
        $threads = $channel->threads()->latest()->get();
    }else{
        $threads = Thread::latest()->get();
    }
    return view('threads.index',compact('threads'));
}
```

3. contains
```php
public function a_channel_consists_of_threads (){
    $channel = create('App\Channel');
    $thread = create('App\Thread',['channel_id' => $channel->id]);

    $this->assertTrue($channel->threads->contains($thread));
}
```

4. The concrete route need register before that one has wildcard.
```php
Route::get('/threads/create','ThreadController@create');
Route::get('/threads/{channel}','ThreadController@index');
```