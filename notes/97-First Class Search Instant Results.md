1. Change the data before push to algolia
```php
public function toSearchableArray()
{
    return $this->toArray() + ['path' => $this->path()];
}
```

2.  Only view for a route.
```php
Route::view('scan','scan');
```

3. Import vue-instantsearch
```php
import InstantSearch from 'vue-instantsearch';

Vue.use(InstantSearch);
```