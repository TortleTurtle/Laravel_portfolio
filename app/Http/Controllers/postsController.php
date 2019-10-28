<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class postsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show all posts
        $posts = Post::all();

        return view('posts.indexPosts',[
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //check if user has the right permission.
        if (in_array('createPost', $request->get('permissions'))) {
            return view('posts.createPost');
        }
        else {
            abort(403, "You don't have the right permissions");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if user has the right permission.
        if (in_array('createPost', $request->get('permissions'))) {
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
        else {
            abort(403, "You don't have the right permissions");
        }
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
    public function edit(Request $request, $slug)
    {
        //check if user has the right permission.
        if (in_array('editPost', $request->get('permissions'))) {
            //find the post with the right slug.
             $post = Post::where('slug', $slug)->firstOrFail();

            return view('posts.editPost', compact('post'));
        }
        else {
            abort(403, "You don't have the right permissions");
        }
        
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
        //check if user has the right permission
        if (in_array('editPost', $request->get('permissions'))) {
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
        else {
            abort(403, "You don't have the right permissions");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        //check if user has the right role
        if (in_array('deletePost', $request->get('permissions'))) {
            //find the post with the right slug.
            $post = Post::where('slug', $slug)->firstOrFail();
            $post->delete();
            
            return view('posts.indexPosts');
        }
        else {
            abort(403, "You don't have the right permissions");
        }
    }
    public function checkPermissions(Request $request){
        return $request->get('permissions');
    }
}