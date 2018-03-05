1. Cache user visited a page.
```php
// Cache key 

public function visitedThreadCacheKey($thread){
    return sprintf("users.%s.visits.%s",$this->id,$thread->id);
}

// Cache visited data
if (auth()->check()){
    auth()->user()->read($thread);
}

public function read($thread){
    cache()->forever($this->visitedThreadCacheKey($thread), Carbon::now());
}

// Compare the thread's last update and user last visited time
public function hasUpdatesFor($user){
    // Look in the cache for the proper key.
    // Compare that carbon instance with the $thread->updated_at

    $key = $user->visitedThreadCacheKey($this);

    return $this->updated_at > cache($key);
}
```

