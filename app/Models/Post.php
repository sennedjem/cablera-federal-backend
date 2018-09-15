<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\Filterable;

class Post extends Model {

    use Filterable;
   
    protected $fillable = [
        'id',
        'site',
        'creation_date',
        'content',
        'url'
    ];

    protected $hidden = [];


    public static function postsExist($url){
        return self::where('url',$url)->count() > 0;
    }
}
