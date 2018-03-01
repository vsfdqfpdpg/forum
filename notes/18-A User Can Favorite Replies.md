1. Manually setup model controller and migration.
```php
php artisan make:controll FavoriteController
php artisan make:migration create_favorite_table --create=favorites
php artisan make:model Favorite
```

2. Polymorphism
```php
public function favorites()
{
    return $this->morphMany(Favorite::class, 'favorited');
}

public function favorite()
{
    $attributes = ['user_id' => auth()->id()];
    if (!$this->favorites()->where($attributes)->exists()) {
        return $this->favorites()->create($attributes);
    }
}
```

```php
Schema::create('favorites', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('user_id');
    $table->unsignedInteger('favorited_id');
    $table->string('favorited_type',50);
    $table->timestamps();

    // set unique grouped constraint
    $table->unique(['user_id','favorited_id','favorited_type']);
});
```


3. PHPUnit custom exception message.
```php
try{
    $this->post('/replies/'.$reply->id.'/favorites');
    $this->post('/replies/'.$reply->id.'/favorites');
}catch (\Exception $e){
    $this->fail('Did not expect to insert the same record set twice.');
}
```