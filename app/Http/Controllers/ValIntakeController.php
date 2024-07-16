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

}
