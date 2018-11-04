<?php 

namespace App\Http\Requests\Site;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Update extends BasicRequest{


    public function rules() {
		$types = \Config::get('sites.types');
		$type = $this['type'];
		$id = $this->route('site')->id;
        
        return [
			'type'     => ['required', 'in:'.implode(',', $types)],
			'url'      => ['required','uniqueTypeAndUrl:'.$type.','.$id],
			'media_id' => ['required','exists:media,id'],
			'user_id'  => ['required','exists:users,id']
        ];
    }
    
}
