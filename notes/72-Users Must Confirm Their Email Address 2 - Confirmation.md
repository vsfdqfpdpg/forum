1. Artisan commands
```php
php artisan make:test RegistrationTest
php artisan make:mail PleaseConfirmYourEmail
php artisan make:mail PleaseConfirmYourEmail --markdown="emails.confirm-email"
php artisan event:generate
```

2. update and save
```php
// Encountered massassignment
User::where('confirmation_token',request('token'))
            ->firstOrFail()->update(['confirmed' =>true]);
            
// No massassignment        
$user = User::where('confirmation_token',request('token'))
            ->firstOrFail();
$user->confirmed = true;
$user->save();
```

3. Listening on registered event.
```php
Registered::class => [
    'App\Listeners\SendEmailConfirmationRequest'
]
```

```php
public $user; // blade can access to public field.
public function build()
{
    return $this->markdown('emails.confirm-email');
}
```