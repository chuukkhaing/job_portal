<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SEO;
use Storage;
use Alert;
use Auth;

class SEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:seo-list|seo-create|seo-edit|seo-delete', ['only' => ['index','store']]);
        $this->middleware('permission:seo-create', ['only' => ['create','store']]);
        $this->middleware('permission:seo-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:seo-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $seos = SEO::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.seo.index', compact('seos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pages = [
            'Home',
            'Find Jobs',
            'Job Category',
            'Employers',
            'Contact Us',
            'Sign In',
            'Sign Up',
            'About Us',
            'Terms of Use',
            'Privacy Policies'
        ];
        return view ('admin.seo.create', compact('pages'));
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
            'page' => 'required|unique:s_e_o_s,page_name',
        ]);
        if($request->hasFile('feature_image')) {
            $file    = $request->file('feature_image');
            $imageName = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'seo/feature_image/' . $imageName;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }
        $post = SEO::create([
            'page_name' => $request->page,
            'feature_image' => $imageName ?? Null,
            'seo_keyword' => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'SEO Created Successfully!');
        return redirect()->route('seo.index');
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
        $seo_page = SEO::findOrFail($id);
        $pages = [
            'Home',
            'Find Jobs',
            'Job Category',
            'Employers',
            'Contact Us',
            'Sign In',
            'Sign Up',
            'About Us',
            'Terms of Use',
            'Privacy Policies'
        ];
        return view ('admin.seo.edit', compact('pages', 'seo_page'));
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
            'page' => 'required|unique:s_e_o_s,page_name,'.$id,
        ]);
        $seo_page = SEO::findOrFail($id);
        if($request->file_name == '') {
            $imageName = null;
        }elseif($request->file_name == $seo_page->feature_image) {
            $imageName = $seo_page->feature_image;
        }else {
            if($request->hasFile('feature_image')) {
                $file    = $request->file('feature_image');
                $imageName = date('YmdHi').$file->getClientOriginalName();
                
                $path     = 'seo/feature_image/' . $imageName;
                Storage::disk('s3')->put($path, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
            }
        }
        $post = $seo_page->update([
            'page_name' => $request->page,
            'feature_image' => $imageName ?? Null,
            'seo_keyword' => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'SEO Update Successfully!');
        return redirect()->route('seo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seo_page = SEO::findOrFail($id)->delete();
        if ($seo_page) {
            Alert::success('Success', 'Delete SEO Successfully!');
            return redirect()->route('seo.index');
        }
    }
}
