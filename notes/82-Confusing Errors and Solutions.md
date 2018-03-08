1. Foreign constrains reference table must be created first. Change the migration order by changing table name timestamp.

2. Sqlite foreign constrains not enabled by default. Enable in [TestCase.php](../tests/TestCase.php)

```php
DB::statement('PRAGMA foreign_keys=on');
```