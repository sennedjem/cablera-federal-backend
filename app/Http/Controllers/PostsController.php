<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PostsController extends Controller{
    //

     /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        $client = new Client();
        $response = $client -> get('http://twitrss.me/twitter_user_to_rss/?user=clarincom');
        //$response = $client->get('https://github.com/mtdowling.atom');
        $xml = $response->xml();
        $items = $xml->channel;
        dd($items);
        return response() -> json(Site::all());
    }
}
