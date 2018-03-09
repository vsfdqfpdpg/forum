<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function non_administrator_may_not_lock_thread (){

        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread',['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store',$thread))
            ->assertStatus(403);

        $this->assertFalse(!! $thread->fresh()->locked);
    }

    /** @test */
    public function administrator_can_lock_thread (){
        $this->signIn(factory('App\User')->states('administrator')->create());
        $thread = create('App\Thread',['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store',$thread));

        $this->assertTrue($thread->fresh()->locked,'Failed asserting that the thread was locked.');
    }

    /** @test */
    public function administrator_can_unlock_thread (){
        $this->signIn(factory('App\User')->states('administrator')->create());
        $thread = create('App\Thread',['user_id' => auth()->id(),'locked' => true]);

        $this->delete(route('locked-threads.destroy',$thread));

        $this->assertFalse($thread->fresh()->locked,'Failed asserting that the thread was unlocked.');
    }


    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies (){
        $this->signIn();
        $thread = create('App\Thread',['locked' => true]);

        $this->post($thread->path().'/replies',[
            'body' => 'Foobar',
            'user_id' => create('App\User')->id
        ])->assertStatus(422);
    }


}
