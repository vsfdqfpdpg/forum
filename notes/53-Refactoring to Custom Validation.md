1. Register customer validation rules in [AppServiceProvider.php](../app/Providers/AppServiceProvider.php).
```php
\Validator::extend('spamfree','App\Rules\SpamFree@passes');
```


2. Create class and implement the function.
```php
namespace App\Rules;

use App\Inspections\Spam;

class SpamFree{

    public function passes($attribute, $value){

        try {
            return ! resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {
            return false;
        }
    }
}
```

3. Setup relevant message [validation.php](../resources/lang/en/validation.php)
```php
'spamfree'             => 'The :attribute contains spam',
```