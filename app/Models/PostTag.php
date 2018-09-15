<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostTag extends Pivot {

    protected $table = 'posts_tag';
   
    protected $fillable = [
        'id',
        'post_id',
        'tag_description'
    ];

    protected $hidden = [];

    public function setTagDescriptionAttribute($value) {
        $this->attributes['tag_description'] = strtolower($value);
    }
}
