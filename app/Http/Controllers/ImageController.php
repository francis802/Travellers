<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ImageController extends Controller
{
    public static function create(int $id, Request $request) {
                $file= $request->file('image');

                $filename = "post-".$id.".".pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);

                $file->move(public_path('images/'), $filename);
            
        }

    public static function delete(int $id) {
        foreach ( glob(public_path().'/images/'.'post-'.$id.'.*',GLOB_BRACE) as $image){
            if (file_exists($image)) unlink($image);
        }
    }

    public static function update(int $id, Request $request) {
        if ($request->file('image')) {
            ImageController::delete($id);
            ImageController::create($id, $request);
        }
    }

}