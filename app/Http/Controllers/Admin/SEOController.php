<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\SEO;

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
}
