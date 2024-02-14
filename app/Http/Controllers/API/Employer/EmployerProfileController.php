<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Employer\JobPost;
use App\Models\Admin\Package;
use App\Models\Admin\PackageWithPackageItem;
use App\Models\Employer\PointRecord;
use App\Models\Admin\OwnershipType;
use App\Models\Admin\FunctionalArea;
use App\Models\Employer\EmployerAddress;
use App\Models\Employer\EmployerTestimonial;
use App\Models\Employer\EmployerMedia;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\Skill;
use Storage;
use Str;
use DB;

class EmployerProfileController extends Controller
{
    public function dashboard(Request $request)
    {
        $employer = Employer::with(['MainEmployer:id,package_point as point_balance,purchased_point','MemberPermission:id,employer_id,name'])->whereId($request->user()->id)->select('id','employer_id', 'logo',DB::raw("(CASE WHEN (employer_id != 'NULL') THEN 'Member' ELSE 'Admin' End) as Access"), 'package_point as point_balance','purchased_point')->first();

        $member_ids = Employer::whereId($request->user()->id)->first()->Member->pluck('id')->toArray();
        $employer_id = [];
        foreach($member_ids as $member_id) {
            $employer_id[] = $member_id;
        }
        
        $employer_id[] = $employer->id;
        $employer_id[] = $employer->employer_id;
        
        $open_jobs = JobPost::where('is_active',1)->where('status','Online')->whereIn('employer_id', $employer_id)->count();
        $use_point_history = PointRecord::whereIn('employer_id', $employer_id)->where('status','Complete')->sum('point');
        $lastJobPosts = JobPost::with(['township:id,name'])->whereEmployerId($employer->id)->where('status','Online')->orderBy('posted_at','desc')->select('id','job_title','slug','township_id','updated_at as posted_at')->withCount(['JobApply'])->get()->take(5);
        return response()->json([
            'status' => 'success',
            'open_jobs' => $open_jobs,
            'use_point_history' => $use_point_history,
            'employer' => $employer,
            'lastJobPosts' => $lastJobPosts
        ], 200);
    }

    public function package(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $employer_package = Package::with(['PackageWithPackageItem' => function ($packagewithitem) {
            $packagewithitem->with(['PackageItem' => function ($packageItem) {
                $packageItem->select('id','name','point')->where('is_active', 1)->whereNull('deleted_at');
            }])->select('id', 'package_id', 'package_item_id');
        }])->whereId($employer->package_id)->select('id', 'name')->whereIsActive(1)->whereNull('deleted_at')->first();
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->select('id','name','price','point','number_of_days','number_of_users','is_active')->get();
        $packageItems = PackageWithPackageItem::with(['Package' => function($package) {
            $package->select('id','name')->whereNull('deleted_at')->where('is_active',1);
        },'PackageItem:id,name,point,is_active'])->select('id', 'package_id', 'package_item_id')->get();
        return response()->json([
            'status' => 'success',
            'employer_package' => $employer_package,
            'packages' => $packages,
            'packageItems' => $packageItems
        ], 200);
    }

