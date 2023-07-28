<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\FeedBack;
use Alert;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:seeker-employer-contact-list|seeker-employer-contact-create|seeker-employer-contact-edit|seeker-employer-contact-delete', ['only' => ['index','store']]);
        $this->middleware('permission:seeker-employer-contact-create', ['only' => ['create','store']]);
        $this->middleware('permission:seeker-employer-contact-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:seeker-employer-contact-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $feedbacks = FeedBack::get();
        return view ('admin.feedback.index', compact('feedbacks'));
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
        $feedback = FeedBack::findOrFail($id);
        
        try {
            $feedback = FeedBack::findOrFail($id)->delete();
            if ($feedback) {
                Alert::success('Success', 'Delete Seeker/Employer Contact Successfully!');
                return redirect()->route('feedback.index');
            }
            else {
                Alert::error('Failed', 'Seeker/Employer Contact deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Seeker/Employer Contact');
                return redirect()->back();
            } 
        }
    }
}
