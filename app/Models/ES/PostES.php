<?php

namespace App\Models\ES;

use Basemkhirat\Elasticsearch\Model;

class PostES extends Model {

    protected $type = "post";

    protected $index = "cablerafederal";


     public static function filter($request){
        $query = self::orderBy('creation_date','desc');
        if($request->tags != null){
            \Log::info((explode(',', $request->tags)));
            foreach (explode(',', $request->tags) as $value) {
                $query = $query->where('tags','like',$value);
            }
        } 
        $fieldsToFilter = ['media_id','creation_date','site_type'];
        foreach ($fieldsToFilter as $field){
            if($request[$field]!=null){
                $query = $query->where($field,'like',$request[$field]);
            }
        }
        $perpage = $request->per_page? $request->per_page : 12;
        $page = $request->page? $request->page : 1;
        $query->paginate($perpage,"page",$request->page);
        $query = $query->paginate($perpage,"page",$request->page);
        $data = $query->toArray();
        $data['data'] = array_map(function($post) {
            $post['tags']=explode(',', $post['tags']);
            $post['tags']= array_map(function($tag) {return ["description"=>$tag];}, $post['tags']);
            return $post;
        }, $data['data']);
        return $data;
    }

    public static function find($id){
        $find = self::where('id',$id)->get()->toArray()[0];
        $find['tags']=explode(',', $find['tags']);
        $find['tags']= array_map(function($tag) {return ["description"=>$tag];}, $find['tags']);
        return $find;
    }

    public static function update($request,$tags){
        $find = self::where('id',$request->id)->get()[0];
        $find->tags=implode(",", $tags);
        $find->save();
    }

    public static function crearPost($post, $tags, $media_id, $type){
        $newPost = new PostES;
        $newPost->id = $post->id;
        $newPost->media_id = $media_id;
        $newPost->content = $post->content;
        $newPost->creation_date = substr($post->creation_date, 0, 10);
        $newPost->url = $post->url;
        $newPost->image = $post->image;
        $newPost->title = $post->title;
        $newPost->site_type = $type;
        $newPost->tags = $tags;
        $newPost->save();
    }
}
