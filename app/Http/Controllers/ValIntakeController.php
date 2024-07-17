<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValIntakeController extends Controller
{
public function addclientdetails(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.add-client-details')->with($arr);
}
public function addpropertydetails(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.add-new-property')->with($arr);
}
public function createportfolio(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.create-new-portfolio')->with($arr);
}
public function addinstructionportfolio(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.new-instruction-portfolio-1')->with($arr);
}
public function addinstructionnormal(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.intake.new-instruction-normal-1')->with($arr);
}
public function listpropertyallocatesteptwo($id,$valuerid,$portfolioid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.intake.new-instruction-step-2')->with($arr);
}
}
