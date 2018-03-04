> Given we have a thread.       
> And an authenticated user.        
> When the user subscribes to the thread.        
> Then we should be able to fetch all threads that the user has subscribed to.

1. Test from tinker
```php
$thread = App\Thread::latest()->first();
$thread->subscribe(1);
$thread->unsubscribe(1);
```