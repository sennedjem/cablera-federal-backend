<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\Filterable;

class Site extends Model {

    use Filterable;
   
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
