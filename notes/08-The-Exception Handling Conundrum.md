1. Setup resourceful controller endpoint
```php
Route::resource('/threads','ThreadController');
```

2. Selectively enable [exceptions](https://gist.github.com/adamwathan/125847c7e3f16b88fa33a9f8b42333da). [TestCase.php](../tests/TestCase.php) [TestHandler](../app/Exceptions/TestHandler.php)
```php
<?php
namespace Tests;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp()
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
        
        //php anonymous class
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}
            public function report(\Exception $e) {}
            public function render($request, \Exception $e) {
                throw $e;
            }
        });
    }
    protected function withExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
        return $this;
    }
}
```
```php
/** @test */
public function guests_cannot_see_the_create_page (){
    $this->withExceptionHandling()
        ->get('/threads/create')
        ->assertRedirect('/login');
}
```

3. Middleware except specific actions
```php
$this->middleware('auth')->except(['index','show']);
```