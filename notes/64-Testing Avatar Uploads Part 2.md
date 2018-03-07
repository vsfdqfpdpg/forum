1. Create a policy
```php
php artisan migrate:refresh
php artisan make:policy UserPolicy
php artisan storage:link
```

2.
```php
public function avatar(){
    return asset($this->avatar_path ?: 'avatars/default.jpg');
}
```