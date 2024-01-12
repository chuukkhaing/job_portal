<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BlogCategory;
use Auth;
use Alert;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:blog-category-list|blog-category-create|blog-category-edit|blog-category-delete', ['only' => ['index','store']]);
        $this->middleware('permission:blog-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:blog-category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:blog-category-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $categories = BlogCategory::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.blog-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.blog-category.create');
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
            'name' => 'required',
            'is_active' => 'required',
        ]);
        $category = BlogCategory::create([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Blog Category Created Successfully!');
        return redirect()->route('blog-category.index');
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
        $category = BlogCategory::findOrFail($id);
        return view ('admin.blog-category.edit', compact('category'));
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
            'name' => 'required',
            'is_active' => 'required',
        ]);
        $category = BlogCategory::findOrFail($id);
        $category_update = $category->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Blog Category Updated Successfully!');
        return redirect()->route('blog-category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        
        try {
            $category = BlogCategory::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($category) {
                Alert::success('Success', 'Delete Blog Category Successfully!');
                return redirect()->route('blog-category.index');
            }
            else {
                Alert::error('Failed', 'Blog Category deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Blog Category');
                return redirect()->back();
            } 
        }
    }
}
