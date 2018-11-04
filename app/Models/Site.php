<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Media;
use App\Traits\Filterable;

class Site extends Model {

    use Filterable;
   
    protected $fillable = [
        'type',
        'url',
        'user_id',
        'media_id'
    ];
 	
 	protected $with = ['user','media'];

    protected $hidden = [];

    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function media() {
        return $this->belongsTo(Media::class);
    }


}
