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
