1. Polymorphism
```php
// main model
public function activity(){
    return $this->morphMany('App\Activity','subject');
}

// sub model
public function subject(){
    return $this->morphTo();
}
```

2. When trait has a method named boot plus its class name will be called automatically by its model. [RecordsActivity](../app/RecordsActivity.php)
```php
protected static function bootRecordsActivity(){
    if (auth()->guest()) return;
    foreach (static::getActivityToRecord() as $event){
        static::$event(function($model) use($event){
            $model->recordActivity($event);
        });
    }
}
```

3. Create a record by its polymorphic relation its id and type fields will automatically insert by laravel.
```php
protected function recordActivity($event)
{
    /*Activity::create([
        'user_id' => auth()->id(),
        'type' => $this->getActivityType($event),
        'subject_id' => $this->id,
        'subject_type' => get_class($this)
    ]);*/
    $this->activity()->create([
        'user_id' => auth()->id(),
        'type' => $this->getActivityType($event)
    ]);
}

public function activity(){
    return $this->morphMany('App\Activity','subject');
}
```

4. Get class name by using reflection class
```php
new ReflectionClass($this);
```