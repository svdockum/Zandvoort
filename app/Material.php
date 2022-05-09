<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
           protected $fillable = [
        'name','category','brand_id','type_id'
    ];

}
