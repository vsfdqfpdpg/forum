<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostForm;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;
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

    public function store($channelId,Thread $thread, CreatePostForm $form){

        if ($thread->locked){
            return response(['Thread is locked'],422);
        }

        return $form->persist($thread);
    }

    public function update(Reply $reply){
        $this->authorize('update',$reply);

        request()->validate(['body' => 'required|spamfree']);
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
