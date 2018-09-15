<?php 

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Update extends BasicRequest{


    public function rules() {
        
        return [
			'site'          => ['required'],
			'creation_date' => ['required'],
			'content'       => ['required'],
			'url'           => ['required'],
			'tags'          => ['required','array']
        ];
    }
    
}