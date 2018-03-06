<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostForm;
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

    public function store($channelId,Thread $thread, CreatePostForm $form){
        return $form->persist($thread);
    }

    public function update(Reply $reply){
        $this->authorize('update',$reply);

        try {
            $this->validate(request(),['body' => 'required|spamfree']);
            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.',422);
        }
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
