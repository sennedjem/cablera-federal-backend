<?php

namespace App\Traits;

trait Filterable {

    public static function filter($request){

        $query = self::query();
        
        if($request->sort_by){
            $dir = $request->sort_dir ?? 'asc';
            $query->orderBy($request->sort_by, $dir);
        }

        if($request->filter_field){
            $query->where($request->filter_field,'LIKE','%'.$request->filter_value.'%');
        }

        if($request->pagination === 'enabled'){
            return $query->get();
        } else {
            return $query->paginate($request->per_page);
        }
    }
}
