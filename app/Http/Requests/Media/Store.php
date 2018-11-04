<?php 

namespace App\Http\Requests\Media;

use Illuminate\Validation\Rule;
use App\Http\Requests\BasicRequest;


class Store extends BasicRequest{


    public function rules() {
        
        return [
			'name'     => ['required'],
			'district'     => ['string']
        ];
    }
    
}
