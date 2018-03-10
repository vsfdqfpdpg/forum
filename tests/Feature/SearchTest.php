<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads (){
        config(['scout.driver' =>'algolia']);
        $search = 'foobar';

        create('App\Thread',[],2);
        $desiredThreads = create('App\Thread',['body' => "A thread with the {$search} term."],2);

        do{
            $results = $this->getJson('/threads/search?q='.$search)->json()['data'];
        }while(empty($results));

        $this->assertCount(2, $results);

        $desiredThreads->unsearchable();
        // Thread::latest()->take(4)->unsearchable();
    }


}
