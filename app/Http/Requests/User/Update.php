<?php 

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Update extends BasicRequest{

	
    public function rules() {
        return [
			'name'     => ['required' ],
			'email'    => ['email','required'],
            'password' => ['required']
        ];
    }
    
}
