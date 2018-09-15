<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\Filterable;

class Tag extends Model {

    //use Filterable;

    protected $primaryKey = 'description';
   
    protected $fillable = [
        'description'
    ];

    protected $hidden = [];

    public function setDescriptionAttribute($value) {
        $this->attributes['description'] = strtolower($value);
    }

    public function getDescriptionAttribute($value){
        return strtolower($value);
    }


    public static function ifDoesntExistCreate($tags){
        foreach($tags as $tag){
            if(!self::exist($tag)){
                self::addNewTag($tag);
            }
        }
    }

    public static function exist($description){

        return self::where('description',$description)->exists();
    }

    public static function addNewTag($description){
        $tag = new Tag(['description' => $description]);
        $tag -> save();
    }
 
 

}
