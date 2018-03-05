1. Mysql or php way to filter data.
```php
$this->subscriptions->filter(function ($subscription) use($newReply){
    return $subscription->user_id != $newReply->user_id;
})->each->notify($newReply);

$this->subscriptions->where('user_id','!=',$newReply->user_id)->each->notify($newReply);
```

2. Generate event and listener from [EventServiceProvider.php](../app/Providers/EventServiceProvider.php) $listen fileds.
```php

protected $listen = [
    'App\Events\ThreadHasNewReply' => [
        'App\Listeners\NotifyThreadSubscribers',
    ],
];

php artisan event:generate


```

3. [NotifyThreadSubscribers.php](../app/Listeners/NotifyThreadSubscribers.php) handle method will invoke when receive an event.
```php

event(new ThreadHasNewReply($this,$newReply)); // Fire an event from controller

public function handle(ThreadHasNewReply $event)
{
    $event->thread->notifySubscribers($event->reply);
}
```