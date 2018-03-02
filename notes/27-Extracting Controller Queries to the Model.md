> Given we have a thread.   
> And another thread from a week ago.  
> When we fetch their thread   
> Then, it should be returned in the proper format.   

1. Carbon get a week ago.
```php
create('App\Thread',[
    'user_id' => auth()->id(),
    'created_at' => Carbon::now()->subWeek() // This only chane thread created_at not the activity
]);
```

2. Updating a row by using relation.
```php
auth()->user()->activity()->first()->update(['created_at'=> Carbon::now()->subWeek()]);
```