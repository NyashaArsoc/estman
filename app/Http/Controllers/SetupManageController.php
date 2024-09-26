<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupManageController extends Controller
{
public function setbasecurrency(){
   $currencycode = $this->getcurrencycode();
   switch ($currencycode){
    case 'failed':
        return  redirect()->route('setin.addcurr') 
      ->with('error', 'failed to load');
      default:
        $arr['currency'] = $currencycode;
        return view('setup.manage.set-base-currency')->with($arr);
    }
}
public function addnewbasecurrency(Request $request){
    try {
        $codeexists = DB::table('setupcurrencybase')->where('active', '=',
         'Y')->select('code')->latest('id')->first();
         switch ($codeexists){
            case trim($codeexists->code)==$request->currencycode:
                return  redirect()->route('setman.addbasecurr') 
                ->with('error', 'currency already exists');
              default:
              DB::table('setupcurrencybase')->insert(['code'=>$request->currencycode]);
              return  redirect()->route('setman.addbasecurr') 
              ->with('success', 'record added');
            }
    } catch (\Throwable $th) {
        return  redirect()->route('setin.addcurr') 
        ->with('error', 'failed to load'.$th);
    }
}
}
