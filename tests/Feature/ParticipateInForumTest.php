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

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create();

        $this->post($thread->path().'/replies',$reply->toArray());
    }
    
    
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_thread (){
        $this->be(factory('App\User')->create());

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();
        $this->post($thread->path().'/replies',$reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);

    }
}
