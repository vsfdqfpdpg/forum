1. When find the random string in database then generate a new one.
```php
do{
    $token = str_random(25);
}while(User::where('confirmation_token',$token)->exists());
```

2. Generate a 25 character long token
```php
str_limit(md5($data['email'].str_random()),25,'')
```

3. When user confirmed, delete the token in databases.