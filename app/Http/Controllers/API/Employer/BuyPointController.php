<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\PointPackage;
use App\Models\Admin\PointOrder;

class BuyPointController extends Controller
{
    public function index()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $orders = PointOrder::whereNull('deleted_at')->whereEmployerId($employer->id)->orderBy('updated_at','desc')->get();
        return view('employer.profile.buy-point.index', compact('employer', 'packages', 'pointPackages', 'orders', 'packageItems'));
    }
}
