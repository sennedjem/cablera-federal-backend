<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Model;

class PostES extends Model {

    protected $type = "post";

    protected $index = "cablerafederal";

    public function filter($request){
        if($request->per_page != null){          
            return response()->json(PostES::where('tags','like','mercados'));
        }
    }

    public static function crearPost($post,$tags){
        $newPost = new PostES;
        $newPost->id = $post->id;
        $newPost->site = $post->site;
        $newPost->content = $post->content;
        $newPost->creation_date = $post->creation_date;
        $newPost->url = $post->url;
        $newPost->image = $post->image;
        $newPost->title = $post->title;
        $newPost->tags = $tags;
        $newPost->save();
    }
}
