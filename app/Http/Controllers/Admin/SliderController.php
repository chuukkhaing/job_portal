<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Slider;
use App\Models\Admin\Employer;
use Alert;
use Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:slider-list|slider-create|slider-edit|slider-delete', ['only' => ['index','store']]);
        $this->middleware('permission:slider-create', ['only' => ['create','store']]);
        $this->middleware('permission:slider-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:slider-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sliders = Slider::whereNull('deleted_at')->get();
        return view ('admin.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employers = Employer::whereNull('deleted_at')->whereIsActive(1)->get();
        return view ('admin.slider.create', compact('employers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serial_no_exist = Slider::whereIsActive(1)->whereSerialNo($request->serial_no)->whereNull('deleted_at')->get();
        if($serial_no_exist->count() > 0) {
            Alert::warning('Warning', 'This Serial No.'.$request->serial_no.' was already exists. Please Try Again!');
            return redirect()->back();
        }else {
            $image = Null;
            if($request->file('image')){
                $file= $request->file('image');
                $image= date('YmdHi').$file->getClientOriginalName();
                $path = $file-> move(public_path('storage/slider'), $image);
            }
            $slider = Slider::create([
                'employer_id' => $request->employer_id,
                'serial_no' => $request->serial_no,
                'image' => $image,
                'is_active' => $request->is_active,
                'created_by' => Auth::user()->id,
            ]);

        Alert::success('Success', 'New Slider Created Successfully!');
        return redirect()->route('slider.index');
        }
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
        $slider = Slider::findOrFail($id);
        return view ('admin.slider.edit', compact('slider'));
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
        $slider = Slider::findOrFail($id);
        $slider = $slider->update([
            'name' => $request->name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Slider Updated Successfully!');
        return redirect()->route('slider.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        
        try {
            $slider = Slider::findOrFail($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($slider) {
                Alert::success('Success', 'Delete Slider Successfully!');
                return redirect()->route('slider.index');
            }
            else {
                Alert::error('Failed', 'Slider deleted failed');
                return back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Slider');
                return back();
            } 
        }
    }
}
