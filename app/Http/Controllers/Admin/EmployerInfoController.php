<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\FunctionalArea;
use App\Models\Employer\EmployerAddress;
use App\Models\Employer\EmployerMedia;
use App\Models\Employer\EmployerTestimonial;
use App\Models\Admin\PackageItem;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use DB;
use Auth;
use Str;
use Alert;
use File;
use Storage;

class EmployerInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:employer-info-list|employer-info-create|employer-info-edit|employer-info-delete', ['only' => ['index','store']]);
        $this->middleware('permission:employer-info-create', ['only' => ['create','store']]);
        $this->middleware('permission:employer-info-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:employer-info-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $employers = Employer::whereNull('deleted_at')->whereNull('employer_id')->orderBy('created_at','desc')->get();
        return view ('admin.employer-info.index', compact('employers'));
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
        $employer = Employer::findOrFail($id);
        $industries = Industry::whereNull('deleted_at')->get();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        $employer_image_media = EmployerMedia::whereEmployerId($employer->id)->whereType('Image')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view ('admin.employer-info.edit', compact('employer', 'industries', 'ownershipTypes', 'states', 'townships', 'functional_areas', 'sub_functional_areas', 'employer_image_media', 'packageItems'));
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
        $this->validate($request, [
            'name'  => ['required','string'],
            'industry_id' => ['required'],
            'ownership_type_id' => ['required'],
            'type_of_employer' => ['required'],
            'phone' => ['nullable', new MyanmarPhone],
        ]);

        $employer = Employer::findOrFail($id);

        if($request->hasFile('legal_docs')) {
            if($employer->legal_docs){
                Storage::disk('s3')->delete('employer_legal_docs/' . $employer->legal_docs);
            }
            $file    = $request->file('legal_docs');
            $legal_docs = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_legal_docs/' . $legal_docs;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }else {
            $legal_docs = $employer->legal_docs;
        }

        if($request->legal_docs_status == 'empty') {
            Storage::disk('s3')->delete('employer_legal_docs/' . $employer->legal_docs);
            $legal_docs = NULL;
        }
        $logo = $employer->logo;
        if($request->image_base64 != ''){
            $logo = $this->storeBase64($request->image_base64);
        }elseif($request->image_base64 == 'Empty') {
            $logo = '';
        }
        $background = $employer->background;
        
        if($request->background_base64 == 'Empty') {
            $background = '';
            Storage::disk('s3')->delete('employer_background/' . $employer->background);
        }elseif($request->background_base64 != ''){
            $background = $this->storeBackgroundBase64($request->background_base64);
        }

        $slug = Str::slug($request->name, '-') . '-' . $employer->id;
        $employer = $employer->update([
            'legal_docs' => $legal_docs,
            'name' => $request->name,
            'industry_id' => $request->industry_id,
            'ownership_type_id' => $request->ownership_type_id,
            'type_of_employer' => $request->type_of_employer,
            'no_of_offices' => $request->no_of_offices,
            'website' => $request->website,
            'no_of_employees' => $request->no_of_employees,
            'phone' => $request->phone,
            'slug' => $slug,
            'summary' => $request->company_summary,
            'value' => $request->company_value,
            'logo' => $logo,
            'background' => $background,
            'updated_by_admin' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Employer Updated Successfully!');
        return redirect()->route('employer-info.index');
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

    private function storeBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
        
        $path     = 'employer_logo/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);
          
        return $imageName;
    }
    
    private function storeBackgroundBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';

        $path     = 'employer_background/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);
        
        return $imageName;
    }

    private function storeTestBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
  
        $path     = 'employer_testimonial/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);
          
        return $imageName;
    }

    public function employerAddressStore(Request $request)
    {
        $address_create = EmployerAddress::create([
            'employer_id' => $request->employer_id,
            'country' => $request->country,
            'state_id' => $request->state_id,
            'township_id' => $request->township_id,
            'address_detail' => $request->address_detail
        ]);
        if($address_create->country == 'Myanmar') {
            if($address_create->township_id) {
                $address = DB::table('employer_addresses as a')
                ->join('states as b','a.state_id','=','b.id')
                ->join('townships as c','a.township_id','=','c.id')
                ->where('a.id','=',$address_create->id)
                ->select('a.*','b.name as state_name','c.name as township_name')
                ->first();
            }else {
                $address = DB::table('employer_addresses as a')
                ->join('states as b','a.state_id','=','b.id')
                ->where('a.id','=',$address_create->id)
                ->select('a.*','b.name as state_name')
                ->first();
            }
        }else {
            $address = $address_create;
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $address
        ]);
    }

    public function employerAddressDestroy($id, Request $request)
    {
        $address = EmployerAddress::findOrFail($id)->delete();
        $employer = Employer::findOrFail($request->employer_id);
        $address_count = EmployerAddress::whereEmployerId($employer->id)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Address deleted successfully!',
            'address_count' => $address_count
        ]);
    }

    public function employerTestimonialStore(Request $request)
    {
        if($request->test_image != ''){
            $image = $this->storeTestBase64($request->test_image);
        }else {
            $image = '';
        }

        $test_create = EmployerTestimonial::create([
            'employer_id' => $request->employer_id,
            'name' => $request->test_name,
            'title' => $request->test_title,
            'remark' => $request->test_remark,
            'image' => $image
        ]);

        $test_img = getS3File('employer_testimonial',$test_create->image);
        
        return response()->json([
            'status' => 'success',
            'data' => $test_create,
            'test_img' => $test_img
        ]);
    }

    public function employerTestimonialDestroy($id, Request $request)
    {

        $test = EmployerTestimonial::findOrFail($id);
        Storage::disk('s3')->delete('employer_testimonial/' . $test->image);
        $test = $test->delete();
        $employer = Employer::findOrFail($request->employer_id);
        $test_count = EmployerTestimonial::whereEmployerId($employer->id)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Testimonial deleted successfully!',
            'test_count' => $test_count
        ]);
    }

    public function employerMediaStore(Request $request)
    {
        if ($request->upload_image) {
            $image = $this->storeMediaBase64($request->upload_image);
            $media_create = EmployerMedia::create([
                'employer_id' => $request->employer_id,
                'name' => $image,
                'type' => 'Image',
            ]);
        }
        if ($request->video_link) {
            $media_create = EmployerMedia::create([
                'employer_id' => $request->employer_id,
                'name' => $request->video_link,
                'type' => 'Video Link',
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $media_create
        ]);
    }

    public function employerMediaDestroy($id, Request $request)
    {

        $media = EmployerMedia::findOrFail($id);
        if($media->type == 'Image'){
            File::deleteDirectory(public_path('storage/employer_media/'.'/'.$media->name));
        }
        $media_type = $media->type;
        $media = $media->delete();
        $employer = Employer::findOrFail($request->employer_id);
        $media_count = EmployerMedia::whereEmployerId($employer->id)->whereType($media_type)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Media deleted successfully!',
            'media_count' => $media_count
        ]);
    }

    private function storeMediaBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
        $path = public_path() . "/storage/employer_media/" . $imageName;
  
        file_put_contents($path, $imageBase64);
          
        return $imageName;
    }
}
