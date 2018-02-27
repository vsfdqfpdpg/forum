1. Autoload php files
```php
"autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
    },
    "files" : [
        "tests/utilities/functions.php"
    ]
},

// update composer change
composer dump-autoload -o
```

2. Sign in an user. 
```php
protected function signIn($user = null){
    $user = $user ?: create('App\User');
    $this->actingAs($user);
    return $this;
}
```