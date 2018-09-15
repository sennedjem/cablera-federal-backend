<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\User\Store;
use App\Http\Requests\User\Update;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Log;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request){
        //
        return response() -> json(User::filter($request));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(Request $request, User $user){
        //
        return response() -> json($user); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request){
        //
        $user = User::create($request -> validated());
        return response() -> json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, User $user){
        //
        $user -> fill($request->validated());
        $user -> save();
    	  return response() -> json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user){
        //
        $deleted = $user -> delete();
        return response() -> json($deleted);
    }

    public function getLoggedCustomer(){
        return Auth::user();
    }

}
