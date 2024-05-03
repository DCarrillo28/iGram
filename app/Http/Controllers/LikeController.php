<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post){
        //dd('Dando like');
        //dd($post->user()->id);
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);
        return back();
    }

    public function destroy(Request $request, Post $post){
        //dd('Eliminando like');
        $request->user()->likes()->where('post_id',$post->id)->delete();
        return back();
    }
}
