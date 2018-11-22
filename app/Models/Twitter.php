<?php

namespace App\Models;

use Carbon\Carbon;
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

        try {
            $post = Post::create([
                'site' => $this->url,
                'creation_date' => Carbon::parse($item->pubDate)->format('Y-m-d H:i:s'),
                'content' => $this->_getContent($item),
                'url' => strval($item->link),
                'image' => strval($parseData['image'])
            ]);

            return $post;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return null;
        }

    }

    public function getTags($item){
        return $this->getHashtags($this->_getContent($item));
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