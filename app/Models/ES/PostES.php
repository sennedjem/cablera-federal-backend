<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Model;

class PostES extends Model {

    protected $type = "post";

    protected $index = "cablerafederal";


    public static function crearPost($post,$tags){
        $newPost = new PostES;
        $newPost->id = $post->id;
        $newPost->site = $post->site;
        $newPost->content = $post->content;
        $newPost->url = $post->url;
        $newPost->image = $post->image;
        $newPost->title = $post->title;
        $newPost->tags = $tags;
        $newPost->save();
    }
}
