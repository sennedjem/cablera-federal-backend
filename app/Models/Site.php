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

    public function updatePosts(){
        $response = $this->getPosts();

        if($response != null) {
            $xml = $response->xml();

            $items = $xml->channel->item;
            $parseData = $this->getParseData($xml);

            for ($i = count($items); $i > 0; $i--) {
                if (!Post::postsExist($items[$i - 1]->link))
                    $this->addPost($items[$i - 1], $parseData);
            }
        }
    }

    public function addPost($item,$parseData){
        $post = $this->buildPost($item,$parseData);

        //TODO: No se tiene que hacer asi
        try{
            $post->save();
        }catch (\Exception $e){
            echo $e->getTraceAsString() . PHP_EOL;
        }
    }

    public function withType($type){ $this->type = $type; return $this; }
    public function withUrl($url){ $this->url = $url; return $this; }
    public function withUser_id($user_id){ $this->user_id = $user_id; return $this; }
    public function withMedia_id($media_id){ $this->media_id = $media_id; return $this; }

    function getPosts(){}
    function getParseData($xml){}
    function buildPost($item,$parseData){}
}
