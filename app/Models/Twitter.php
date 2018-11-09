<?php

namespace App\Models;

use GuzzleHttp\Client;
use Log;

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
        return new Post([
            'site' => $this->url,
            'creation_date' => $item->pubDate,
            'content' => $this->_getContent($item),
            'url' => $item->link,
            'image' => $parseData['image']
        ]);
    }

    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    public function _getContent($item){
        $title = substr(
            $item->title,
            0,
            strpos($item->title,'http')-2
        );

        return $title;
    }
}