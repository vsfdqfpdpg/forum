<?php

namespace Tests\Unit;


use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
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
    public function a_thread_has_a_path (){
        $this->assertEquals('/threads/'.$this->thread->channel->slug.'/'.$this->thread->slug,$this->thread->path());
    }


    /** @test */
    public function a_thread_has_a_creator (){
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply (){
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1,$this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added (){
        Notification::fake();
        $this->signIn()->thread->subscribe()->addReply([
            'body' => 'Foobar',
            'user_id' => 999
        ]);
        Notification::assertSentTo(auth()->user(),ThreadWasUpdated::class);
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

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it (){
        $thread = create('App\Thread');
        $this->signIn();
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }
    
    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies (){
        $this->signIn();
        $thread = create('App\Thread');
        $user = auth()->user();
        $this->assertTrue($thread->hasUpdatesFor($user));

        // Simulate that the user visitd the thread.
        $user->read($thread);

        $this->assertFalse($thread->hasUpdatesFor($user));
    }
    
    /** @test */
    public function a_thread_records_each_visit (){
        $thread = make('App\Thread',['id' => 1 ]);

        $thread->visits()->reset();

        $this->assertSame(0,$thread->visits()->count());

        $thread->visits()->record();

        $this->assertEquals(1,$thread->visits()->count());

        $thread->visits()->record();

        $this->assertEquals(2,$thread->visits()->count());
    }

}
