<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Invoice;
use App\Models\Admin\Employer;
use App\Mail\InvoiceEmail;
use App\Mail\ReceiptEmail;
use Alert;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:invoice-list', ['only' => ['index']]);
        
    }

    public function index()
    {
        $invoices = Invoice::whereNull('deleted_at')->orderBy('invoice_no','asc')->get();
        return view ('admin.invoice.index', compact('invoices'));
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
        //
    }

    public function sendInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $employer = Employer::findOrFail($invoice->PointOrder->Employer->id);
        \Mail::to($employer->email)->cc([env('MAIL_FROM_ADDRESS'), env('FINANCE_EMAIL')])->send(new InvoiceEmail($invoice));
        Alert::success('Success', 'Invoice Send Successfully!');
        return redirect()->route('invoice.index');
    }

    public function sendReceipt($id)
    {
        $invoice = Invoice::findOrFail($id);
        $employer = Employer::findOrFail($invoice->PointOrder->Employer->id);
        \Mail::to($employer->email)->cc([env('MAIL_FROM_ADDRESS'), env('FINANCE_EMAIL')])->send(new ReceiptEmail($invoice));
        Alert::success('Success', 'Receipt Send Successfully!');
        return redirect()->route('invoice.index');
    }
}