    public function profile(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        $account_info = Employer::with(['MemberPermission:id,employer_id,name'])->whereId($request->user()->id)->select('id', 'email','is_active', DB::raw("(CASE WHEN (employer_id != 'NULL') THEN 'Member' ELSE 'Admin' End) as Access"))->first();
        if($employer->employer_id) {
            $employer = $employer->findOrFail($employer->employer_id);
        }
        $employer = Employer::with(['Package' => function ($package) {
            $package->with(['PackageWithPackageItem' => function ($packagewithitem) {
                $packagewithitem->with(['PackageItem' => function ($packageItem) {
                    $packageItem->select('id','name','point')->where('is_active', 1)->whereNull('deleted_at');
                }])->select('id', 'package_id', 'package_item_id');
            }])->select('id', 'name', 'is_active')->where('is_active', 1)->whereNull('deleted_at');
        }, 'EmployerAddress:id,employer_id,country,state_id,township_id,address_detail', 'EmployerTestimonial:id,employer_id,name,title,remark,image','EmployerMedia:id,employer_id,name,type'])->whereId($employer->id)->select('id','logo','background','name','industry_id','ownership_type_id','type_of_employer','phone','website','no_of_offices','no_of_employees','legal_docs','summary','value', 'package_id', 'package_start_date as package_effective_date', 'package_end_date as package_expired_date')->first();
        $ownershipTypes = OwnershipType::whereNull('deleted_at')->whereIsActive(1)->select('id','name','is_active')->get();
        $type_of_employers = config('typeOfEmployer.value');
        return response()->json([
            'status' => 'success',
            'account_info' => $account_info,
            'employer' => $employer,
            'type_of_employers' => $type_of_employers,
            'ownershipTypes' => $ownershipTypes
        ], 200);
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required','string'],
            'industry_id' => ['required'],
            'ownership_type_id' => ['required'],
            'type_of_employer' => ['required'],
            'phone' => ['nullable', new MyanmarPhone],
        ]);

        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->legal_docs == $employer->legal_docs) {
            $legal_docs = $employer->legal_docs;
        }
        elseif($request->hasFile('legal_docs')) {
            if($employer->legal_docs){
                Storage::disk('s3')->delete('employer_legal_docs/' . $employer->legal_docs);
            }
            $file    = $request->file('legal_docs');
            $legal_docs = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_legal_docs/' . $legal_docs;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }elseif($request->legal_docs == null) {
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
            'summary' => $request->summary,
            'value' => $request->value,
        ]);
        $employer = Employer::with(['MainEmployer:id,logo,background,name,email,industry_id,ownership_type_id,type_of_employer,summary,value,phone,no_of_offices,website,no_of_employees,slug', 'Industry:id,name', 'OwnershipType:id,name'])->whereId($employer->id)->select('id','employer_id','logo','background','name','email','industry_id','ownership_type_id','type_of_employer','summary','value','phone','no_of_offices','website','no_of_employees','slug')->first();
        return response()->json([
            'status' => 'success',
            'employer' => $employer
        ], 200);
    }

    public function uploadLogo (Request $request)
    {
        $this->validate($request, [
            'logo'  => ['required'],
        ]);

        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->hasFile('logo')) {
            $file    = $request->file('logo');
            $logo = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_logo/' . $logo;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
        }
        $employer = $employer->update([
            'logo' => $logo,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'logo' => $logo,
            'msg'    => 'Logo uploaded successfully.'
        ], 200);
    }

    public function removeLogo(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        Storage::disk('s3')->delete('employer_logo/' . $employer->logo);
        $employer = $employer->update([
            'logo' => Null,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Logo removed successfully.'
        ], 200);
    }

    public function uploadBackground (Request $request)
    {
        $this->validate($request, [
            'background'  => ['required'],
        ]);
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }

        if($request->hasFile('background')) {
            $file    = $request->file('background');
            $imageName = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_background/' . $imageName;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
            
        }
        $employer = $employer->update([
            'background' => $imageName,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'background' => $imageName,
            'msg'    => 'Background uploaded successfully.'
        ], 200);
    }

    public function removeBackground(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        Storage::disk('s3')->delete('employer_background/' . $employer->background);

        $employer = $employer->update([
            'background' => Null,
            'updated_by' => $request->user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'msg'    => 'Background removed successfully.'
        ], 200);
    }

    public function addressStore(Request $request)
    {
        $this->validate($request, [
            'country'  => ['required'],
            'state_id' => ['required_if:country,Myanmar']
        ]);
        $address_create = EmployerAddress::create([
            'employer_id' => $request->user()->id,
            'country' => $request->country,
            'state_id' => $request->state_id,
            'township_id' => $request->township_id,
            'address_detail' => $request->address_detail
        ]);
        $address = EmployerAddress::with('state:id,name', 'township:id,name')->whereId($address_create->id)->select('id','employer_id','country','state_id','township_id','address_detail')->first();
        
        return response()->json([
            'status' => 'success',
            'address' => $address,
            'msg'    => 'Address stored successfully.'
        ], 200);
    }

    public function addressDestroy($id, Request $request)
    {
        $address = EmployerAddress::findOrFail($id)->delete();
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $address_count = EmployerAddress::whereEmployerId($employer->id)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Address deleted successfully!',
            'address_count' => $address_count
        ], 200);
    }

    public function testimonialStore(Request $request)
    {
        $this->validate($request, [
            'name'  => ['required'],
            'title' => ['required']
        ]);

        if($request->hasFile('image')) {
            $file    = $request->file('image');
            $image = date('YmdHi').$file->getClientOriginalName();
            
            $path     = 'employer_testimonial/' . $image;
            Storage::disk('s3')->put($path, file_get_contents($file));
            $path = Storage::disk('s3')->url($path);
            
        }else {
            $image = '';
        }

        $testimonial = EmployerTestimonial::create([
            'employer_id' => $request->user()->id,
            'name' => $request->name,
            'title' => $request->title,
            'remark' => $request->remark,
            'image' => $image
        ]);

        
        return response()->json([
            'status' => 'success',
            'testimonial' => $testimonial,
        ], 200);
    }

    public function testimonialDestroy($id, Request $request)
    {
        $test = EmployerTestimonial::findOrFail($id);
        Storage::disk('s3')->delete('employer_testimonial/' . $test->image);
        $test = $test->delete();
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $test_count = EmployerTestimonial::whereEmployerId($employer->id)->count();

        return response()->json([
            'status' => 'success',
            'msg' => 'Testimonial deleted successfully!',
            'test_count' => $test_count
        ], 200);
    }

    public function mediaStore(Request $request)
    {
        $this->validate($request, [
            'type'  => ['required'],
            'image' => ['required_if:type,Image'],
            'video_link' => ['required_if:type,Video Link']
        ]);
        if($request->type == "Image") {
            if($request->hasFile('image')) {
                $file    = $request->file('image');
                $name = date('YmdHi').$file->getClientOriginalName();
                
                $path     = 'employer_media/' . $name;
                Storage::disk('s3')->put($path, file_get_contents($file));
                $path = Storage::disk('s3')->url($path);
                
            }
        }elseif($request->type == "Video Link") {
            if ($request->video_link) {
                $name = $request->video_link;
            }
        }
    
        $media_create = EmployerMedia::create([
            'employer_id' => $request->user()->id,
            'name' => $name,
            'type' => $request->type,
        ]);
        
        return response()->json([
            'status' => 'success',
            'media_create' => $media_create,
            'msg' => 'Media Added successfully!',
        ], 200);
    }

    public function mediaDestroy($id, Request $request)
    {
        $media = EmployerMedia::findOrFail($id);
        $media_type = $media->type;
        if($media->type == 'Image'){
            Storage::disk('s3')->delete('employer_media/' . $media->name);
        }
        $media = $media->delete();
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        
        return response()->json([
            'status' => 'success',
            'msg' => 'Media deleted successfully!'
        ]);
    }

    public function getSkill(Request $request)
    {
        $this->validate($request, [
            'main_functional_area_id'  => ['required']
        ]);
        $skills        = Skill::whereNull('deleted_at')->where('main_functional_area_id', $request->main_functional_area_id)->whereIsActive(1)->select('id','name','main_functional_area_id')->get();
        return response()->json([
            'status' => 'success',
            'data'   => $skills,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logout!'
        ]);
    }
}
