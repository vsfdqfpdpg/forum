<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class MentionUsersTest extends TestCase
{
   use DatabaseMigrations;

   /** @test */
   public function mentioned_users_in_a_reply_are_notified (){
        $john = create('App\User',['name' =>'JohnDoe']);

        $this->signIn();

        $jane = create('App\User',['name' => 'JaneDoe']);

        $thread = create('App\Thread');

        $reply = make('App\Reply',[
            'body' => '@JaneDoe look at this.'
        ]);

        $this->json('post',$thread->path().'/replies',$reply->toArray());

        $this->assertCount(1, $jane->notifications);
   }


}
