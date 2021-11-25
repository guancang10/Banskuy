<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'trcomment';

    public function Post(){
        return $this->hasOne(Post::class,'PostID','PostID');
    }
    
    public function User(){
        return $this->hasOne(User::class,'UserID','ID');
    }
}
