1. Create a laravel project.
```
composer create-project --prefer-dist laravel/laravel forum "5.4.*"
```
2. Init a git repository and submit a commit. 
```
git init
git add .
git commit -m "First init."
git remote add origin git@github.com:vsfdqfpdpg/forum.git
git push origin master
```
3. Create a forum database and setup database connection in .env file.
```
create database forum default charset utf8;
```
4. Create Thread and Reply models.
```
php artisan make:model Thread -mr
php artisan make:model Reply -mc
```
5. Setup Thread and Reply database structure, Those file under `database/migrations` folder.   
```php
Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title');
            $table->text('body');
            $table->timestamps();
        });
```
```php
Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("user_id");
            $table->integer("thread_id");
            $table->text('body');
            $table->timestamps();
        });
```
6. Setup factory seeds. [ModelFactory.php](../database/factories/ModelFactory.php)
```php
$factory->define(App\Thread::class,function(Faker\Generator $faker){
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'title' => $faker->sentence,
        'body'  => $faker->paragraph
    ];
});

$factory->define(App\Reply::class,function(Faker\Generator $faker){
    return [
        'user_id' => function(){
            return factory('App\User')->create()->id;
        },
        'thread_id' => function(){
            return factory("App\Thread")->create()->id;
        },
        'body'  => $faker->paragraph
    ];
});
```
7. Running migration adn then using tinker seeding some data.
```php
php artisan migrate
php artisan tinker
$threads = factory('App\Thread',50)->create();
$threads->each(function($thread){factory('App\Reply',10)->create(['thread_id'=>$thread->id]);});
```

> Error: 
>> [Laravel 5.4: Specified key was too long error](https://laravel-news.com/laravel-5-4-key-too-long-error)   
>> [AppServiceProvider.php](../app/Providers/AppServiceProvider.php)   
>> ```php
>> use Illuminate\Support\Facades\Schema;
>>   public function boot()
>>   {
>>       Schema::defaultStringLength(191);
>>   }
>> ```