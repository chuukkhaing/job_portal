<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BlogPost;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = BlogPost::with('BlogCategory:id,name')->whereIsActive(1)->whereNull('deleted_at')->select('id','category_id','title','image','slug','description','created_at as published_at')->orderBy('updated_at', 'desc')->paginate(10);
        return response()->json([
            'status' => 'success',
            'image_path' => '/blog',
            'posts' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post_detail = BlogPost::with('BlogCategory:id,name')->whereIsActive(1)->whereNull('deleted_at')->select('id','category_id','title','slug','image','description','created_at as published_at')->whereSlug($slug)->first();
        return response()->json([
            'status' => 'success',
            'image_path' => '/blog',
            'post_detail' => $post_detail
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function allBlogPosts()
    {
        $posts = BlogPost::whereIsActive(1)->whereNull('deleted_at')->select('id','title', 'slug')->orderBy('updated_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'posts' => $posts
        ], 200);
    }

    public function relatedBlogPost($slug)
    {
        $blog_category = BlogPost::whereIsActive(1)->whereNull('deleted_at')->whereSlug($slug)->first();
        $related_posts = BlogPost::with('BlogCategory:id,name')->whereCategoryId($blog_category->category_id)->whereIsActive(1)->whereNull('deleted_at')->select('id','category_id','title','image','slug','description','created_at as published_at')->orderBy('updated_at', 'desc')->paginate(4);
        return response()->json([
            'status' => 'success',
            'image_path' => '/blog',
            'related_posts' => $related_posts
        ], 200);
    }
}
