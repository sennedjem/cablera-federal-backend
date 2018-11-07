<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
    public function show(Request $request, $id){
        //
        //dd( Media::find($media));

        $media = Media::find($id);

        if(is_null($media)) {
            return response()->json([
                        'message' => "Media not found",
                    ], 404);
        }

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
    public function update(Store $request, $id){
        //
        $media = Media::find($id);
        if(is_null($media)) {
            return response()->json([
                        'message' => "Media not found",
                    ], 404);
        }
        $media -> fill($request->validated());
        $media -> save();
    	  return response() -> json($media);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id){
        //
        $media = Media::find($id);

        if(is_null($media)) {
            return response()->json([
                        'message' => "Media not found",
                    ], 404);
        }

        $deleted = $media -> delete();

        return response() -> json($deleted);
    }
}
