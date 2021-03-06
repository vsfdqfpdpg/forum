<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filter\ThreadFilter;
use App\Rules\Recaptcha;
use App\Thread;
use App\Trending;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Zttp\Zttp;

class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilter $filter
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);
        if (request()->wantsJson()){
            return $threads;
        }

        return view('threads.index',['threads' =>$threads,'trending' => $trending->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'title' => 'required|spamfree',
            'body'  => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);

        $thread =Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'   => request('title'),
            'body'    => request('body')
        ]);

        if (request()->wantsJson()){
            return response($thread,201);
        }

        return redirect($thread->path())
            ->with('flash','Your thread has been published.');
    }

    /**
     * Display the specified resource.
     *
     * @param $channelId
     * @param  \App\Thread $thread
     * @param Trending $trending
     * @return \Illuminate\Http\Response
     */
    public function show($channelId,Thread $thread, Trending $trending)
    {
        // Record that the user visited this page.
        // Record a timestamp

        if (auth()->check()){
            auth()->user()->read($thread);
        }

        $trending->push($thread);
        $thread->increment('visits_count');

        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update($channel,Thread $thread,Request $request)
    {
        // authorization
        // validation
        // update the thread
        $this->authorize('update',$thread);

        $thread->update(request()->validate([
            'title' => 'required|spamfree',
            'body'  => 'required|spamfree'
        ]));

        return $thread;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update',$thread);
        $thread->delete();
        if (request()->wantsJson()){
            return response([],204);
        }

        return redirect('/threads');
    }

    /**
     * @param Channel $channel
     * @param ThreadFilter $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilter $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(5);
    }

}
