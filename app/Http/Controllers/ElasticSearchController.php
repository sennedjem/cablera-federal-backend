<?php

namespace App\Http\Controllers;

use App\Models\ES\PostES;
use Illuminate\Http\Request;

class ElasticSearchController extends Controller{
    /**
     * Test for elastic search.
     *
     */
    public function index(Request $request){
        return response()->json(PostES::filter($request));
    }

    public function create(Request $request){
    	$post = new PostES;

    	$post->id = 2818;
    	$post->site = '#ElNumeral';
    	//$post->creation_date = 'Fri, 09 Nov 2018 15:40:14 +0000';
    	$post->content = 'Los seis puntos que tenés que saber del bono de $5000 decretado por el gobiernopic.twitter.com/shXwBG2B ';
    	$post->url = 'https://twitter.com/Ambitocom/status/1060920005498421250 ';
    	$post->image = 'https://pbs.twimg.com/profile_images/419177103590842368/RVA31I6y_400x400.png ';
    	$post->title = null;

    	$post->save();

    	return response()->json($post);
    }
}
