<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Models\Tag;
use App\Models\PostTag;

class Post extends Model {

    use Filterable;
   
    protected $fillable = [
        'id',
        'site',
        'creation_date',
        'content',
        'url',
        'image',
        'title'
    ];

    protected $hidden = [];

    protected $with = ['tags'];

    public static function postsExist($url){
        return self::where('url',$url)->count() > 0;
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'posts_tags')->using(PostTag::class);
    }

}
