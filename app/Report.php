<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{

	use SoftDeletes;
     
     protected $dates = ['created_at','deleted_at'];

    protected $fillable = [
        'customer_id','location_id','json','category','user_id','report_ready','created_at','updated_at',
    ];
}
