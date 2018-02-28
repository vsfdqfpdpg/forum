1. Error catching flow.
> Exception turn off by default.
> * If there is no validate for that field it will failed at databases level. `Illuminate\Database\QueryException`
> * If it has validate rules will failed at validation level. `Illuminate\Validation\ValidationException`

> Exception catch turned on.
> * If it has validate rules. It will redirect back with session errors.

2. Validate for form data.
```php
public function store(Request $request)
{
    $this->validate($request,[
        'title' => 'required',
        'body'  => 'required',
        'channel_id' => 'required|exists:channels,id'
    ]);
    $thread =Thread::create([
        'user_id' => auth()->id(),
        'channel_id' => request('channel_id'),
        'title'   => request('title'),
        'body'    => request('body')
    ]);

    return redirect($thread->path());
}
```

3. [Validation helpers](https://laravel.com/docs/5.4/validation#available-validation-rules)
```php
'channel_id' => 'required|exists:channels,id'

// channel_id is required and must be exist in channels table in id filed.
```

4. Get request data from controller.
```php
// by using request method.
request()

// Add a request parameter as method last argument.
public function store($channelId,Thread $thread,Request $request){}

```