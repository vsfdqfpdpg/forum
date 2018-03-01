1. Get parameter from url and append query conditions to sql.
```php
public function index(Channel $channel)
{
    if ($channel->exists){
        $threads = $channel->threads()->latest();
    }else{
        $threads = Thread::latest();
    }

    if ($username =request('by')){
        $user = User::where('name',$username)->firstOrFail();
        $threads->where('user_id',$user->id);
    }

    $threads = $threads->get();
    return view('threads.index',compact('threads'));
}
```

2. Check if user is logged in.
```php
@if(auth()->check())
    <li><a href="/threads?by={{ auth()->user()->name }}">My Threads</a></li>
@endif
```