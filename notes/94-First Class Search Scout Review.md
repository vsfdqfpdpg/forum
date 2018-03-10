1. [scout](https://laravel.com/docs/5.5/scout) and [algolia](https://www.algolia.com)
```php
composer require laravel/scout
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
composer require algolia/algoliasearch-client-php

php artisan list scout
php artisan scout:import 'App\Thread'
```