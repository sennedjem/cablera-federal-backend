<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Http\Requests\Media\Store;

class MediaController extends Controller{
    
      /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        return response() -> json(Media::filter($request));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request, Media $media){
        //
        return response() -> json($media); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request){
        //
        $media = Media::create($request -> validated());
        return response() -> json($media);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Store $request, Media $media){
        //
        $media -> fill($request->validated());
        $media -> save();
    	  return response() -> json($media);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Media $media
        ){
        //
        $deleted = $media -> delete();
        return response() -> json($deleted);
    }
}
