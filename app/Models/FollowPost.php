<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowPost extends Model
{
    //
    protected $table = "trfollowpost";

    public function User(){

        return $this->belongsTo(User::class,'UserID','UserID');

    }
}
