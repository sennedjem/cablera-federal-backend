<?php 

namespace App\Http\Requests\UsersFavsPost;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Store extends BasicRequest{


    public function rules() {
        
        return [
			'post_es_id' => ['required', 'string'],
			'user_id'    => ['required','exists:users,id']
        ];
    }
    
}
