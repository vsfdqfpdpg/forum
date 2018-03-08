1. Replacing thread's address with slug
```php
str_slug(request('title'));
```

2. Overwrite getRoutKeyName function
```php
public function getRouteKeyName()
{
    return 'slug';
}
```