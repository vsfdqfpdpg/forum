1. Make a model policy
```php
php artisan make:policy ThreadPolicy --model=Thread
```

2. Need create a mapping between model and policy class within [AuthServiceProvider](../app/Providers/AuthServiceProvider.php)
```php
protected $policies = [
    'App\Thread' => 'App\Policies\ThreadPolicy',
];
```

3. Check permission on blade template by using can tag.
```php
@can('update',$thread) // check model's policy
    <form action="{{ $thread->path() }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-link">Delete Thread</button>
    </form>
@endcan
```

4. Add before method in policy class means running this check before any other policy check and if return true it will ignore other policies. This is only for associated policy and model.
```php
public function before(User $user){
    if ($user->name == 'offer_websites'){
        return true;
    }
}
```

5. Setting a permission for entire application we should add to [AuthServiceProvider's](../app/Providers/AuthServiceProvider.php) boot method.
```php
public function boot()
{
    $this->registerPolicies();

    Gate::before(function(User $user){
        if ($user->name == 'offer_websites') return true;
    });
}
```

6 Authorisation on controller.
```php
$this->authorize('update',$thread);
```

7 Manual check permission on controller.
```php
if ($thread->user_id != auth()->id()){
    if (request()->wantsJson()){
        return response(['status' => 'Permission Denied'],403);
    }
    return redirect('/login');
}
```