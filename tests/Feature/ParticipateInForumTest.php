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
}
