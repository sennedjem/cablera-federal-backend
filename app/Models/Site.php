<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Media;
use DB;
use App\Models\Post;
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
        $tags = $this->getTags($item);
        $tags = array_map('strtolower', $tags);

        DB::beginTransaction();
        //TODO: No se tiene que hacer asi
        try{
            if($post != null){
                $post->save();
                Tag::ifDoesntExistCreate($tags);
                $post->tags()->sync($tags);
                $this->updateES($post,$tags);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            \Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }
    
    public function updateES($post,$tags){
        PostES::crearPost($post,implode(",", $tags));
        \Log::info(implode(",", $tags));
    }

    public function withType($type){ $this->type = $type; return $this; }
    public function withUrl($url){ $this->url = $url; return $this; }
    public function withUser_id($user_id){ $this->user_id = $user_id; return $this; }
    public function withMedia_id($media_id){ $this->media_id = $media_id; return $this; }

    function getPosts(){}
    function getTags($item){return [];}
    function getParseData($xml){}
    function buildPost($item,$parseData){}
}
