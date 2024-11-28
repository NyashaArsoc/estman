<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
public function propertyview(){
    $basecurrency = $this->getbasecurrency();
     // check if basecurrency is set
     switch(true){
        case($basecurrency == 'failed'):
            $error = 'no base currency set';
            return  redirect()->route('dash.main')
            ->with('error', $error);
        default:
        $arr['sysdates'] = $this->systemdate();
        $arr['base']   = DB::table('setupcurrencybase')->where('active','=','Y')
        ->select('code')->latest('id')->first();
        $arr['activelandlord']   = DB::table('propmanlandlord')->where('available','=' ,'Y')->get()->count();
        $arr['activeproperty']   = DB::table('propmanallproperty')->where('available','=' ,'Y')->get()->count();
        $arr['activetenant']   = DB::table('propmanalltenant')->where('available','=' ,'Y')->get()->count();
        $arr['activelease']   = DB::table('propmanalllease')->where('available','=' ,'Y')->get()->count();
        $leasedue = Carbon::parse($arr['sysdates'])->addDays(35);
        $arr['lease']   = DB::table('propmanalllease')->where('available','=' ,'Y')
        ->where('validto','>',$arr['sysdates'])->where('validto',
        '<',$leasedue) ->select('*')->take(5)->get();
        $arr['invoice']   = DB::table('propmaninvoicepre')->get()->count();
    return view('dash/property-view')->with($arr);
        }
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
    $currentdate    = Carbon::now();
    $previousdate   = $currentdate->subDays(10);
    $arr['invoice']   = DB::table('valinstrinvoicing')->where('status','=' ,'P')->get()->count();
    $arr['approve']   = DB::table('valinstrfinalapproval')->where('status','=' ,'P')->get()->count();
    $arr['print']   = DB::table('valinstrprinting')->where('status','=' ,'P')->get()->count();
    $arr['quality']   = DB::table('valinstrqualitycheck')->where('status','=' ,'P')->get()->count();
    $arr['pending']   = DB::table('valinstructions')->where('status','=' ,'pending')->get()->count();
    $arr['mail']        = DB::table('valinstrsendingreport')->where('status','=' ,'pending')->get()->count();
    $arr['portfolio']   = DB::select('EXEC spValGetPortfolioCompilation');
    $arr['portfolioreview']   = DB::select('EXEC spValGetPortfolioReview');
    $arr['instructions'] = DB::table('valinstrfinalapproval')
    ->join('valinstructions', 'valinstrfinalapproval.instructionid', '=', 'valinstructions.id')
    ->join('valclientproperty', 'valclientproperty.id', '=', 'valinstructions.propertyid')
    ->where('valinstrfinalapproval.status', 'C')
    ->where('valinstrfinalapproval.completedon', '>=', $previousdate)
    ->select(
        'valinstrfinalapproval.completedby',
        'valinstrfinalapproval.completedon',
        'valclientproperty.streetaddress'
    )
    ->orderBy('valinstrfinalapproval.id', 'desc')
    ->take(10)
    ->get();
    //return $arr['instructions'] ;
   return view('dash/val-dash')->with($arr);
}
public function setupdashboard(){
    return view('dash.setup-dash');
}
}
