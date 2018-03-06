1. Change model attribute value before saving into databases;
```php
public function setBodyAttribute($body){
    $this->attributes['body'] = preg_replace('/@([\w\-]+)/','<a href="/profiles/$1">$0</a>',$body);
}
```