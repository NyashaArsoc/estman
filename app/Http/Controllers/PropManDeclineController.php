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
/*---------------end approval new landlord-----------------*/
}
