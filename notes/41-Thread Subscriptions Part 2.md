1. Add middleware to route definition.
```php
Route::post('/threads/{channel}/{thread}/subscriptions','ThreadSubscriptionController@store')->middleware('auth');
```