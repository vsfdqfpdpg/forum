<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function owner(){
        // if function name is not the same as table foreignKey plus id, you need provide foreign key as second parameter.
        return $this->belongsTo(User::class,'user_id');
    }
}
