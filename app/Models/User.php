<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Foundation\Auth\Users as Authenticatable;

use App\Models\Users as Authenticatable;


class User extends Authenticatable
{
    protected $table = "msuser";
    protected $primaryKey = "UserID";

    protected $fillable = [
        'email',
        'password',
        'phoneNumber',
        'registerDate'
    ];

    public function FollowPost(){

        return $this->hasMany(FollowPost::class,'UserID','UserID');

    }

    protected $guard = 'web';


    public function UserLevel(){

        return $this->hasMany(UserLevel::class,'UserID','UserID');

    }

    public function DonationTransaction(){

        return $this->hasMany(DonationTransaction::class,'UserID','UserID');

    }

    public function Address(){
        return $this->hasOne(Address::class, 'AddressID', 'AddressID');
    }

    public function Photo(){
        return $this->hasOne(Photo::class, 'PhotoID', 'PhotoID');
    }

}
