<?php

namespace App\Http\Controllers;

use App\Models\ES\Post;
use Illuminate\Http\Request;

class ElasticSearchController extends Controller{
    /**
     * Test for elastic search.
     *
     */
    public function index(Request $request){
        $receiverStateClass = new Post();

        $items = $receiverStateClass->baseQuery($request)->get();

        return response()->json($items);
    }
}
