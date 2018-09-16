<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\Update;
use App\Models\Post;
use App\Models\Tag;

class PostsController extends Controller{
    //

     /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        return response() -> json(Post::filter($request));
    }

    public function show(Request $request, $id){
        //
        return response() -> json(Post::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, $id){
        //
        $post = Post::find($id);
        $tags = $request->input('tags');
        $post -> fill($request->validated());
        $post -> save();
        Tag::ifDoesntExistCreate($tags);
        $post->tags()->sync(array_map('strtolower', $tags));

    	return response() -> json($post);
    }
}
