<?php

namespace Tests\Unit;

use App\Reply;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function it_has_owner (){
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User',$reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published(){
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body (){
        $reply = create('App\Reply',['body' => '@JaneDoe wants to talk to @JohnDoe']);

        $this->assertEquals(['JaneDoe','JohnDoe'],$reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_user_names_in_the_body_within_anchor_tags (){
        $reply = new Reply(['body' => 'Hello @Jane-Doe.']);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_knows_if_it_is_the_best_reply (){
        $reply = create('App\Reply');

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' =>$reply->id]);
        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function a_replies_body_is_sanitized_automatically (){
        $reply = make('App\Thread',['body' => '<script>alert("bad");</script><h1>This is ok.</h1>']);
        $this->assertEquals('<h1>This is ok.</h1>',$reply->body);
    }
}
