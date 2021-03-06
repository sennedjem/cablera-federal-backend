<?php 

namespace App\Http\Requests\Site;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Store extends BasicRequest{


    public function rules() {
		$types = \Config::get('sites.types');
		$type = $this['type'];
        
        return [
			'type'     => ['required', 'in:'.implode(',', $types)],
			'url'      => ['required','uniqueTypeAndUrl:'.$type],
			'media_id' => ['required','exists:media,id'],
			'user_id'  => ['required','exists:users,id']
        ];
    }
    
}
