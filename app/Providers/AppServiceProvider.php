<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\Site;

class AppServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Validator::extend('uniqueTypeAndUrl', function ($attribute, $value, $parameters, $validator) {
            $sites = Site::where('url', $value)
                                ->where('type', $parameters[0]);
            if(count($parameters)>1){
                $sites = $sites -> where('id','!=',$parameters[1]);
               
            }
            $count = $sites -> count();            
            return $count === 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }
}
