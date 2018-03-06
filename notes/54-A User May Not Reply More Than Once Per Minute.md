1. Gate facade
```php
if (Gate::denies('create',new Reply())){
    return response('You are posting too frequently. Please take a break. :)',422);
}
```

2. Reply police for create
```php
public function create(User $user)
{
    $lastReply = $user->fresh()->lastReply;

    if (! $lastReply) return true;

    return ! $lastReply->wasJustPublished();
}
```

3. Carbon compare one minute ago.
```php
public function wasJustPublished(){
    return $this->created_at->gt(Carbon::now()->subMinute());
}
```