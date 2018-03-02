1. When delete a thread also need delete associated replies with its.
* Delete in destroy method.
```php
public function destroy($channel,Thread $thread)
{
    $thread->replies()->delete();
    $thread->delete();
    if (request()->wantsJson()){
        return response([],204);
    }

    return redirect('/threads');
}
```

* Delete within model's deleting event
```php
protected static function boot()
{
    parent::boot();
    static::addGlobalScope('replyCount',function ($builder){
        $builder->withCount('replies');
    });

    static::addGlobalScope('creator',function ($builder){
        $builder->with('creator');
    });

    static::deleting(function($thread){
        $thread->replies()->delete();
    });
}
```

*　Delete on database level
```php
$table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
```
2 PHPUnit [delete and json method](../tests/Feature/CreateThreadsTest.php)
```php
/** @test */
public function guest_cannot_delete_threads (){
    $this->withExceptionHandling();
    $thread = create('App\Thread');
    $this->delete($thread->path())
        ->assertRedirect('/login');
}



/** @test */
public function a_thread_can_be_deleted (){
    $this->signIn();
    $thread = create('App\Thread');
    $reply  = create('App\Reply',['thread_id'=> $thread->id]);

    $this->json('DELETE',$thread->path())
        ->assertStatus(204);

    $this->assertDatabaseMissing('threads',['id' => $thread->id]);
    $this->assertDatabaseMissing('replies',['id' => $reply->id]);
}
```