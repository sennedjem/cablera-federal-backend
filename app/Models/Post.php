<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Post extends Model {
   
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
