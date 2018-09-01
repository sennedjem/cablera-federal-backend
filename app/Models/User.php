<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject as AuthenticatableUserContract;



class User extends Authenticatable implements AuthenticatableUserContract  {
   
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
 
    protected $hidden = ['password'];

    public function sites() {
        return $this->hasMany(Site::class);
    }

    public function getLoggedCustomer(){
        return Auth::user();
    }

    public function getJWTIdentifier() {
        return $this->getKey();  // Eloquent model method
    }

    public function getJWTCustomClaims() {
        return [
             'user' => [ 
                'id' => $this->id
             ]
        ];
    }


}
