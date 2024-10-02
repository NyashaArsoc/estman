<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropManManageController extends Controller
{
public function listalllandlords(){
    try {
        $arr['landlord']   = DB::table('propmanalllandlord')
        ->select('*')->get();
       return view('propman.manage.list-all-landlord')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
/*------------get by client type */
public function getlandlordbytype($id){
    try {
        $arr['landlord']   = DB::table('propmanalllandlord') ->where([['clienttypeid', $id],
        ['available','=' ,'Y']])
        ->select('*')->get();
      return view('propman.manage.get-single-landlord-type')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
}
public function gettenantbytype($id){
    try {
        $arr['tenant']   = DB::table('propmanalltenant') ->where([['clienttypeid', $id],
        ['available','=' ,'Y']])
        ->select('*')->get();
      return view('propman.manage.get-single-tenant-type')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
}
public function getpropertybytype($id){
    try {
        $arr['property']   = DB::table('propmanallproperty')->where([['propertytypeid', $id],
        ['available','=' ,'Y'],['occupation','<>' ,'F']])
        ->select('*')->get();
      return view('propman.manage.get-single-property-type')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
}
public function getlandlordbyproperty ($id){
    try {
        $property   = DB::table('propmanallproperty') ->where('id', $id)
        ->select('*')->first();
        $arr['landlord']   = DB::table('propmanlandlordcontact')->where('landlordid',
         $property->landlordid)->where('available','=' ,'Y')
        ->select('*')->get();
      return view('propman.manage.get-single-landlord-contact')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
}
/*------------end get by client type */
}
