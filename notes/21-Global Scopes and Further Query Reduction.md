1. Model's property $with will eager load all relation data with every single query.
```php
protected $with = ['owner','favorites']; // Load owner and favorites relation
```

2. addGlobalScope can disabled by calling Model::withoutGlobalScope()
```php
protected static function boot()
{
    parent::boot();
    static::addGlobalScope('replyCount',function ($builder){
        $builder->withCount('replies');
    });

    static::addGlobalScope('creator',function ($builder){
        $builder->with('creator');
    });
}
```