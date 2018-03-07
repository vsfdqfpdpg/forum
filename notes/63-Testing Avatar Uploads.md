1. Create a new test.
```php
php artisan make:test AddAvatarTest
php artisan make:controller 'Api\UserAvatarController'
```

2. File upload test and save file to disk.
```php
public function a_user_may_add_an_avatar_to_their_profile (){
    $this->signIn();

    Storage::fake('public'); // This will clean up public directory every time

    $this->json('POST','/api/users/'.auth()->id().'/avatar',
        ['avatar' => $file = UploadedFile::fake()->image('avatar.jpg')]); // create an images

    $this->assertEquals('avatars/'.$file->hashName(),auth()->user()->avatar_path);

    Storage::disk('public')->assertExists('avatars/'.$file->hashName()); // check images exists
}


public function store()
{
    $this->validate(request(),[
        'avatar' => 'required|image'
    ]);

    auth()->user()->update([
        // Save image
        'avatar_path' => request()->file('avatar')->store('avatars','public')
    ]);

    return back();

}
```