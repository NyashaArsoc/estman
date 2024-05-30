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
        $this->middleware(['loginauth']);
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
        ->where('isedited','<>' ,'Y')
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
        $user = $this->userdetail();
        $invoiceid = Crypt::decrypt($id);
        DB::table('preinvoice')
            ->updateOrInsert(['id'=>$invoiceid],
           [ 'rental'=>$request->Rental,'rates'=>
            $request->RatesLevies,'operationalcost'=>$request->OperationCosts
            ,'isedited' => 'Y','editedby'=>$user->username ]);
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
        ->where('isedited','=' ,'Y')
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
        $user = $this->userdetail();
        $todaydate = date('Y-m-d H:i:s');
        $invoiceid = Crypt::decrypt($id);
        DB::table('preinvoice')
            ->updateOrInsert(['id'=>$invoiceid],
           [ 'isedited' => 'N','approvedon'=>$todaydate,'approvedby'=>$user->username]);
            return  redirect()->route('invoice.listeditedprofoma') 
            ->with('success', 'invoice updated');
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listeditedprofoma') 
        ->with('error', 'failed to update');
    }
}
public function approveprofoma($id,$lease){
    $user = $this->userdetail();
    $invoiceid = Crypt::decrypt($id);
    $leaseid =  Crypt::decrypt($lease);
    $productcolumn          =       'leaseid';
    $ledger_vat             =        'vat';
    $ledger_creditors       =        'creditors';
    try {
        $systemdate             =       $this->systemdate();
        $trxid                  =       $this->transationid();
        $basecurrency           =       $this->getbasecurrency();
        
        
        $invoice   = DB::table('preinvoice')
        ->where('id',$invoiceid)->select('*')->first();
        $tenant = DB::table('alllease')->join('alltenant','alllease.tenantid','=','alltenant.id')
            ->select('email','alltenant.vatnumber')->where('alllease.id',$leaseid)->first();
            /*check if the base currency is the one running 
                    use exchange rate as 1*/
    if(trim($basecurrency)  ==      trim($invoice->currencycode)){ $exchangerate =1;}
    else{ $exchangerate  =  $this->getexchangerate($invoice->currencycode);   }
    $productsubledger       =       $this->getproductsubledger($productcolumn,$leaseid,$invoice->currencycode);
    $rentalsubledger        =       $this->getrentalsubledger($leaseid,$invoice->currencycode);
    $vatcode                =       $this->getgeneralledger($ledger_vat,$invoice->currencycode);
    $creditorscode          =       $this->getgeneralledger($ledger_creditors,$invoice->currencycode);
    if(is_null($tenant)){
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load'); 
    }else{
        $banking   = DB::table('bankingdetails')
        ->where('currencycode',$invoice->currencycode)->select('*')->first();
        if($systemdate != 'failed'){
            if($rentalsubledger!='failed' || $productsubledger!='failed' || $creditorscode!='failed'
            || $vatcode!='failed'){// correct ledgers
                if ($invoice->clienttypeid == 1){$tenantname   =  $invoice->fullname ;}
                else{$tenantname   =  $invoice->companyname ; }
                $totalbilled = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
                 $invoice->balancebd + $invoice->interestbd);
                    $totalvatincl = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
                    $invoice->balancebd + $invoice->interestbd + $invoice->vat);
                // data for email 
                //$data["email"]          = $tenant->email;
                $data["email"]          = "propman@intpro.co.zw";
                $data["CCemail"]        = "kudzchitz@gmail.com";
                $data["title"]          = "Invoice for ".$tenantname;
                $data["tenantname"]     = $tenantname;
                $data["propdesc"]       = $invoice->propertydescription;
                $data["period"]         = $invoice->period;
                $data["tenantvatnumber"] = $tenant->vatnumber;
                $data["invoicenumber"]  = $invoice->id;
                $data["balancebd"]      = number_format($invoice->balancebd,2);
                $data["currencycode"]   = $invoice->currencycode;
                $data["rent"]           = number_format($invoice->rental,2);
                $data["rateswater"]     = number_format($invoice->rates,2);
                $data["interestcharged"] = number_format($invoice->interestbd,2);
                $data["operational"]    = number_format($invoice->operationalcost,2);
                $data["rentvat"]        = number_format($invoice->vat,2);
                $data["billedtotal"]    = number_format($totalbilled,2);
                $data["totalvatincl"]   = number_format($totalvatincl,2);
                $data["bankname"]       = $banking->bankname;
                $data["branch"]         = $banking->branch;
                $data["accountnumber"]  = $banking->accountnumber;
                $data['today']          = date('d-M-Y');
                $data["deposit"]        = number_format($invoice->deposit,2); 
                //convert to pdf
                $invoicepdf =   PDF::loadView('tomail/invoice',$data);
                //mail the invoice
                Mail::send('tomail/empty', $data, function($message)use($data, $invoicepdf) {
                    $message->to($data["email"], $data["email"])
                           ->cc($data["CCemail"])
                          ->subject($data["title"])
                          ->attachData($invoicepdf->output(), ''.$data["title"].'.pdf'); 
                });
                // return $invoicepdf->stream('reportjs.pdf');
                //double entry into ledgers
                    // transaction description 
                    $trxdescriptionclient = 'Invoice Number '.$invoice->id;
                    $trxdescriptionrates = 'Invoice Number '.$invoice->id.' Rates';
                    $trxdescriptionoppcst = 'Invoice Number '.$invoice->id. ' Operational Costs';
                    $totalvatincltrxratedamt = $totalvatincl * $exchangerate;
                    $rentaltrxratedamt = $invoice->rental * $exchangerate;
                    $vattrxratedamt = $invoice->vat * $exchangerate;
                    $ratestrxratedamt = $invoice->rates * $exchangerate;
                    $oppcoststrxratedamt = $invoice->rates * $exchangerate;
                    //transaction debit client
                DB::table('accounttransactions')
                ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$productsubledger
                 ,'trxtype'=>'TD','trxcurrencycode'=>$invoice->currencycode,'trxamount'=>$totalvatincl,
                    'trxratedamount'=>$totalvatincltrxratedamt,'trxexchangerate'=>$exchangerate,
                    'trxdescription'=>$trxdescriptionclient,'trxsystemdate'=>$systemdate,
                    'trxcreatedby'=>$user->username]);
                //transaction credit rental
                if($invoice->rental <> 0 || $invoice->rental < 0){
                    DB::table('accounttransactions')
                    ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$rentalsubledger
                    ,'trxtype'=>'TC','trxcurrencycode'=>$invoice->currencycode,'trxamount'=>$invoice->rental,
                    'trxratedamount'=>$rentaltrxratedamt,'trxexchangerate'=>$exchangerate,
                    'trxdescription'=>$trxdescriptionclient,'trxsystemdate'=>$systemdate,
                    'trxcreatedby'=>$user->username]);
                }
                //transaction credit vat
                if($invoice->vat <> 0 || $invoice->vat < 0){
                    DB::table('accounttransactions')
                    ->insert(['trxreference'=>$trxid,'trxglaccount'=>$vatcode
                    ,'trxtype'=>'TC','trxcurrencycode'=>$invoice->currencycode,'trxamount'=>$invoice->vat,
                    'trxratedamount'=>$vattrxratedamt,'trxexchangerate'=>$exchangerate,
                    'trxdescription'=>$trxdescriptionclient,'trxsystemdate'=>$systemdate,
                    'trxcreatedby'=>$user->username]);
                }
                 //transaction credit rates
                 if($invoice->vat <> 0 || $invoice->vat < 0){
                    DB::table('accounttransactions')
                    ->insert(['trxreference'=>$trxid,'trxglaccount'=>$creditorscode
                    ,'trxtype'=>'TC','trxcurrencycode'=>$invoice->currencycode,'trxamount'=>$invoice->rates,
                    'trxratedamount'=>$ratestrxratedamt,'trxexchangerate'=>$exchangerate,
                    'trxdescription'=>$trxdescriptionrates,'trxsystemdate'=>$systemdate,
                    'trxcreatedby'=>$user->username]);
                }
                //transaction credit opperational costs
                if($invoice->operationalcost <> 0 || $invoice->operationalcost < 0){
                    DB::table('accounttransactions')
                ->insert(['trxreference'=>$trxid,'trxglaccount'=>$creditorscode
                ,'trxtype'=>'TC','trxcurrencycode'=>$invoice->currencycode,'trxamount'=>$invoice->operationalcost,
                'trxratedamount'=>$oppcoststrxratedamt,'trxexchangerate'=>$exchangerate,
                'trxdescription'=>$trxdescriptionoppcst,'trxsystemdate'=>$systemdate,
                'trxcreatedby'=>$user->username]);
                }
             //post data into invoices & arrear details and clear preinvoice 
             DB::select ('EXEC spPostGenerateInvoiceAndArrears ?,?',array($invoiceid,$systemdate));

             return  redirect()->route('invoice.listpre') 
             ->with('success', 'invoice send to client');
            }
        }
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'system date not found');
    } 
}catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }
}
public function listinvoice(){
    try {
        $arr['invoice']   = DB::table('invoicegenerated')
        ->select('*')
        ->get();
        return view('invoice/invoice-list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('lease.pending') 
        ->with('error', 'failed to load');
    }
}
public function viewgeneratedinvoice($id){
    $invoiceid = Crypt::decrypt($id);
    try {
        $arr['invoice']   = DB::table('invoicegenerated')
        ->where('id',$invoiceid)
        ->select('*')
        ->first();
        return view('invoice/view-invoice-generated')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }  
}
public function printgeneratedinvoice($id,$lease){
    $invoiceid = Crypt::decrypt($id);
    $leaseid =  Crypt::decrypt($lease);
    $invoice   = DB::table('invoicegenerated')
        ->where('id',$invoiceid)->select('*')->first();
        $tenant = DB::table('alllease')->join('alltenant','alllease.tenantid','=','alltenant.id')
            ->select('email','alltenant.vatnumber')->where('alllease.id',$leaseid)->first();
            $banking   = DB::table('bankingdetails')
            ->where('currencycode',$invoice->currencycode)->select('*')->first();
    if ($invoice->clienttypeid == 1){$tenantname   =  $invoice->fullname ;}
            else{$tenantname   =  $invoice->companyname ; }
            $totalbilled = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
            $invoice->balancebd + $invoice->interestbd);
               $totalvatincl = ($invoice->rental + $invoice->rates + $invoice->operationalcost +
               $invoice->balancebd + $invoice->interestbd + $invoice->vat);
    // data for export 
    $data["title"]          = "Invoice for ".$tenantname;
    $data["tenantname"]     = $tenantname;
    $data["propdesc"]       = $invoice->propertydescription;
    $data["period"]         = $invoice->period;
    $data["tenantvatnumber"] = $tenant->vatnumber;
    $data["invoicenumber"]  = $invoice->invoicenumber;
    $data["balancebd"]      = number_format($invoice->balancebd,2);
    $data["currencycode"]   = $invoice->currencycode;
    $data["rent"]           = number_format($invoice->rental,2);
    $data["rateswater"]     = number_format($invoice->rates,2);
    $data["interestcharged"] = number_format($invoice->interestbd,2);
    $data["operational"]    = number_format($invoice->operationalcost,2);
    $data["rentvat"]        = number_format($invoice->vat,2);
    $data["billedtotal"]    = number_format($totalbilled,2);
    $data["totalvatincl"]   = number_format($totalvatincl,2);
    $data["bankname"]       = $banking->bankname;
    $data["branch"]         = $banking->branch;
    $data["accountnumber"]  = $banking->accountnumber;
    $data['today']          = date('d-M-Y');
    $data["deposit"]        = number_format($invoice->deposit,2); 
    $invoicepdf =   PDF::loadView('toprint/generated-invoice',$data);

     return $invoicepdf->stream(''.$data["title"].'.pdf');
}
public function listfailedprofoma(){
    try {
        $arr['invoice']   = DB::table('preinvoicefailed')
        ->select('*')
        ->get();
        return view('invoice/failed-invoice-list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('lease.pending') 
        ->with('error', 'failed to load');
    }
}
public function viewfailedgeneratedprofoma($id){
    $invoiceid = Crypt::decrypt($id);
    try {
        $arr['invoice']   = DB::table('preinvoicefailed')
        ->where('id',$invoiceid)
        ->select('*')
        ->first();
        return view('invoice/view-profoma-failed')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listpre') 
        ->with('error', 'failed to load');
    }
}
}
