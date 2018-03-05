1. Notification test support.
```php
use Illuminate\Support\Facades\Notification;
Notification::fake();
```

```php
public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added (){
    Notification::fake();
    $this->signIn()->thread->subscribe()->addReply([
        'body' => 'Foobar',
        'user_id' => 999
    ]);
    Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
}
```