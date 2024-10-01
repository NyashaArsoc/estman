<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropManApprovalController extends Controller
{
    /*---------------approval new landlord-----------------*/
public function listlandlordapproval(){
    try {
        $arr['landlord']   = DB::table('propmanalllandlord')
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
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select(columns: '*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->latest('id')->first();
            $arr['bank']   = DB::table('propmanlandlordbank')->where('landlordid', $landlordid)
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
            DB::table('propmanlandlord')
            ->where('id',$landlordid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
            DB::table('propmanlandlordcontact')
            ->where('landlordid',$landlordid)
            ->update(['approval' => 'Y' , 'available'=> 'Y','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
            return  redirect()->route('propapp.listland') 
            ->with('success', 'record approved');
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
/*---------------approval new property-----------------*/
public function listpropertyapproval(){
    try {
        $arr['property']   = DB::table('propmanallproperty')
        ->where('approval','=' ,'N')
        ->select('*')->get();
        return view('propman.approval.list-property-pending-approval')->with($arr);
    } catch (\Throwable $th) {
      return  redirect()->route('dash.property');
    }
}
public function viewpropertyapproval($id){
    try {
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['property']   = DB::table('propmanallproperty')
            ->where('id', $propertyid)->select('*')->first();  
            return view('propman.approval.view-single-property-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propapp.listprop')
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('propapp.listprop')
        ->with('error', 'failed to load');
    }
}
public function downloadmandatepdf($address) {
    try {
        $streetaddress = Crypt::decrypt($address);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("public/documents/prop/mandate/{$streetaddress}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/prop/mandate/{$streetaddress}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.property');
    }
}
public function downloadotherpdf($address) {
    try {
        $streetaddress = Crypt::decrypt($address);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("public/documents/prop/other/{$streetaddress}")) {
                return abort(404);
            }
            return response()->download(storage_path("public/documents/prop/other/{$streetaddress}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.property');
    }
}
/*---------------end approval new property-----------------*/
}
