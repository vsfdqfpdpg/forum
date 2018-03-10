<?php

namespace App;

use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Thread extends Model
{
    use RecordsActivity,Searchable;
    protected $guarded = [];
    protected $with = ['channel'];
    protected $appends = ['isSubscribedTo'];
    protected $casts = ['locked' => 'boolean'];
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

        static::created(function($thread){
            $thread->update(['slug' => $thread->title]);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function path(){
        return '/threads/'.$this->channel->slug.'/'.$this->slug;
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

        event(new ThreadReceivedNewReply($newReply));
        // $this->notifySubscribers($newReply);
        // event(new ThreadHasNewReply($this,$newReply)); // Event way

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

    public function hasUpdatesFor($user){
        // Look in the cache for the proper key.
        // Compare that carbon instance with the $thread->updated_at


        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

    public function visits()
    {
        return new Visits($this);
    }

    public function setSlugAttribute($value){
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()){
            $slug = "{$slug}-".$this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    protected function incrementSlug($slug)
    {
        $max = static::whereTitle($this->title)->latest('id')->value('slug');

        if (is_numeric(substr($max,-1,1))){
            return preg_replace_callback('/(\d+)$/',function($matches){
                return $matches[1] + 1;
            },$max);
        }

        return "{$slug}-2";
    }

    public function markBestReply(Reply $reply){
        $this->update(['best_reply_id' => $reply->id]);
    }
}
