<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class User extends Model {
   
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
 
    protected $hidden = ['password'];

    public function sites() {
        return $this->hasMany(Site::class);
    }


}
