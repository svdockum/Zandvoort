<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    //

use SoftDeletes;
     
     protected $dates = ['deleted_at'];

protected $fillable = [
        'name', 'email1','contactperson', 'phone1','phone2', 'street','housenumber', 'postalcode', 'city','isKeerBlus','isNood','can_login','isAlarm','isBMI'
    ];

     public function locations()
    {
        return $this->hasMany('App\Location');
    }
}
