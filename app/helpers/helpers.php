<?php 

use \Illuminate\Support\MessageBag;

if(! function_exists('invalid_attribute_format')) {
    function invalid_attribute_format(MessageBag $errors) {
        return array_merge(...array_map(function($key, $value) {
            return array_map(function($value) use($key){
                return ['attribute' => $key, "error" => $value];
            }, $value);
        }, array_keys($errors->getMessages()), $errors->getMessages()));
    }
}