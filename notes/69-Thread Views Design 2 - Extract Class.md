1. Class version of compound word refactor.
2. Extracting a repeatedly world to become a class name.
```php
recordVisit
resetVisits
visitsCacheKey

class Visit{
 public function record(){}
 public function reset(){}
 public function cacheKey(){}
}
```