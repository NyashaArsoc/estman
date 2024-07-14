<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
        public function __construct(){
                $this->middleware(['loginauth']);
            }
public function propertyview(){
    $systemdate     = $this->systemdate();
    $leasedue = Carbon::parse($systemdate)->addDays(35);
    $arr['sysdates'] = $this->systemdate();
    $arr['lease']   = DB::table('alllease')
            ->where('available','=' ,'Y')->where('validto','>',$systemdate)
            ->where('validto','<',$leasedue)
            ->select('fullname','companyname','id','clienttypeid','validfrom','available',
            'validto','propertydescription')
            ->get();
    $arr['base']   = DB::table('currencybase')->where('active','=','Y')
            ->select('code')->latest('id')->first();
    $arr['activelease']   = DB::table('alllease')->where('available','=' ,'Y')->get()->count();
    $arr['activetenant']   = DB::table('alltenant')->where('available','=' ,'Y')->get()->count();
    $arr['activeproperty']   = DB::table('allproperty')->where('available','=' ,'Y')->get()->count();
   return view('dash/property-view')->with($arr);
}
public function maindashboard(){
    try {
        $arr['user'] = DB::table('systusers')->select('*')->where('username',session('alluser'))
        ->first();
        return view('dash/main-dash')->with($arr);
    } catch (\Throwable $th) {
        $error = 'failed to display dashboard';
        return $this->userforcelogout($error);
    }
       
}
public function valuationdashboard(){
    return view('dash/val-dash');
}
}
