<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use DB;

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

        try {
            $post = Post::create([
                'site_id' => $this->id,
                'creation_date' => Carbon::parse($item->pubDate)->format('Y-m-d H:i:s'),
                'title' => strval($item->title),
                'content' => $this->_getContent($item),
                'url' => strval($item->link),
                'image' => $this->_getImage($item)
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

    private function _getTagDescription($category){
        return $category->__toString();
    }

    public function getTags($item){
        return array_map(array($this, '_getTagDescription'),(array) $item->category);
    }

    private function _getImage($item){
        $content = $item->description->__toString();
        $imageInitPos = strpos($content,'src="');

        $image = substr(
            $content,
            $imageInitPos+5,
            strpos($content,'g"')-$imageInitPos-4
        );

        if(strpos($image,'.jpg') ||
            strpos($image,'.jpeg') ||
            strpos($image,'.png') ||
            strpos($image,'.gif')
        ){
            return $image;
        }else{
            return '';
        }
    }

    private function _getContent($item){
        $text = $item->description->__toString();
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
