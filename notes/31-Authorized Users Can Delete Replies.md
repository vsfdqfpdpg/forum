1. Setting up a policy
* make a policy with model
```php
php artisan make:policy ReplyPolicy --model=Reply
```

* Add a policy mapping to [AuthServiceProvider.php](../app/Providers/AuthServiceProvider.php) file
```php
protected $policies = [
    'App\Thread' => 'App\Policies\ThreadPolicy',
    'App\Reply' => 'App\Policies\ReplyPolicy'
];
``` 

* Setting up policy role
```php
public function update(User $user, Reply $reply)
{
    return $reply->user_id == $user->id;
}
```

* Using policy in controller
```php
$this->authorize('update',$reply);
```

* Using policy in blade
```php
@can('update',$reply)
    <div class="panel-footer">
        <form action="/replies/{{ $reply->id }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
        </form>
    </div>
@endcan
```