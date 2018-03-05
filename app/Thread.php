<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;
    protected $guarded = [];
    protected $with = ['channel'];
    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('creator',function ($builder){
            $builder->with('creator');
        });

        static::deleting(function($thread){
            $thread->replies->each->delete();
            /*$thread->replies->each(function ($reply){
                $reply->delete();
            });*/
        });
    }


    public function path(){
        return '/threads/'.$this->channel->slug.'/'.$this->id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function addReply($reply){
        $newReply = $this->replies()->create($reply);

        $this->subscriptions->filter(function ($subscription) use($newReply){
            return $subscription->user_id != $newReply->user_id;
        })->each->notify($newReply);

        return $newReply;
    }

    public function scopeFilter($query,$filters){
        return $filters->apply($query);
    }

    public function getReplyCountAttribute(){
        return $this->replies()->count();
    }

    public function subscribe($userId = null){
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null){
        $this->subscriptions()->where('user_id',$userId ?: auth()->id())->delete();
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()->where('user_id',auth()->id())->exists();
    }
}
