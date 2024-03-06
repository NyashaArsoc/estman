<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
public function viewlandlord(){
    return 'landlord report';
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
    return view('report/property/rent-roll')
    ->with($arr);
} catch (\Throwable $th) {
    return  redirect()->route('report.viewprop') 
    ->with('error', 'failed to load property rent roll'.$th);
}
}
}
