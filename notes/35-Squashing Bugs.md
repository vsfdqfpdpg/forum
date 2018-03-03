1. Model event need a model.
```php
public function unFavorite()
{
    $attributes = ['user_id' => auth()->id()];
    $this->favorites()->where($attributes)->delete(); // This is a sql query that will never tigger an model deleting event.
}
```

```php
public function unFavorite()
{
    $attributes = ['user_id' => auth()->id()];
    $this->favorites()->where($attributes)->get()->each->delete(); // Get will get the collection of the model and delete each one.
}
```

```php
trait Favoritable
{
    // If the associated model is ever deleted, as the part of the deletion, I also want you to delete any of the favorites for the model. 
    protected static function bootFavoritable(){
        static::deleting(function($model){
            $model->favorites->each->delete();
        });
    }
}
```

2. Relation's return
```php
$model->favorites   // This is a collection
$model->favorites() // This is a query object

$this->favorites()->where($attributes)        // This is a query object
$this->favorites()->where($attributes)->get() // Get the collection
```

3. Check user is login in.
```php
Auth::check()
```