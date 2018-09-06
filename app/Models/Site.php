<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Site extends Model {
   
    protected $fillable = [
        'type',
        'url'
        //,'user_id'
    ];
 	
 	//protected $with = ['user'];

    protected $hidden = [];

    /*
    public function user() {
        return $this->belongsTo(User::class);
    }*/


}
