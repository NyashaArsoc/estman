<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use App\Models\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExport;
use Illuminate\Support\Facades\Auth;
use App\Exports\LandlordExport;

class ReportController extends Controller
{
public function __construct(){
        $this->middleware(['loginauth']);
}
public function viewlandlord(){
    try {
        $arr['landlord']   = DB::table('alllandlord')
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description','reasons','available','approval')
        ->get();
        return view('report/landlord/list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
public function viewproperty(){
    try {
        $arr['property']   = DB::table('allproperty')
        ->select('fullname','id','companyname','code','landlordclienttype',
        'location','propertytype','streetaddress','available','approval')
        ->get();
        return view('report/property/list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
public function viewpropertyoccupancy(){
    try {
        $arr['occupany'] =DB::select('EXEC spReportOccupancyRate');
        return view('report/property/occupancy')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load property list');
    }
}
public function printpropertyoccupancy(){
    try {
        ini_set('max_execution_time', 200);
        $data['occupany'] =DB::select('EXEC spReportOccupancyRate');
        $data['date'] = date('d-M/Y');
        $reportpdf =   PDF::loadView('report/property/print/occupancy',$data);

        return $reportpdf->stream('propertyoccupancy.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load property list');
    }
    
}
public function viewrentrollist(){
    try {
    $arr['property']   = DB::table('allproperty')
    ->where('available','=' ,'Y')
    ->select('id','streetaddress')
    ->get();
    $arr['period']   = DB::table('checkperiodrun')
    ->where('isinvoicerun','=' ,1)
    ->select('period')->distinct()
    ->get();
    $arr['code']   = DB::table('currency')
    ->select('*')->get();
    return view('report/property/rent-roll')
    ->with($arr);
} catch (\Throwable $th) {
    return  redirect()->route('report.viewprop') 
    ->with('error', 'failed to load property rent roll');
}
}
public function printpropertyrentroll(Request $request){
    if ($request->PropertyAddress == 'all'){
       // return 'all';
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }else{
        return $this->printrentrollsingleproperty($request->RollCurrency,$request->RollPeriod
    ,$request->PropertyAddress);
    }
}
public function printrentrollsingleproperty($currency,$period,$propertyid){
    try {
        ini_set('max_execution_time', 200);
        $data['currencycode']   = $currency;
        $data['period']         = $period;
        $data['property']       = DB::table('property')
        ->where('id',$propertyid)->select('streetaddress')->first();
        $data['roll'] =DB::select('EXEC spReportRollSingleProperty ?,?,?', 
        array($currency,$period,$propertyid));
        $data['date'] = date('d-M-Y');
        $reportpdf =   PDF::loadView('report/property/print/rent-roll-single',$data);

        return $reportpdf->stream('roll.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }
}
public function viewtenant(){
    try {
        $arr['tenant']   = DB::table('alltenant')
        ->select('fullname','id','companyname','nationalid','companynumber',
        'cell','email','clienttypeid','typedescription','available','approval')
        ->get();
        return view('report/tenant/list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
public function viewlease(){
    try {
        $arr['lease']   = DB::table('alllease')
            ->select('fullname','companyname','id','clienttypeid','validfrom','available','expiry',
            'validto','propertydescription','rentalcurrency','rental','propertyid','approval')
            ->get();
        return view('report/lease/list')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
public function printlandlordstatus(){
    try {
        ini_set('max_execution_time', 200);
    
        $data['status']  =DB::select('EXEC spReportAllLandlordStatus');
        $data['date'] = date('d-M-Y');
         $reportpdf =   PDF::loadView('report/landlord/print/status',$data);

        return $reportpdf->stream('landlord status.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }
}
public function printpropertystatus(){
    try {
        ini_set('max_execution_time', 200);
        $data['status']  =DB::select('EXEC spReportAllPropertyStatus');
        $data['date'] = date('d-M-Y');
        $data['activeproperty']   = DB::table('allproperty')
        ->where('available','=' ,'Y')->get()->count();
        $data['allproperty']   = DB::table('allproperty')->get()->count();
         $reportpdf =   PDF::loadView('report/property/print/status',$data);
      return $reportpdf->stream('property status.pdf');
        // return view('report/property/print/status')
       // ->with($data); 
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }
}
public function printtenantstatus(){
    try {
        ini_set('max_execution_time', 200);
    
        $data['status']  =DB::select('EXEC spReportAllTenantStatus');
        $data['date'] = date('d-M-Y');
         $reportpdf =   PDF::loadView('report/tenant/print/status',$data);

        return $reportpdf->stream('tenant status.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }
}
public function printleasestatus(){
    try {
        ini_set('max_execution_time', 200);
        $data['status']   = DB::table('alllease')
        ->select('fullname','companyname','id','clienttypeid','validfrom','available','expiry',
        'validto','propertydescription','rentalcurrency','rental','propertyid','approval')
        ->get();
        $data['date'] = date('d-M-Y');
         $reportpdf =   PDF::loadView('report/lease/print/status',$data);

        return $reportpdf->stream('lease status.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load');
    }
}
public function viewleasestatement(){
    try {
        $arr['lease']   = DB::table('alllease')
        ->select('*')
        ->get();
        $arr['code']   = DB::table('currency')
        ->select('*')->get();
        return view('report/lease/statement')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewprop') 
        ->with('error', 'failed to load property rent roll');
    }
}
public function printleasestatement(Request $request){
    try {
        ini_set('max_execution_time', 200);
        $data['status']  =DB::select('EXEC spGetSingleLeaseTrax ?,?',
        array($request->PropertyAddress,$request->RollCurrency));
        $data['day10']  =collect(DB::select('EXEC spGetSingleLease10DayDue ?,?',
        array($request->PropertyAddress,$request->RollCurrency)))->first();
        $data['day30']  =collect(DB::select('EXEC spGetSingleLease30DayDue ?,?',
        array($request->PropertyAddress,$request->RollCurrency)))->first();
        $data['day60']  =collect(DB::select('EXEC spGetSingleLease60DayDue ?,?',
        array($request->PropertyAddress,$request->RollCurrency)))->first();
        $data['day90']  =collect(DB::select('EXEC spGetSingleLease90DayDue ?,?',
        array($request->PropertyAddress,$request->RollCurrency)))->first();
        $data['dayabove90']  =collect(DB::select('EXEC spGetSingleLease90DayAboveDue ?,?',
        array($request->PropertyAddress,$request->RollCurrency)))->first();
        $data['lease']   = DB::table('alllease')->where('id', $request->PropertyAddress)
        ->select('*')->first();

       $data['date'] = date('d-M-Y');
       $data['currencycode'] = $request->RollCurrency;
      // return view('report/lease/print/statement')->with($data);
        $reportpdf =   PDF::loadView('report/lease/print/statement',$data);

         return $reportpdf->stream('lease statement.pdf');
    } catch (\Throwable $th) {
        return  redirect()->route('report.viewlease') 
        ->with('error', 'failed to load property rent roll'.$th);
    }
}

public function generateInvoiceReport(Request $request)
{
    $from = $request->input('date_from');
    $to = $request->input('date_to');
    $format = $request->input('format');

    $invoices = collect([
        ['invoice_number' => 'INV001', 'client_name' => 'Acme Corp', 'amount' => 1200.50, 'created_at' => '2025-10-25'],
        ['invoice_number' => 'INV002', 'client_name' => 'Beta Ltd', 'amount' => 850.00, 'created_at' => '2025-10-26'],
        ['invoice_number' => 'INV003', 'client_name' => 'Gamma Inc', 'amount' => 430.75, 'created_at' => '2025-10-28'],
    ]);

    $user = Auth::user();

    if ($format === 'pdf') {
        return Pdf::loadView('propman.reporting.invoices.invoices-export', [
            'invoices' => $invoices,
            'from' => $from,
            'to' => $to,
            'user' => $user,
        ])->download('invoice-report.pdf');
    }

    if ($format === 'excel') {
        return Excel::download(new InvoiceExport($invoices, $from, $to), 'invoice-report.xlsx');
    }

    return back()->with('error', 'Invalid format selected.');
}

public function generateLandlordReport(Request $request)
{
    $from = $request->input('date_from');
    $to = $request->input('date_to');
    $format = $request->input('format');
    $landlordType = $request->input('landlord_type', 'all');

    $landlords = collect([
        (object)[
            'firstname' => 'Tawanda',
            'lastname' => 'Moyo',
            'companyname' => 'Moyo Estates',
            'companynumber' => 'REG2025-001',
            'cell' => '0771234567',
            'email' => 'tmoyo@moyoestates.co.zw',
            'tel' => '0244567879',
            'tin' => 'TIN-00123',
            'clienttypeid' => 'corporate',
            'property_count' => 3,
            'isactive' => 'Y',
        ],
        (object)[
            'firstname' => 'Rudo',
            'lastname' => 'Chikore',
            'nationalID' => '63-9876543X21',
            'cell' => '0779876543',
            'email' => 'rchikore@example.com',
            'tel' => '0244567890',
            'clienttypeid' => 'individual',
            'property_count' => 1,
            'isactive' => 'N',
        ],
    ]);

    if ($landlordType !== 'all') {
        $landlords = $landlords->filter(fn($l) => strtolower($l->clienttypeid) === strtolower($landlordType));
    }

    $user = Auth::user();

    if ($format === 'pdf') {
        return Pdf::loadView('propman.reporting.landlords.landlords-export', [
            'landlords' => $landlords,
            'from' => $from,
            'to' => $to,
            'user' => $user,
            'landlordType' => $landlordType,
        ])
        ->setPaper('a4', 'landscape')
        ->download('landlord-report.pdf');
    }

    if ($format === 'excel') {
        return Excel::download(new LandlordExport($landlords, $from, $to, $landlordType), 'landlord-report.xlsx');
    }

    return back()->with('error', 'Invalid format selected.');
}

}
    
