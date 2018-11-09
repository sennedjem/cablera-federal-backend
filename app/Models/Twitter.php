<?php

namespace App\Models;

use GuzzleHttp\Client;
use Log;
use DB;

class Twitter extends Site {

    //:::::::::::::::::::::::::::::: Reimplementation :::::::::::::::::::::::::::::::::

    function getPosts(){
        try {
            $client = new Client();
            return $client->get('http://twitrss.me/twitter_user_to_rss/?user=' . $this->url);

        }catch (\Exception $re){
            \Log::info('No existe una pagina asociada a Twitter con el nombre de '.$this->url);
        }
    }

    function getParseData($xml){
        return array(
            'image' => $xml->channel->image->url
        );
    }

    function buildPost($item, $parseData){
        $hashtags = $this->getHashtags($this->_getContent($item));

        DB::beginTransaction();
        try {
            $post = Post::create([
                'site' => $this->url,
                'creation_date' => $item->pubDate,
                'content' => $this->_getContent($item),
                'url' => $item->link,
                'image' => $parseData['image']
            ]);
            Tag::ifDoesntExistCreate($hashtags);
            $post->tags()->sync(array_map('strtolower', $hashtags));
            //$post->save();
            DB::commit();
            return $post;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return null;
        }

    }

    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    private function getHashtags($text){
        preg_match_all('/#([^\s]+)/', $text, $matches);
        return $matches[1];
    }

    public function _getContent($item){
        $title = substr(
            $item->title,
            0,
            strpos($item->title,'http')-2
        );

        return $title;
    }
}