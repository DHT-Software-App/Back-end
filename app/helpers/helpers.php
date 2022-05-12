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


if(! function_exists('split_by_comma')) {
    /**
     * Split by comma, removing innecessary spaces, commas, and empty values.
     *
     * @param  string $str
     * @return array
     */
    function split_by_comma($str) {
        return preg_split('/(\s*,*\s*)*,+(\s*,*\s*)*/', $str);
    } 
}