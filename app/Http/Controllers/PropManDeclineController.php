<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PropManDeclineController extends Controller
{
/*---------------decline new landlord-----------------*/
public function declinenewlandlord($id,Request $request){
    try{
    $landlordid = Crypt::decrypt($id);
        try {
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update(['approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->reasons_comments]);
            return  redirect()->route('propapp.listland') 
            ->with('success', 'declines');
        } catch (\Throwable $th) {
            return redirect()->route('propapp.viewland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
        return redirect()->route('propapp.viewland',$id)
        ->with('error', 'failed to load');
    }
}
public function listdeclinelandlord(){
    try {
        $arr['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,'R')
        ->select('*')->get();
        return view('propman.declined.list-landlord-declined-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function vieweditsinglelandlord($id){
    try{
        $landlordid = Crypt::decrypt($id);
            try {
                $arr['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)->select(columns: '*')->first();  
            $arr['contact']   = DB::table('landlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->latest('id')->first();
            $arr['type']   = DB::table('clienttype')->select('id','description')->get();
                return view('propman.declined.view-single-landlord-edit')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listlanddec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listlanddec')
            ->with('error', 'failed to load');
        }
}
public function deletesinglelandlord($id){
    try{
        $landlordid = Crypt::decrypt($id);
            try {
                if (DB::table('property')->select('id')->where('landlordid',
                 $landlordid)->where('available','=','Y')->exists()) {
                    return  redirect()->route('propdec.listlanddec')
                    ->with('error', 'active properties still attached');
                }
                DB::table('landlord')
                ->where('id',$landlordid)
                ->update(['approval' => 'D' , 'available'=> 'N']);
                return  redirect()->route('propapp.listland') 
                ->with('success', 'declines');
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
