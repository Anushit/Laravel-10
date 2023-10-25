<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function Image_uploade(ImageRequest $request)
    { 
     
        // dd($request->input('_token'));
        // dd($request->all());
        //dd($request->file('image'));

        //Upload the image and store in directory
        //$path = $request->file('image')->store('images','public');

        //Store image using facades storage 
        $path = Storage::disk('public')->put('images', $request->file('image'));

        //We can delete older image here 
        if($request->user()->image != null){
            Storage::disk('public')->delete($request->user()->image);        
        }
        //Update the image in db
        auth()->user()->update(['image' => $path]);
        //   dd(auth()->user());
        // $path = Storage::disk('public')->put('images', $request->file('image'));
        // dd($path);
        //auth()->user()->update(['image' => storage_path('app')."/$path"]);


        return response()->redirectTo('profile');
    }
}
