<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use App\Post;
use App\User;

class PostController extends Controller
{
   
    public function products(){
        return view('products.index');
    }


    public function create(){
        return view('posts.create');
    }

    public function store(){

        $data = request()->validate([
            'caption' =>'required',
            'image' => ['required','image']
        ]);

        $imagePath = request('image')->store('uploads/posts', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(200, 200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);
        
        return redirect('/profile/' . auth()->user()->id);
    }

    
    public function show(Post $post, User $user){
        return view('posts.show', compact('post','user'));
    }
}
