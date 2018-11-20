<?php

namespace App\Models;

use GuzzleHttp\Client;

class RSS extends Site {

    //:::::::::::::::::::::::::::::: Reimplementation :::::::::::::::::::::::::::::::::

    function getPosts(){
        $client = new Client();
        return $client -> get($this->url);
    }

    function getParseData($xml){

        return array(
            'site' => $xml->channel->title
        );
    }

    function buildPost($item, $parseData){


        return new Post([
            'site' => strval($parseData['site']),
            'creation_date' => strval($item->pubDate),
            'title' => strval($item->title),
            'content' => $this->_getContent($item),
            'url' => strval($item->link),
            'image' => $this->_getImage($item)
        ]);
    }

    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    private function _getImage($item){
        $content = $item->description->__toString();
        $imageInitPos = strpos($content,'src="');

        $image = substr(
            $content,
            $imageInitPos+5,
            strpos($content,'g"')-$imageInitPos-4
        );

        return $image;
    }

    private function _getContent($item){
        $text = $item->description->__toString();
        $contentInitPos = strpos($text,'<p>');

        $content = substr(
            $text,
            $contentInitPos+3,
            strpos($text,'&#')-$contentInitPos-5
        );


        return $content;
    }
}