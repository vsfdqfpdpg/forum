> Given we have three threads   
> With 2 replies, 3 replies, 0 replies, respectively.   
> When I filter all threads by popularity   
> Then they should be returned from most replies to least.   

1. Check if need json output.
```php
public function index(Channel $channel, ThreadFilter $filters)
{
    $threads = $this->getThreads($channel, $filters);
    if (request()->wantsJson()){
        return $threads;
    }
    return view('threads.index',compact('threads'));
}
```

2. Get raw sql query from query builder.
```php
protected function getThreads(Channel $channel, ThreadFilter $filters)
{
    $threads = Thread::latest()->filter($filters);
    if ($channel->exists) {
        $threads = $threads->where('channel_id', $channel->id);
    }
    dd($threads->toSql()); // Get raw sql
    $threads = $threads->get();
    return $threads;
}
```

3. Overwrite default created_at query order by replies_count
```php
protected function popular(){
    $this->builder->getQuery()->orders = []; // Remove all other order's settings
    return $this->builder->orderBy('replies_count','DESC');
}
``` 
