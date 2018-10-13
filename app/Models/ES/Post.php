<?php

namespace App\Models\ES;

class Post extends ESModel {

    protected $type = "receivers_states";

    public $fillable = [
        'id',
        'site',
        'creation_date',
        'content',
        'url',
        'image',
        'title'
    ];

}
