<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function unauthenticated_users_may_not_add_replies (){
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');
        $reply = create('App\Reply');

        $this->post($thread->path().'/replies',$reply->toArray());
    }
    
    
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_thread (){
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');
        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);

    }

    /** @test */
    public function a_reply_requires_a_body (){
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply  = make('App\Reply',['body' => null ]);

        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_users_cannot_delete_replies (){
        $this->withExceptionHandling();
        $reply = create('App\Reply');
        $this->delete('/replies/'.$reply->id)
            ->assertRedirect('login');

        $this->signIn()
            ->delete('/replies/'.$reply->id)
            ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_uses_can_delete_replies (){
        $this->signIn();
        $reply = create('App\Reply',['user_id' => auth()->id()]);

        $this->delete('/replies/'.$reply->id)
            ->assertStatus(302);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);
    }
    
    
}
