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
        $tags = $this->_getTags((array) $item->category);

        DB::beginTransaction();
        try {
            $post = Post::create([
                'site' => $parseData['site'],
                'creation_date' => Carbon::parse($item->pubDate)->format('Y-m-d H:i:s'),
                'title' => $item->title,
                'content' => $this->_getContent($item),
                'url' => $item->link,
                'image' => $this->_getImage($item)
            ]);
            Tag::ifDoesntExistCreate($tags);
            $post->tags()->sync(array_map('strtolower', $tags));
            //$post->save();
            DB::commit();
            return $post;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            print_r($error);exit;
            return null;
        }
    }

    //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

    private function _getTagDescription($category){
        return $category->__toString();
    }

    private function _getTags($categories){
        return array_map(array($this, '_getTagDescription'),$categories);
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

        $content = substr(
            $text,
            $contentInitPos+3,
            strpos($text,'&#')-$contentInitPos-5
        );


        return $content;
    }
}
