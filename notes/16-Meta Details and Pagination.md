1. The difference between call relation as method and property.
```php
// This sql will only get count.
$thread->replies()->count()

// Call relationship as property will perform sql query will get all replies with this thread and then count.
$thread->replies->count()
```

2. Model add custom getter.
```php
public function getReplyCountAttribute(){
    return $this->replies()->count();
}

// $thread->replyCount
```

3. Eager loading with relation. 
```php
// return $thread->load('replies');
// return Thread::withCount('replies')->find(51);
```

4. add Global Query scope. Automatically apply to all queries. 
```php
protected static function boot()
{
    parent::boot();
    static::addGlobalScope('replyCount',function ($builder){
        $builder->withCount('replies');
    });
}
```

5. Word plural.
```php
{{ str_plural('comment',$thread->replies_count) }}
```

6. Pagination
```php
public function show($channelId,Thread $thread)
{
    return view('threads.show',[
     'thread'  => $thread,
     'replies' => $thread->replies()->paginate(25) // The data need paginate.
    ]);
}

{{ $replies->links() }} // Get link from view.
```