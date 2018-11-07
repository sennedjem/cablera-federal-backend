<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class Media extends Model {


    use Filterable;
   
	protected $table = 'media';

	public $primaryKey = 'id';

    protected $fillable = [
        'name',
        'district'
    ];

    protected $hidden = [];

}
