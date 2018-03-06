1. Add event to handel when received a reply
```php
protected $listen = [
    'App\Events\ThreadHasNewReply' => [

    ],
    'App\Events\ThreadReceivedNewReply' => [
        'App\Listeners\NotifyMentionedUsers',
        'App\Listeners\NotifyThreadSubscribers'
    ],
];
```

2. Collect and filter
```php
collect($event->reply->mentionedUsers())
    ->map(function($name){
        return User::whereName($name)->first();
    })
    ->filter()
    ->each(function($user) use($event){
        $user->notify(new YouWereMentioned($event->reply));
    });
```