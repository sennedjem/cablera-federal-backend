<?php 

namespace App\Http\Requests\Site;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Store extends BasicRequest{


    public function rules() {
		$types = \Config::get('sites.types');
        
        return [
			'url'     => ['required'],
			'type'    => ['required', 'in:'.implode(',', $types)]
        ];
    }
    
}
