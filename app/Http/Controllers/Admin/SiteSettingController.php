<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SiteSetting;
use Alert;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:site-setting-list|site-setting-create|site-setting-edit|site-setting-delete', ['only' => ['index','store']]);
        // $this->middleware('permission:site-setting-create', ['only' => ['create','store']]);
        // $this->middleware('permission:site-setting-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:site-setting-delete', ['only' => ['destroy']]);
    }
    
    public function index()
    {
        $site_setting = SiteSetting::findOrFail(1);
        return view ('admin.setting.site', compact('site_setting'));
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
        $setting = SiteSetting::findOrFail($id);
        // $site_logo = $setting->site_logo;
        // if($request->sitelogo_empty == "Empty") {
        //     File::delete(public_path('/storage/site_logo').'/'.$site_logo);
        //     $site_logo = null;
        // }
        // if($request->file('site_logo')){
        //     $file= $request->file('site_logo');
        //     $site_logo = date('YmdHi').$file->getClientOriginalName();
        //     $path = $file-> move(public_path('storage/site_logo'), $site_logo );
        // }

        // $favicon = $setting->favicon;
        // if($request->sitelogo_empty == "Empty") {
        //     File::delete(public_path('/storage/favicon').'/'.$favicon);
        //     $favicon = null;
        // }
        // if($request->file('favicon')){
        //     $file= $request->file('favicon');
        //     $favicon = date('YmdHi').$file->getClientOriginalName();
        //     $path = $file-> move(public_path('storage/favicon'), $favicon );
        // }

        // $feature_image = $setting->feature_image;
        // if($request->sitelogo_empty == "Empty") {
        //     File::delete(public_path('/storage/feature_image').'/'.$feature_image);
        //     $feature_image = null;
        // }
        // if($request->file('image')){
        //     $file= $request->file('image');
        //     $feature_image = date('YmdHi').$file->getClientOriginalName();
        //     $path = $file-> move(public_path('storage/feature_image'), $feature_image );
        // }

        $setting = $setting->update([
            'site_title' => $request->site_title,
            'site_tag' => $request->site_tag,
            // 'site_logo' => $site_logo,
            // 'favicon' => $favicon,
            'seo_keyword' => $request->seo_keyword,
            'seo_description' => $request->seo_description,
            // 'feature_image' => $feature_image,
            'created_by' => Auth()->user()->id
        ]);

        if ($setting) {
            Alert::success('Success', 'Site Setting Update Successfully!');
            return redirect()->route('site-setting.index');
        }
        else {
            Alert::error('Failed', 'Updating Site Setting Failed!');
            return back();
        }
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

    public function reset($id)
    {
        $site_setting = SiteSetting::findOrFail($id);

        $site_setting->update([
            'site_title' => NULL,
            'site_tag' => NULL,
            'site_logo' => NULL,
            'favicon' => NULL,
            'seo_keyword' => NULL,
            'seo_description' => NULL,
            'feature_image' => NULL,
            'updated_by' => Auth()->user()->id
        ]);

        if ($site_setting) {
            Alert::success('Success', 'Site Setting Reset Successfully!');
            return view ('admin.setting.site', compact('site_setting'));
        }
        else {
            Alert::error('Failed', 'Reset Site Setting Failed!');
            return back();
        }
    }
}
