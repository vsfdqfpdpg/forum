1. artisan
```php
php artisan make:test BestReplyTest
php artisan make:controller BestReplyController
```

2. abort_if
```php
abort_if($reply->thread->user_id !== auth()->id(),403);
```