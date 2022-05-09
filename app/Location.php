<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    //

    use SoftDeletes;
     
     protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'email1','contactperson', 'phone1','phone2', 'street','housenumber', 'postalcode', 'city','comment','customer_id','isKeerBlus','isNood'
    ];
}
