<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "msaddress";
    protected $primaryKey = "AddressID";

    public function Province() {
        return $this->hasOne(Province::class,'ProvinceID','ProvinceID');
    } 

    public function City(){
        return $this->hasOne(City::class,'CityID','CityID');
    }
}
