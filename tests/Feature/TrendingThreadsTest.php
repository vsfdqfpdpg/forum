<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Redis::del('trending_threads');
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read (){
        $this->assertEmpty(Redis::zrevrange('trending_threads',0,-1));

        $thread = create('App\Thread');

        $this->call('GET',$thread->path());

        $trending = Redis::zrevrange('trending_threads', 0, -1);
        $this->assertCount(1, $trending);
    }
    
    
}
