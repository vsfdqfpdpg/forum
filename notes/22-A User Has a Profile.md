1. Named route
```php
Route::get('/profiles/{user}','ProfileController@show')->name('profile');

{{ route('profile',$thread->creator) }}
{{ route('profile', $reply->owner)
```

2. Always get latest records.
```php
public function threads(){
    return $this->hasMany(Thread::class)->latest();
}
```