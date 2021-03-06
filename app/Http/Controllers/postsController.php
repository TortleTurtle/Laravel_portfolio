<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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
        $posts = Post::where('status', true)->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        

        return view('posts.indexPosts',[
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function search(Request $request){
        
        $search = $request->get('search');
        $category = $request->get('category');
        $categories = Category::all();

        if(empty($search)){
            $posts = Post::where('status', '=', true)->whereHas('categories', function (Builder $query) use ($category){
                $query->where('id', '=', $category);
            })->get();
        }
        elseif(empty($category)){
            $posts = Post::where([['title', 'like', "%$search%"], ['status', '=', true]])->get();
        }
        else{
            $posts = Post::where([['title', 'like', "%$search%"], ['status', '=', true]])->whereHas('categories', function (Builder $query) use ($category){
                $query->where('id', '=', $category);
            })->get();
        }
        
        return view('posts.indexPosts',[
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function adminIndex()
    {  
        //check if user is a admin
        if(Auth::user()->role_id == 1){
            //show all posts
            $posts = Post::all();
    
            return view('admin.indexPosts',[
                'posts' => $posts
            ]);
        }
        else{
            return redirect()->action('postsController@index');
        }
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
            $categories = Category::all();
            return view('posts.createPost',[
                'categories' => $categories,
            ]);
        }
        else {
            abort(403, "You do not have the right permissions");
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
            $post->status = $request->status;
            $post->author = Auth::user()->id;
            
            $post->save();
            $post->categories()->attach($request->category);
            
            //redirect to the created post's page.
            return redirect('/posts/'. $post->slug);
            
        }
        else {
            abort(403, "You do not have the right permissions");
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
        
        if($post->status == true){
            return view('posts.post', [
                'post' => $post
            ]);
        }
        else{
            return redirect('/posts');
        }
        
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
             $categories = Category::all();

            return view('posts.editPost', [
                'post' => $post,
                'categories' => $categories
            ]);
        }
        else {
            abort(403, "You do not have the right permissions");
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
            abort(403, "You do not have the right permissions");
        }
    }

    public function toggleStatus(Request $request, $slug){

        if (in_array('editPost', $request->get('permissions'))) {

            $post = Post::where('slug',$slug)->first();

            if ($post->status == 0){
                $post->status = 1;
            }
            else {
                $post->status = 0;
            }
            $post->save();
                
            return redirect('/admin/posts');
        }

        else {
            abort(403, "You do not have the right permissions");
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
}