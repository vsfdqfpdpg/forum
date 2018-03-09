1. Get laravel version
```php
php artisan -V
```

2. composer update
```json
{
  "phpunit/phpunit": "~6.0",
  "laravel/framework": "5.5.*"
}

```

3. Intersect changed
```php
return $this->request->intersect($this->filters);
return array_filter($this->request->only($this->filters));
```