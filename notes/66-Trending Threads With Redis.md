1. Redis
```php
composer require predis/predis
php artisan make:test TrendingThreadsTest
```

2. Redis set
```php
zincrby 'trending_threads' 1 'Some thread title'
zincrby 'trending_threads' 1 'Another thread title'

zrevrange 'trending_threads' 0 -1
zrange 'trending_threads' 0 -1 WITHSCORES
zrevrange 'trending_threads' 0 -1 WITHSCORES
del trending_threads
```

3. Url function
```php
<a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
```

4. Get request
```php
$this->call('GET',$thread->path());
```