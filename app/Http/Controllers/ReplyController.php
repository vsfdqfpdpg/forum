<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => 'index' ]);
    }

    public function index($channelId,Thread $thread){
        return $thread->replies()->paginate(25);
    }

    public function store($channelId,Thread $thread,Request $request, Spam $spam){
        $this->validate($request,['body' => 'required']);

        $spam->detect($request->body);

        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if (request()->expectsJson()){
            return $reply->load('owner');
        }

        return back()
            ->with('flash','Your reply has been left.');
    }

    public function update(Reply $reply){
        $this->authorize('update',$reply);
        $reply->update(request(['body']));
    }

    public function destroy(Reply $reply){
        $this->authorize('update',$reply);
        $reply->delete();
        if (request()->wantsJson()){
            return response(['status' =>'Reply deleted.']);
        }
        return back();
    }
}
