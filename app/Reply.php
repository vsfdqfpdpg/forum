<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable;
    protected $fillable = ['body','user_id'];
    protected $with = ['owner','favorites'];

    public function owner(){
        // if function name is not the same as table foreignKey plus id, you need provide foreign key as second parameter.
        return $this->belongsTo(User::class,'user_id');
    }

}
