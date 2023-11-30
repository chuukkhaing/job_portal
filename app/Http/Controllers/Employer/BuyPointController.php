<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\Package;
use App\Models\Admin\PointPackage;
use App\Models\Admin\PointOrder;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use App\Models\Admin\PackageItem;
use App\Models\Admin\Invoice;
use App\Models\Admin\BankInfo;
use App\Models\Admin\Tax;
use Storage;
use Auth;
use PDF;

class BuyPointController extends Controller
{
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
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $orders = PointOrder::whereNull('deleted_at')->whereEmployerId($employer->id)->orderBy('updated_at','desc')->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.buy-point.index', compact('employer', 'packages', 'pointPackages', 'orders', 'packageItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employer = Employer::findOrFail(Auth::guard('employer')->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        $packages = Package::whereNull('deleted_at')->where('is_active',1)->get();
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->get();
        $packageItems = PackageItem::whereIn('id',$employer->Package->PackageWithPackageItem->pluck('package_item_id'))->get();
        return view('employer.profile.buy-point.create', compact('employer', 'packages', 'pointPackages', 'packageItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone'    => ['required', new MyanmarPhone],
            'name'     => ['required', 'string'],
            'point_package_id' => ['required']
        ]);

        if(isset(Auth('employer')->user()->employer_id)) {
            $employer_id = Auth('employer')->user()->employer_id;
        }else {
            $employer_id = Auth('employer')->user()->id;
        }

        $order = PointOrder::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'point_package_id' => $request->point_package_id,
            'employer_id' => $employer_id,
            'status' => 'Pending'
        ]);
        $last_invoice_no = Invoice::orderBy('invoice_no', 'desc')->first();
        if(isset($last_invoice_no)){
            $last_invoice_no = $last_invoice_no->invoice_no;
        }else {
            $last_invoice_no = 000000;
        }
        $invoice_no = sprintf('%06d', $last_invoice_no + 1);
        $tax = Tax::first();
        $tax_amount = ($order->PointPackage->price * $tax->tax) / 100 ;
        $final_balance = $order->PointPackage->price + $tax_amount;
        $banks = BankInfo::whereNull('deleted_at')->whereIsActive(1)->get();
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        $invoice = Invoice::create([
            'invoice_no' => $invoice_no,
            'point_order_id' => $order->id,
            'tax' => $tax_amount,
            'tax_percent' => $tax->tax,
            'sub_total' => $order->PointPackage->price,
            'final_balance' => $final_balance,
            'file_name' => $fileName,
            'status' => 'Pending',
            'created_by' => Auth::user()->id
        ]);
        $tax = $invoice->tax;
        $pdf = PDF::loadView('download.invoice', compact('invoice', 'tax', 'tax_amount', 'final_balance', 'banks'));
        
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        
        $path     = 'invoice/' . $fileName;
        Storage::disk('s3')->put($path, $pdf->output());
        $path = Storage::disk('s3')->url($path);
        $order->update([
            'invoice_id' => $invoice->id
        ]);
        if($order) {
            return redirect()->route('employer-job-post.create')->with('success','Your Points order was successful.');
        }else {
            return redirect()->back()->with('warning','Your Points order was somthing wrong. Try Again!');
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
