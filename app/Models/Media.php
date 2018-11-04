<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Media extends Model {

    use Filterable;
   
    protected $fillable = [
        'id',
        'name',
        'district'
    ];

    protected $hidden = [];



}
