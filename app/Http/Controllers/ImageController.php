<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public static function create(int $id, Request $request, String $type) {
                $file= $request->file('image');

                $filename = $type."-".$id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

                $file->move(public_path('images/'.$type.'/'), $filename);
            
    }

    public static function delete(int $id, String $type) {
        foreach ( glob(public_path().'/images/'.$type.'/'.$type.'-'.$id.'.*',GLOB_BRACE) as $image){
            if (file_exists($image)) unlink($image);
        }
    }

    public static function update(int $id, Request $request, String $type) {
        if ($request->file('image')) {
            ImageController::delete($id, $type);
            ImageController::create($id, $request, $type);
        }
    }


}