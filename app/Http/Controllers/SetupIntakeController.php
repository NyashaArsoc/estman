<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetupIntakeController extends Controller
{
    /*---------------creating new currency-----------------*/
 public function addcurrency(){
    return view('setup.intake.add-currency');
 }
 public function addnewcurrency(Request $request){
   try {
      $currencycode = strtoupper($request->currencycode);
      if(DB::table('setupcurrency')->select('id')->where('code',
      $currencycode)->exists()){
         return  redirect()->route('setin.addcurr') 
         ->with('error', 'currency already exists');
      }
      DB::table('setupcurrency')->insert(['code'=>$currencycode]);
      return  redirect()->route('setin.addcurr') 
      ->with('success', 'record added');
   } catch (\Throwable $th) {
      return  redirect()->route('setin.addcurr') 
      ->with('error', 'failed to load');
   }
 }
 /*---------------end creating new currency-----------------*/
}
