1. Create a form request handel.
```php
php artisan make:request CreatePostForm

public function authorize()
{
    return Gate::allows('create',new Reply());
}

protected function failedAuthorization()
{
    throw new ThrottleException('You are posting too frequently. Please take a break. :)');
}

public function rules()
{
    return [
        'body' => 'required|spamfree'
    ];
}

public function persist($thread){
    return $thread->addReply([
        'body' => request('body'),
        'user_id' => auth()->id()
    ])->load('owner');
}
```

2. Call form request from controller.
```php
public function store($channelId,Thread $thread, CreatePostForm $form){
    // Only execute when authorization passed. 
    return $form->persist($thread);
}
```