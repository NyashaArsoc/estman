<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private $currentperiod;
    private $previousperiod;
    private $nextperiod;

    public function __construct(){

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice $invoice)
    {
        //
    }

    public function compilepreinvoice(){
        try {
            $arr= DB::select('EXEC spPostpreinvoice');
            if($arr){
                $result = $arr[0]->ReturnValue;
                if($result ==0){
                    //success full run 
                    return 'success run'.$result;
                }else{
                    //already run 
                    return 'you can only run once'.$result;
                }
            }else{
               return 'problem in connection';
            }
        } catch (QueryException $th) {
            return 'failed to execute query';
        }
        
    }
public function listpreinvoice(){
    try {
        $arr['invoice']   = DB::table('allpreinvoice')
        ->select('*')
        ->get();
        return view('invoice/pre-invoice-list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('lease.pending') 
        ->with('error', 'failed to load');
    }

}
public function viewprofoma($id){
    $invoiceid = Crypt::decrypt($id);
    try {
        $arr['invoice']   = DB::table('allpreinvoice')
        ->where('invoicenumber',$invoiceid)
        ->select('*')
        ->first();
        return view('invoice/view-pre-invoice')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }

    
}
public function vieweditprofomamount($id){
    $invoiceid = Crypt::decrypt($id);
    try {
        $arr['invoice']   = DB::table('allpreinvoice')
        ->where('invoicenumber',$invoiceid)
        ->select('currencycode','invoicenumber','prerental','prerates','operationalcost'
        ,'fullname','companyname')
        ->first();
        return view('invoice/view-edit-pre-invoice')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }

    
}
}
