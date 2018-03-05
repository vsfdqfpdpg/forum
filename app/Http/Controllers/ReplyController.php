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

    public function store($channelId,Thread $thread){

        try {
            $this->validateReply();
            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);
            if (request()->expectsJson()) {
                return $reply->load('owner');
            }
        } catch (\Exception $e) {

            return response('Sorry, your reply could not be saved at this time.',422);
        }

        return back()
            ->with('flash','Your reply has been left.');
    }

    public function update(Reply $reply){
        $this->authorize('update',$reply);

        try {
            $this->validateReply();
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

    protected function validateReply(){
        $this->validate(request(),['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
