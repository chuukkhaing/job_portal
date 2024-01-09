<?php

namespace App\Http\Controllers\API\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Employer;
use App\Models\Admin\PointPackage;
use App\Models\Admin\PointOrder;
use App\Models\Admin\Tax;
use App\Models\Admin\BankInfo;
use App\Models\Admin\Invoice;
use PyaeSoneAung\MyanmarPhoneValidationRules\MyanmarPhone;
use PDF;
use Storage;

class BuyPointController extends Controller
{
    public function index(Request $request)
    {
        $employer = Employer::findOrFail($request->user()->id);
        if($employer->employer_id) {
            $employer = Employer::findOrFail($employer->employer_id);
        }
        
        $orders = PointOrder::with(['Employer:id,name', 'PointPackage:id,point,price','Invoice:id,file_name'])->whereNull('deleted_at')->whereEmployerId($employer->id)->select('id','employer_id','name','phone','status','point_package_id','invoice_id','created_at as ordered_date')->orderBy('updated_at','desc')->get();
        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ], 200);
    }

    public function create(Request $request)
    {
        $pointPackages = PointPackage::whereNull('deleted_at')->whereIsActive(1)->select('id','point','price')->get();
        return response()->json([
            'status' => 'success',
            'pointPackages' => $pointPackages
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'phone'    => ['required', new MyanmarPhone],
            'name'     => ['required', 'string'],
            'point_package_id' => ['required']
        ]);

        if(isset($request->user()->employer_id)) {
            $employer_id = $request->user()->employer_id;
        }else {
            $employer_id = $request->user()->id;
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
            'created_by' => $request->user()->id
        ]);
        $tax = $invoice->tax;
        $pdf = PDF::loadView('download.invoice', compact('invoice', 'tax', 'tax_amount', 'final_balance', 'banks'));
        
        $fileName =  date('YmdHi').$invoice_no.'_ic_point_invoice.pdf';
        
        $path     = 'invoice/' . $fileName;
        Storage::disk('s3')->put($path, $pdf->output());
        $path = Storage::disk('s3')->url($path);
        $order_update = $order->update([
            'invoice_id' => $invoice->id
        ]);
        $getOrder = PointOrder::with(['Employer:id,name', 'PointPackage:id,point,price','Invoice:id,file_name'])->whereNull('deleted_at')->select('id','employer_id','name','phone','status','point_package_id','invoice_id')->whereId($order->id)->first();
        if($order) {
            return response()->json([
                'status' => 'success',
                'msg' => 'Your Points order was successful.',
                'order' => $getOrder
            ], 200);
        }else {
            return response()->json([
                'status' => 'error',
                'msg' => 'Your Points order was somthing wrong. Try Again!',
            ], 200);
        }

    }
}
