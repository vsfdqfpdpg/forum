> Given i have a user, JohnDoe, who is signed in   
> And another user, JaneDoe.   
> If we have a thread   
> And JohnDoe replies and mentions @JaneDoe.   
> Then JaneDoe should be notified.  

1. Mention user
```php
php artisan make:test MentionUsersTest

php artisan make:notification YouWereMentioned
```

2. Create a notification class [YouWereMentioned.php](../app/Notifications/YouWereMentioned.php)
```php
public function via($notifiable)
{
    return ['database'];
}

public function toArray($notifiable)
{
    return [
        'message' => $this->reply->owner->name . ' mentioned you in ' .$this->reply->thread->title,
        'link' => $this->reply->path()
    ];
}

// Call in controller
$user->notify(new YouWereMentioned($reply));
```