1. When thread created update slug column with the title, and the setSlugAttribute method will modify this value and return.
```php
static::created(function($thread){
    $thread->update(['slug' => $thread->title]);
});
```

```php
public function setSlugAttribute($value){
    $slug = str_slug($value);

    if (static::whereSlug($slug)->exists()){
        $slug = "{$slug}-".$this->id; // Thread has been created, we have the id.
    }

    $this->attributes['slug'] = $slug;
}
```