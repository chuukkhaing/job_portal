<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BlogPost;
use App\Models\Admin\BlogCategory;
use Storage;
use Alert;
use Auth;
use Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blog-post-list|blog-post-create|blog-post-edit|blog-post-delete', ['only' => ['index','store']]);
        $this->middleware('permission:blog-post-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-post-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $posts = BlogPost::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.blog-post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = BlogCategory::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.blog-post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('image')) {
            $file    = $request->file('image');
            $imageName = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'blog/' . $imageName;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }
        $post = BlogPost::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imageName ?? Null,
            'video_url' => $request->video_url,
            'seo_keyword' => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        $slug = Str::slug($request->title, '-') . '-' . $post->id;
        $post->update([
            'slug' => $slug
        ]);

        Alert::success('Success', 'New Blog Post Created Successfully!');
        return redirect()->route('blog-post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.blog-post.edit', compact('categories', 'post'));
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
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'is_active' => 'required',
        ]);

        $post = BlogPost::findOrFail($id);

        if($request->file_name == '') {
            $imageName = null;
        }elseif($request->file_name == $post->image) {
            $imageName = $post->image;
        }else {
            if($request->hasFile('image')) {
                Storage::disk('s3')->delete('blog/' . $post->image);
    
                $file    = $request->file('image');
                $imageName = date('YmdHi').$file->getClientOriginalName();
                
                $path     = 'blog/' . $imageName;
                Storage::disk('s3')->put($path, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
            }
        }
        $post_update = $post->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imageName,
            'video_url' => $request->video_url,
            'seo_keyword' => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Blog Post Updated Successfully!');
        return redirect()->route('blog-post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        
        try {
            $post = BlogPost::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($post) {
                Alert::success('Success', 'Delete Blog Post Successfully!');
                return redirect()->route('blog-post.index');
            }
            else {
                Alert::error('Failed', 'Blog Post deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Blog Post');
                return redirect()->back();
            } 
        }
    }
}
