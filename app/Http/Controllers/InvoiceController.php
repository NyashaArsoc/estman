<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

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
            $arr= DB::select('EXEC spPostPreInvoice');
            if(is_null($arr)){
                return 'problem in connection';
            }else{
                $result = $arr[0]->ReturnValue;
                if($result ==0){
                    //success full run 
                    return 'success';
                }else{
                    //already run 
                    return 'you can only run once';
                }
            }
        } catch (QueryException $th) {
            return 'failed to execute query';
        }
        
    }
public function listpreinvoice(){
    try {
        $arr['invoice']   = DB::table('preinvoice')
        ->where('isedited','<>' ,1)
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
        $arr['invoice']   = DB::table('preinvoice')
        ->where('id',$invoiceid)
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
        $arr['invoice']   = DB::table('preinvoice')
        ->where('id',$invoiceid)
        ->select('currencycode','id','rental','rates','operationalcost'
        ,'fullname','companyname','clienttypeid','period','deposit')
        ->first();
        return view('invoice/view-edit-pre-invoice')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    } 
}
public function updateprofoma($id, Request $request){
    try {
        $invoiceid = Crypt::decrypt($id);
        DB::table('preinvoice')
            ->updateOrInsert(['id'=>$invoiceid],
           [ 'rental'=>$request->Rental,'rates'=>
            $request->RatesLevies,'operationalcost'=>$request->OperationCosts
            ,'isedited' => 1 ]);
            return  redirect()->route('invoice.listpre') 
            ->with('success', 'invoice updated');
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to update');
    }
}
public function listeditedprofoma(){
    try {
        $arr['invoice']   = DB::table('preinvoice')
        ->where('isedited','=' ,1)
        ->select('*')
        ->get();
        return view('invoice/edited-pre-invoice-list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('lease.pending') 
        ->with('error', 'failed to load');
    }
}
public function vieweditedprofoma($id){
    $invoiceid = Crypt::decrypt($id);
    try {
        $arr['invoice']   = DB::table('preinvoice')
        ->where('id',$invoiceid)
        ->select('*')
        ->first();
        return view('invoice/view-edited-pre-invoice')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listeditedprofoma') 
        ->with('error', 'failed to load');
    } 
}
public function approveeditedprofoma($id, Request $request){
    try {
        $todaydate = date('Y-m-d H:i:s');
        $invoiceid = Crypt::decrypt($id);
        DB::table('preinvoice')
            ->updateOrInsert(['id'=>$invoiceid],
           [ 'isedited' => 0,'approvedon'=>$todaydate]);
            return  redirect()->route('invoice.listeditedprofoma') 
            ->with('success', 'invoice updated');
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listeditedprofoma') 
        ->with('error', 'failed to update');
    }
}
public function approveprofoma($id,$lease){
    $invoiceid = Crypt::decrypt($id);
    $leaseid =  Crypt::decrypt($lease);
    try {
        $invoice   = DB::table('preinvoice')
        ->where('id',$invoiceid)->select('*')->first();
        $tenant = DB::table('alllease')->join('alltenant','alllease.tenantid','=','alltenant.id')
    ->select('email','alltenant.vatnumber')->where('alllease.id',$leaseid)->first();
    if(is_null($tenant)){
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load'); 
    }else{
        $banking   = DB::table('bankingdetails')
        ->where('currencycode',$invoice->currencycode)->select('*')->first();

        //$invoiceperiod = date_format($invoice->period,"M-Y");
        if ($invoice->clienttypeid == 1){$tenantname   =  $invoice->fullname ;}
           else{$tenantname   =  $invoice->companyname ; } 
           $totalbilled = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
                 $invoice->balancebd + $invoice->interestbd);
         $totalvatincl = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
                 $invoice->balancebd + $invoice->interestbd + $invoice->vat);

        $data["email"] = $tenant->email;
        $data["CCemail"] = "kudzchitz@gmail.com";
        $data["title"] = "Invoice for ".$tenantname;
        $data["tenantname"] = $tenantname;
        $data["propdesc"] = $invoice->propertydescription;
        $data["period"] = $invoice->period;
        $data["tenantvatnumber"] = $tenant->vatnumber;
        $data["invoicenumber"] = $invoice->id;
        $data["balancebd"] = number_format($invoice->balancebd,2);
        $data["currencycode"] = $invoice->currencycode;
        $data["rent"] = number_format($invoice->rental,2);
        $data["rateswater"] = number_format($invoice->rates,2);
        $data["interestcharged"] = number_format($invoice->interestbd,2);
        $data["operational"] = number_format($invoice->operationalcost,2);
        $data["rentvat"] = number_format($invoice->vat,2);
        $data["billedtotal"] = number_format($totalbilled,2);
        $data["totalvatincl"] = number_format($totalvatincl,2);
        $data["bankname"] = $banking->bankname;
        $data["branch"] = $banking->branch;
        $data["accountnumber"] = $banking->accountnumber;
        $data['today'] = date('d-M-Y');
        $data["deposit"] = number_format($invoice->deposit,2);

        $invoicepdf =   PDF::loadView('tomail/invoice',$data);
        Mail::send('tomail/empty', $data, function($message)use($data, $invoicepdf) {
            $message->to($data["email"], $data["email"])
                   ->cc($data["CCemail"])
                  ->subject($data["title"])
                  ->attachData($invoicepdf->output(), ''.$data["title"].'.pdf');
        });
        echo 'mail send';
    } 
}catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }
 //$invoicepdf->download('testinvoice.pdf');
    
    // return $invoicepdf->stream('reportjs.pdf');
 
}
public function testinvoiceprint(){
   // return view('toprint/test-invoice');
   return view('tomail/invoice');
}
}
