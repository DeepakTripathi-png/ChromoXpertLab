<?php

namespace App\Traits;
use Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Storage;

trait MediaTrait {

    // Rules For Using Following Methods
    // Make Sure Your Input Fields For File, Name Attribute As Same As The Database Column Name
    // Make Sure Your Database Column Name For File Path Must End With '_path' and Column Name File Name Must End With '_name'

    public function uploadFiles($files, $directory){
        foreach($files as $key => $file){
            $file_name = $file->getClientOriginalName();
            $file_path = $file->storeAs('public/'.$directory , $file_name);
            $all_file_path[$key] = $file_path;
            $all_file_path[$this->getDbColumnName($key)] = $file_name;
        }
        $path = storage_path('app/public/' . $directory);
        chmod($path, 0777);
        return $all_file_path;
    }

    public function getDbColumnName($key){
        $explodedArray = explode('_', $key);
        $lastElement = end($explodedArray);
        array_pop($explodedArray);
        array_push($explodedArray, "name");
        $name_key = implode('_', $explodedArray);
        return $name_key;
    }

}