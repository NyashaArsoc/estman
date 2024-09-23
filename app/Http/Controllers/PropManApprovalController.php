<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PropManApprovalController extends Controller
{
    /*---------------approval new landlord-----------------*/
public function listlandlordapproval(){
    try {
        $arr['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-landlord-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    }
}
public function viewlandlordapproval($id){
    try {
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)->select(columns: '*')->first();  
            $arr['contact']   = DB::table('landlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->latest('id')->first();
            $arr['bank']   = DB::table('landlordbank')->where('landlordid', $landlordid)
            ->select('*')->get();
            return view('propman.approval.view-single-landlord-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listland')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listland')
        ->with('error', 'failed to load');
    }
}
public function approvenewsinglelandlordapproval($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update(['approval' => 'Y' , 'available'=> 'Y']);
            return  redirect()->route('propapp.listland') 
            ->with('success', 'approved');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.viewland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propapp.viewland',$id)
        ->with('error', 'failed to load');
    }
}
/*---------------end approval new landlord-----------------*/
}
