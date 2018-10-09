<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\Update;
use App\Models\Post;
use App\Models\Tag;
use DB;

class PostsController extends Controller{
    //

     /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        $request->sort_by = 'id';
        $request->sort_dir = 'DESC';
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
    	DB::beginTransaction();
	    try {
	        $post = Post::find($id);
	        $tags = $request->input('tags');
	        $post -> fill($request->validated());
	        $post -> save();
	        Tag::ifDoesntExistCreate($tags);
	        $post->tags()->sync(array_map('strtolower', $tags));

			DB::commit();
    		return response() -> json($post);
	    } catch (\Exception $e) {
			$error = $e->getMessage();
			DB::rollback();
			return response() -> json($error,500);
	    }
    }
}
