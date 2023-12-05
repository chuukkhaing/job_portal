<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\BankInfo;
use Alert;
use Auth;

class BankInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bank-info-list|bank-info-create|bank-info-edit|bank-info-delete', ['only' => ['index','store']]);
        $this->middleware('permission:bank-info-create', ['only' => ['create','store']]);
        $this->middleware('permission:bank-info-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bank-info-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $banks = BankInfo::whereNull('deleted_at')->orderBy('created_at','desc')->get();
        return view ('admin.bank-info.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.bank-info.create');
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
            'bank_name' => 'required',
            'account_no' => 'required',
            'account_name' => 'required'
        ]);
        $bank = BankInfo::create([
            'bank_name' => $request->bank_name,
            'account_no' => $request->account_no,
            'account_name' => $request->account_name,
            'is_active' => $request->is_active,
            'created_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'New Bank Information Created Successfully!');
        return redirect()->route('bank-info.index');
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
        $bank = BankInfo::findOrFail($id);
        return view ('admin.bank-info.edit', compact('bank'));
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
        $bank = BankInfo::findOrFail($id);
        $bank = $bank->update([
            'bank_name' => $request->bank_name,
            'account_no' => $request->account_no,
            'account_name' => $request->account_name,
            'is_active' => $request->is_active,
            'updated_by' => Auth::user()->id,
        ]);

        Alert::success('Success', 'Bank Information Updated Successfully!');
        return redirect()->route('bank-info.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = BankInfo::findOrFail($id);
        
        try {
            $bank = BankInfo::whereId($id)->update([
                'deleted_at' => now(),
                'deleted_by' => Auth::user()->id
            ]);
            if ($bank) {
                Alert::success('Success', 'Delete Bank Information Successfully!');
                return redirect()->route('bank-info.index');
            }
            else {
                Alert::error('Failed', 'Bank Information deleted failed');
                return redirect()->back();
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                Alert::error('Failed', 'Cannot delete this Bank Information');
                return redirect()->back();
            } 
        }
    }
}
