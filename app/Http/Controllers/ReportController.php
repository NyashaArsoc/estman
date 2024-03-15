<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
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
    ->with('error', 'failed to load property rent roll'.$th);
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
}
    
