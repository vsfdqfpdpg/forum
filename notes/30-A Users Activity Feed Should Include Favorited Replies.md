1. Check view if exist.
```php
view()->exists("profiles.activities.{$record->type}");
```

2. hash jump to css id
```html
<div id="reply-11"></div>

<a href="#reply-11">reply-11</a> 
```