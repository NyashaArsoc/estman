<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ValManageController extends Controller
{
public function __construct(){
   $this->middleware(['loginauth']);
}
public function listallclient(){
    try {
    $arr['client'] = DB::table('valclientdetail')
            ->join('clienttype', 'clienttype.id', '=', 'valclientdetail.clienttypeid')
            ->select('clienttype.description', 'valclientdetail.*')->get();
       return view('val.manage.list-client')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val') 
        ->with('error', 'failed to load');
    }
}
public function editsingleclient($id){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    return view('val.manage.edit-single-client')
    ->with($arr);
}
public function viewsingleclient($id){
try{
    $clientid = Crypt::decrypt($id); 
    try {
        $arr['client'] = DB::table('valclientdetail')->where('valclientdetail.id',$clientid)
                ->join('clienttype', 'clienttype.id', '=', 'valclientdetail.clienttypeid')
                ->select('clienttype.description', 'valclientdetail.*')->first();
        $arr['contact'] = DB::table('valclientcontactperson')->where('clientid',$clientid)
        ->select('*')->get();
           return view('val.manage.view-single-client')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('valman.listclient') 
            ->with('error', 'failed to load');
        }
} catch (DecryptException $th) {
    return  redirect()->route('valman.listclient') 
->with('error', 'failed to load');
}
}
}
