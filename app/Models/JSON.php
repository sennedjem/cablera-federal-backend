<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use DB;
use App\Models\ES\PostES;

class JSON extends Site {

    //:::::::::::::::::::::::::::::: Reimplementation :::::::::::::::::::::::::::::::::

    function getPosts(){
        $client = new Client();
        return $client -> get($this->url);
    }

    public function updatePosts(){
        $response = $this->getPosts();

        if($response != null) {

            $items = json_decode($response->getBody(), true);

            foreach ($items as $post) {
                if (!Post::postsExist($post['file_download'])){
                     $this->createPost($post);
                }
            }
        }
    }

    public function createPost($item){
        $post = $this->newPost($item);

        DB::beginTransaction();
        //TODO: No se tiene que hacer asi
        try{
            if($post != null){
                $post->save();
                $this->updateES($post,"");
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            \Log::error($e);
            \Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    /*
    function getParseData($xml){
        return array(
            'site' => $xml->channel->title
        );
    }
    */

    public function updateES($post,$tags){
        $postsDriver = env('POSTS_DRIVER', 'mysql');
        if($postsDriver == 'elasticsearch'){
            PostES::crearPost($post,$tags,$this->media_id,$this->type);
        }
    }

    function newPost($item){

        try {
            \Log::info("id: {$this->id}");
            $post = Post::create([
                'site_id' => $this->id,
                'creation_date' => substr($item['pub_date'], 0, 10),
                'title' => strval($item['title']),
                'content' => $this->_getContent($item),
                'url' => $item['file_download'],
                'image' => ''
            ]);
            return $post;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            echo $error;
            \Log::info($error);
            return null;
        }
    }

    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::



    private function _getContent($item){
        $text = $item['content'];
        $contentInitPos = strpos($text,'<p>');

        $content = $text;

        if($contentInitPos)
            $content = substr(
                $text,
                $contentInitPos+3,
                strpos($text,'&#')-$contentInitPos-5
            );

        return $content;
    }
}
