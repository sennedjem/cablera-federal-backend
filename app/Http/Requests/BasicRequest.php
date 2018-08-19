<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasicRequest extends FormRequest
{
    public function authorize() {
        //dd('auth');
        return true;
    }

    /*
    public function forbiddenResponse() {
        dd('forbiddenResponse');
        return new JsonResponse(['message' => 'Permission denied'], 403);
    }

    public function response(array $errors) {
        dd('response');
        return new JsonResponse($errors, $this->responseCode());
    }
    
    protected function responseCode() {
        dd('responseCode');
        return 400;
    }*/
}
