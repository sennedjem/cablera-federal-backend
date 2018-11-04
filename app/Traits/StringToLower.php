<?php

namespace App\Traits;

trait StringToLower {
    public function __set($key, $value) {
        if (is_string($value) && $key != "_id" && $key != "_index" && $key != "_type"){
            $value = trim(strtolower($value));
        }

        parent::__set($key, $value);
    }
}