<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Slider;
use App\Models\Admin\Employer;
use DB;
use Alert;
use Auth;
use Storage;

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
        $employers  = DB::table('employers as a')
                        ->join('package_with_package_items as b','a.package_id','=','b.package_id')
                        ->join('package_items as c','b.package_item_id','=','c.id')
                        ->where('c.name','=','Home Page Banner')
                        ->select('a.*')
                        ->where('a.is_active','=',1)
                        ->where('a.deleted_at','=',Null)
                        ->orderBy('a.updated_at','desc')
                        ->get();
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
        $request->validate([
            'serial_no' => 'required|unique:sliders,serial_no,NULL,id,deleted_at,NULL,is_active,1',
            'image' => 'required',
        ]);

        if($request->image_base64 != ''){
            $image = $this->storeBase64($request->image_base64);
        }else {
            $image = '';
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
        $employers  = DB::table('employers as a')
                        ->join('package_with_package_items as b','a.package_id','=','b.package_id')
                        ->join('package_items as c','b.package_item_id','=','c.id')
                        ->where('c.name','=','Home Page Banner')
                        ->select('a.*')
                        ->where('a.is_active','=',1)
                        ->where('a.deleted_at','=',Null)
                        ->orderBy('a.updated_at','desc')
                        ->get();
        return view ('admin.slider.edit', compact('slider','employers'));
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
            'serial_no' => 'required|unique:sliders,serial_no,'.$id.',id,deleted_at,NULL,is_active,1',
            
        ]);
        $slider = Slider::findOrFail($id);
        if($request->image_status == 'false') {
            return redirect()->back()->withErrors(['msg' => 'Image need to upload.']);;
        }else {
            if($request->image_base64 != ''){
                $image = $this->storeBase64($request->image_base64);
            }else {
                $image = '';
            }
            $slider_update = $slider->update([
                'employer_id' => $request->employer_id,
                'image' => $image,
                'serial_no' => $request->serial_no,
                'is_active' => $request->is_active,
                'updated_by' => Auth::user()->id,
            ]);

            Alert::success('Success', 'Slider Update Successfully!');
            return redirect()->route('slider.index');
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
        $slider = Slider::findOrFail($id);
        
        try {
            $slider = Slider::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            Storage::disk('s3')->delete('slider/' . $slider->image);
            if ($slider) {
                Alert::success('Success', 'Delete Slider Successfully!');
                return redirect()->route('slider.index');
            }
            else {
                Alert::error('Failed', 'Slider deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Slider');
                return redirect()->back();
            } 
        }
    }

    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';

        $path     = 'slider/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);
        
        return $imageName;
    }

}
