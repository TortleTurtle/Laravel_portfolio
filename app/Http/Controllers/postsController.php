<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class postscontroller extends Controller
{
    public function show($post){
        $posts = [
            "my-first-post" => "Hello! This is my first blogpost!",
            "my-second-post" => "I'm lovin' this!"
        ];

        if (! array_key_exists($post, $posts)) {
            abort('404', "Sorry, that post was not found.");
        }

        return view('post', [
            'post' => $posts[$post]
        ]);
    }
}
