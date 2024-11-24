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
     /*---------------creating new client type-----------------*/
public function addclienttype(){
      return view('setup.intake.add-client-type');
}
public function addnewclienttype(Request $request){
     try {
        $textdescription = ucfirst($request->textdescription);
        if(DB::table('setupclienttype')->select('id')->where('description',
        $textdescription)->exists()){
           return  redirect()->route('setin.addcltyp') 
           ->with('error', 'record already exists');
        }
        DB::table('setupclienttype')->insert(['description'=>$textdescription]);
        return  redirect()->route('setin.addcltyp') 
        ->with('success', 'record added');
     } catch (\Throwable $th) {
        return  redirect()->route('setin.addcltyp') 
        ->with('error', 'failed to load');
     }
}
   /*---------------end creating new client type-----------------*/
     /*---------------creating new client type-----------------*/
public function addpropertytype(){
      return view('setup.intake.add-property-type');
}
public function addnewpropertytype(Request $request){
     try {
        $textdescription = ucfirst($request->textdescription);
        if(DB::table('setuppropertytype')->select('id')->where('description',
        $textdescription)->exists()){
           return  redirect()->route('setin.addpropty') 
           ->with('error', 'record already exists');
        }
        DB::table('setuppropertytype')->insert(['description'=>$textdescription]);
        return  redirect()->route('setin.addpropty') 
        ->with('success', 'record added');
     } catch (\Throwable $th) {
        return  redirect()->route('setin.addpropty') 
        ->with('error', 'failed to load');
     }
}
   /*---------------end creating new client type-----------------*/
     /*---------------creating new province-----------------*/
public function addprovince(){
      return view('setup.intake.add-province');
}
public function addnewprovince(Request $request){
     try {
        $textdescription = ucfirst($request->textdescription);
        if(DB::table('setupprovince')->select('id')->where('description',
        $textdescription)->exists()){
           return  redirect()->route('setin.addprov') 
           ->with('error', 'record already exists');
        }
        DB::table('setupprovince')->insert(['description'=>$textdescription]);
        return  redirect()->route('setin.addprov') 
        ->with('success', 'record added');
     } catch (\Throwable $th) {
        return  redirect()->route('setin.addprov') 
        ->with('error', 'failed to load');
     }
}
   /*---------------end creating new province-----------------*/
   /*---------------lease interest-----------------*/
public function addleaseinterest(){
   try {
      $leaseids = DB::table('setupleaseinterestrates')->pluck('leaseid');
      $arr['lease'] = DB::table('propmanalllease')->whereNotIn('id', $leaseids)
      ->where('available','=','Y')->select('*')->get();
      return view('setup.intake.add-lease-interest')->with($arr);
  } catch (\Throwable $th) {
      return  redirect()->route('dash.setup');
  }
}
public function addnewleaseinterest(Request $request){
   try {
       // Validate the request
       $request->validate([
         'daysrange' => 'required|integer',
         'combinedleases' => 'required|array' ]);
         // Insert data into setupleaseinterestrates
        foreach ($request->combinedleases as $abc) {
             DB::table('setupleaseinterestrates')->insert(['leaseid' => $abc,
             'rate' => $request->percentagerate,
             'days' => $request->daysrange,'operatorid'=> session('alluser'),]);
      } 
      return  redirect()->route('setin.addintrst') 
      ->with('success', 'record added');
  } catch (\Throwable $th) {
      return  redirect()->route('setin.addintrst')
      ->with('error', 'failed to load');
  }
}
   /*---------------end lease interest-----------------*/
   /*--------------- vat config-----------------*/
public function addvatconfig(){
   try {
      $proptypeids = DB::table('setupvatconfig')->pluck('propertytypeid');
      $arr['proptype'] = DB::table('setuppropertytype')->whereNotIn('id', $proptypeids)
      ->get();
      return view('setup.intake.add-vat-config')->with($arr);
  } catch (\Throwable $th) {
      return  redirect()->route('dash.setup');
  }
}
public function addnewvatconfig(Request $request){
   try {
       // Validate the request
       $request->validate([
         'combinedleases' => 'required|array' ]);
         // Insert data into setupleaseinterestrates
        foreach ($request->combinedleases as $abc) {
             DB::table('setupvatconfig')->insert(['propertytypeid' => $abc,
             'rate' => $request->percentagerate,'operatorid'=> session('alluser'),]);
      } 
      return  redirect()->route('setin.addvat') 
      ->with('success', 'record added');
  } catch (\Throwable $th) {
      return  redirect()->route('setin.addvat')
      ->with('error', 'failed to load');
  }
}
   /*---------------end vat config-----------------*/
}
