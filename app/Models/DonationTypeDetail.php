<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationTypeDetail extends Model
{
    protected $table = 'msdonationtypedetail';

    public function DonationType(){
        return $this->belongsTo(DonationType::class,'DonationTypeID','DonationTypeID');
    }

    public function Post(){
        return $this->hasMany(Post::class,'DonationTypeDetailID','DonationTypeDetailID');
    }
}
