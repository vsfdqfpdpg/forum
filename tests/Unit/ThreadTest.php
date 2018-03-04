<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    protected $thread;

    protected function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }

    /** @test */
    public function a_thread_can_make_string_path (){
        $this->assertEquals('/threads/'.$this->thread->channel->slug.'/'.$this->thread->id,$this->thread->path());
    }


    /** @test */
    public function a_thread_has_a_creator (){
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_reply (){
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel (){
        $this->assertInstanceOf('App\Channel',$this->thread->channel);
    }
    
    /** @test */
    public function a_thread_can_be_subscribed_to (){
        $thread = create('App\Thread');
        $this->signIn();
        $thread->subscribe();
        $this->assertEquals(1,$thread->subscriptions()->where('user_id',auth()->id())->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from (){
        $thread = create('App\Thread');
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertCount(0,$thread->subscriptions);
    }


}
