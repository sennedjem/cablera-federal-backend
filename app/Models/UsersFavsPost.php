<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class UsersFavsPost extends Model {


    use Filterable;

	public $primaryKey = 'id';

    protected $fillable = [
        'post_es_id',
        'user_id',
        'id'
    ];

    protected $hidden = [];

}
