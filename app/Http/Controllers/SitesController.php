<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Site\Store;
use App\Models\Site;
use Log;

class SitesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        return response() -> json(Site::all());
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request, Site $site){
        //
        return response() -> json($site); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request){
        //
        $site = Site::create($request -> validated());
        return response() -> json($site);
    }

    public function getTypes(Request $request){
        return response() -> json(array_values(\Config::get('sites.types')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Store $request, Site $site){
        //
        $site -> fill($request->validated());
        $site -> save();
    	  return response() -> json($site);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Site $site
        ){
        //
        $deleted = $site -> delete();
        return response() -> json($deleted);
    }


}
