1. Extract multiple method's check to multiple classes.

[Spam.php](../app/Inspections/Spam.php)
```php
namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body){
        foreach ($this->inspections as $inspection){
            app($inspection)->detect($body);
        }
        return false;
    }


}
```

[InvalidKeywords.php](../app/Inspections/InvalidKeywords.php)
```php
namespace App\Inspections;


use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    public function detect($body){
        foreach ($this->keywords as $keyword){
            if (stripos($body,$keyword) !== false){
                throw new Exception('Your reply contains spam.');
            }
        }
    }
}
```

[KeyHeldDown.php](../app/Inspections/KeyHeldDown.php)
```php
namespace App\Inspections;


use Exception;

class KeyHeldDown
{
    public function detect($body){
        if (preg_match('/(.)\\1{4,}/',$body)){
            throw new Exception('Your reply contains spam.');
        }
    }
}
```