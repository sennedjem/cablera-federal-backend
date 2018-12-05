<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Post\Update;
use App\Models\Post;
use App\Models\ES\PostES;
use App\Models\Tag;
use App\Models\UsersFavsPost;
use DB;

class PostsController extends Controller{
    //

     /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        //print_r($request);exit;

        $request->sort_by = 'creation_date';
        $request->sort_dir = 'DESC';
        $postsDriver = env('POSTS_DRIVER', 'mysql');
        \Log::info($postsDriver);
        if($postsDriver == 'elasticsearch'){
            $posts = PostES::filter($request);
        } else {
            $posts = Post::filter($request);
        }
        return response() -> json($posts);
    }

     public function show(Request $request, $id){
        //
        $postsDriver = env('POSTS_DRIVER', 'mysql');
        if($postsDriver == 'elasticsearch'){
            $post = PostES::find($id);
        } else {
            $post = Post::find($id);
        }
        return response() -> json($post);
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
            $postsDriver = env('POSTS_DRIVER', 'mysql');
            if($postsDriver == 'elasticsearch'){
                \Log::info($request);
                $posts = PostES::update($request,$tags);
            } 
			DB::commit();
    		return response() -> json($post);
	    } catch (\Exception $e) {
			$error = $e->getMessage();
			DB::rollback();
			return response() -> json($error,500);
	    }
    }

    public function getFavouritesPosts(Request $request, $userId){
        $es_ids = UsersFavsPost::where('user_id',$userId)->get()->map(function($post){return $post->post_es_id;});
        $posts = PostES::whereIn('_id',$es_ids);
        return response() -> json($posts);
    } 
}
