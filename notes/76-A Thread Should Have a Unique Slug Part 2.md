1. Increment slug number
```php
public function setSlugAttribute($value){
    if (static::whereSlug($slug = str_slug($value))->exists()){
        $slug = $this->incrementSlug($slug);
    }

    $this->attributes['slug'] = $slug;
}

protected function incrementSlug($slug)
{
    $max = static::whereTitle($this->title)->latest('id')->value('slug');

    if (is_numeric(substr($max,-1,1))){
        return preg_replace_callback('/(\d+)$/',function($matches){
            return $matches[1] + 1;
        },$max);
    }

    return "{$slug}-2";
}
```

2. preg_replace_callback
```php
if (is_numeric(substr($max,-1,1))){
    return preg_replace_callback('/(\d+)$/',function($matches){
        return $matches[1] + 1;
    },$max);
}
```