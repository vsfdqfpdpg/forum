1. Delete trending thread.
```php
redis-cli
del trending_threads
```
2. Toggle classes.
```php
<div :id="'reply-'+id" class="panel" :class="isBest ? 'panel-success' : 'panel-default'">
```