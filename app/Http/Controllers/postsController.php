<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.createPost');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation
        $request->validate([
            "slug" => 'required|max:30|unique:posts|alpha_dash',
            "title" => 'required|max:30',
            "content" => 'required'
        ]);

        //storing
        $post = new Post();
        $post->slug = $request->slug;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->active = true;
        $post->author = 1;

        $post->save();
        
        //redirect to the created post's page.
        return redirect('/posts/'. $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.post', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //find the post with the right slug.
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.editPost', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validation
        $request->validate([
            "slug" => 'required|max:30|unique:posts|alpha_dash',
            "title" => 'required|max:30',
            "content" => 'required'
        ]);
        
        //updating
        $post = Post::find($id);
        $post->slug = $request->slug;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->active = true;
        $post->author = 1;

        $post->save();
        
        //redirect to updated post's page
        return redirect('/posts/' . $post->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
