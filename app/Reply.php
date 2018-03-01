<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['body','user_id'];

    public function owner(){
        // if function name is not the same as table foreignKey plus id, you need provide foreign key as second parameter.
        return $this->belongsTo(User::class,'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited(){
        return $this->favorites()->where('user_id',auth()->id())->exists();
    }
}
