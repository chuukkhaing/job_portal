<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Industry;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\State;
use App\Models\Admin\Township;
use App\Models\Admin\Package;
use App\Models\Admin\FunctionalArea;
use App\Models\Employer\JobPost;
use App\Models\Employer\EmployerAddress;
use App\Models\Employer\EmployerMedia;
use App\Models\Employer\EmployerTestimonial;
use App\Models\Admin\PackageItem;
use File;
use Str;
use DB;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use Auth;
use Storage;

class EmployerProfileController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('employer')->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return response()->json([
            'status' => 'success'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $lastJobPosts = JobPost::whereEmployerId($employer->id)->where('status','Online')->orderBy('updated_at','desc')->get()->take(5);
        return view ('employer.profile.dashboard', compact('employer', 'packages', 'lastJobPosts', 'packageItems'));
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $industries = Industry::whereNull('deleted_at')->get();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->get();
        $states = State::whereNull('deleted_at')->get();
        $townships = Township::whereNull('deleted_at')->get();
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $functional_areas = FunctionalArea::whereNull('deleted_at')->whereFunctionalAreaId(0)->whereIsActive(1)->get();
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id','!=',0)->whereIsActive(1)->get();
        
        $employer_image_media = EmployerMedia::whereEmployerId($employer->id)->whereType('Image')->get();
        return view ('employer.profile.edit', compact('packageItems', 'employer', 'industries', 'ownershipTypes', 'states', 'townships', 'packages', 'functional_areas', 'sub_functional_areas', 'employer_image_media'));
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

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

        $slug = Str::slug($request->name, '-') . '-' . $employer->id;
        $employer_update = $employer->update([
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
            // 'updated_by_admin' => $id,
        ]);

        if($employer_update) {
            return redirect()->route('employer-job-post.create')->with('success','Profile Edit Successfully.');
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

    public function getTownship($id)
    {
        $townships = Township::whereStateId($id)->whereNull('deleted_at')->orderBy('name')->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $townships
        ]);
    }

    public function getSubFunctionalArea($id)
    {
        $sub_functional_areas = FunctionalArea::whereNull('deleted_at')->where('functional_area_id',$id)->whereIsActive(1)->get();
        return response()->json([
            'status' => 'success',
            'data' => $sub_functional_areas
        ]);
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
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
            $image = $this->storeBase64($request->test_image);
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
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
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $media_count = EmployerMedia::whereEmployerId($employer->id)->whereType($media_type)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Media deleted successfully!',
            'media_count' => $media_count
        ]);
    }

    public function uploadLogo (Request $request)
    {
        $employer = Employer::findOrFail($request->employer_id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->hasFile('employer_logo')) {
            $file    = $request->file('employer_logo');
            $logo = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_logo/' . $logo;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }
        $employer = $employer->update([
            'logo' => $logo,
            'updated_by' => Auth::guard('employer')->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Logo uploaded successfully.'
        ]);
    }

    public function removeLogo(Request $request)
    {
        $employer = Employer::findOrFail($request->employer_id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        Storage::disk('s3')->delete('employer_logo/' . $employer->logo);
        $employer = $employer->update([
            'logo' => Null,
            'updated_by' => Auth::guard('employer')->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Logo removed successfully.'
        ]);
    }

    public function uploadBackground (Request $request)
    {
        $employer = Employer::findOrFail($request->employer_id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->hasFile('employer_background')) {
            $file    = $request->file('employer_background');
            $imageName = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_background/' . $imageName;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
            
        }
        $employer = $employer->update([
            'background' => $imageName,
            'updated_by' => Auth::guard('employer')->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Background uploaded successfully.'
        ]);
    }

    public function removeBackground(Request $request)
    {
        $employer = Employer::findOrFail($request->employer_id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        Storage::disk('s3')->delete('employer_background/' . $employer->background);

        $employer = $employer->update([
            'background' => Null,
            'updated_by' => Auth::guard('employer')->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Background removed successfully.'
        ]);
    }

    public function manageJob()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);

        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $pendingjobPosts = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Pending')->whereIsActive(1)->orderBy('updated_at', 'desc')->get();
        $onlinejobPosts = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Online')->whereIsActive(1)->orderBy('updated_at', 'desc')->get();
        $rejectjobPosts = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Reject')->whereIsActive(1)->orderBy('updated_at', 'desc')->get();
        $expirejobPosts = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->whereIsActive(1)->orderBy('updated_at', 'desc')->get();
        $draftjobPosts = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Draft')->whereIsActive(1)->orderBy('updated_at', 'desc')->get();
        $jobPosts = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(1)->orderBy('updated_at', 'desc')->get();

        if($jobPosts->count() > 0) {
            return view ('employer.profile.employer-job', compact('employer', 'packages', 'packageItems', 'pendingjobPosts', 'onlinejobPosts', 'rejectjobPosts', 'expirejobPosts', 'draftjobPosts'));
        }else {
            return redirect()->route('employer-job-post.create');
        }

    }

    public function applicantTracking()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        
        $member_ids = $employer->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;

        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        $activejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(1)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->get();
        $inactivejobApplicants = JobPost::whereIn('employer_id', $employer_id)->whereIsActive(0)->where('status','!=', 'Expire')->orderBy('updated_at', 'desc')->get();
        $expirejobApplicants = JobPost::whereIn('employer_id', $employer_id)->where('status', 'Expire')->orderBy('updated_at', 'desc')->get();
        return view ('employer.profile.applicant-tracking', compact('activejobApplicants', 'inactivejobApplicants', 'expirejobApplicants', 'employer', 'packages', 'packageItems'));
    }

    private function storeBase64($imageBase64)
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

    private function storeMediaBase64($imageBase64)
    {
        list($type, $imageBase64) = explode(';', $imageBase64);
        list(, $imageBase64)      = explode(',', $imageBase64);
        $imageBase64 = base64_decode($imageBase64);
        $imageName= time().'.png';
        
        $path     = 'employer_media/' . $imageName;
        Storage::disk('s3')->put($path, $imageBase64);
        $path = Storage::disk('s3')->url($path);

        return $imageName;
    }
}
