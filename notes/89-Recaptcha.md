1. Zttp a wrapper of Guzzle  
```php
composer require kitetail/zttp
```

2. .env variable setup
```php
RECAPTCHA_SECRET=
```

3. Set env variable in [config/services.php](../config/services.php)

```php
'recaptcha' =>[
        'secret' => env('RECAPTCHA_SECRET')
    ]
```

4. Get config value
```php
config('services.recaptcha.secret');
```