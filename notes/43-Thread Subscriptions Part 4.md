1. Setup notification.
```php
php artisan notifications:table
php artisan migrate
php artisan make:notification ThreadWasUpdated
```

2. Higher Order Messaging for Collections
```php
$this->subscriptions->filter(function ($subscription) use($newReply){
            return $subscription->user_id != $newReply->user_id;
        })->each->notify($newReply);

$this->subscriptions->filter(function ($subscription) use($newReply){
    return $subscription->user_id != $newReply->user_id;
})->each(function ($subscription) use($newReply){
   $subscription->notify($newReply); 
});
```

3. [ThreadWasUpdated.php](../app/Notifications/ThreadWasUpdated.php)
```php
public function via($notifiable)
{
    return ['database']; // mail
}

public function toArray($notifiable)
{
    return [
        'message' => 'Temporary placeholder.'
    ];
}
```

4. Invoke notification.
```php
public function addReply($reply){
    $newReply = $this->replies()->create($reply);
    
    foreach ($this->subscriptions as $subscription){
          if ($subscription->user_id != $newReply->user_id){
            $subscription->user->notify(new ThreadWasUpdated($this,$newReply));
          }
    }
            
    // Collection approach
    $this->subscriptions->filter(function ($subscription) use($newReply){
        return $subscription->user_id != $newReply->user_id;
    })->each(function ($subscription) use($newReply){
        $subscription->user->notify(new ThreadWasUpdated($this,$newReply));
    });   

    $this->subscriptions->filter(function ($subscription) use($newReply){
        return $subscription->user_id != $newReply->user_id;
    })->each->notify($newReply);

    $this->subscriptions->filter(function ($subscription) use($newReply){
        return $subscription->user_id != $newReply->user_id;
    })->each(function ($subscription) use($newReply){
       $subscription->notify($newReply);
    });

    return $newReply;
}
```