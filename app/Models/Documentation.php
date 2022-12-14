<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    //
    protected $table = "msdocumentation";
    protected $primaryKey = 'DocumentationID';

    public function UserDocumentation(){

        return $this->belongsTo(UserDocumentation::class,'DocumentationID','DocumentationID');

    }

    public function DonationType(){
        return $this->hasOne(DonationType::class,'DonationTypeID', 'DonationTypeID');
    }

    public function DocumentationPhoto(){

        return $this->hasMany(DocumentationPhoto::class,'DocumentationID','DocumentationID');

    }

    public function DonationTransaction(){

        return $this->belongsTo(DonationTransaction::class,'DocumentationID','DocumentationID');

    }
}
