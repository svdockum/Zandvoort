<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
           protected $fillable = [
        'name','category','brand_id'
    ];

}
