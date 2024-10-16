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
            DB::table('propmanlandlord')
            ->where('id',$landlordid)
            ->update(['approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->reasons_comments]);
            return  redirect()->route('propapp.listland') 
            ->with('success', 'record declined');
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
        $arr['landlord']   = DB::table('propmanalllandlord')
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
                $clienttype = $this->getclienttype();
                $arr['type'] = $clienttype;
                $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select(columns: '*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->latest('id')->first();
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
                if (DB::table('propmanproperty')->select('id')->where('landlordid',
                 $landlordid)->where('available','=','Y')->exists()) {
                    return  redirect()->route('propdec.listlanddec')
                    ->with('error', 'active properties still attached');
                }
                DB::table('propmanlandlord')
                ->where('id',$landlordid)
                ->update(['approval' => 'D' , 'available'=> 'N','approvedby'=>session('alluser'),
            'approvedon'=>now()]);
                return  redirect()->route('propdec.listlanddec') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listlanddec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listlanddec')
            ->with('error', 'failed to load');
        }
}
public function updatesinglelandlord($id, Request $request,$contactid){
    try{
        $landlordid = Crypt::decrypt($id);
        $contactpersonid = Crypt::decrypt($contactid);
        // $existingclienttype = DB::table('propmanalllandlord')->where('id',$landlordid)
        // ->select('clienttypeid')->first();
        // if($existingclienttype->clienttypeid <> $request->clienttype){
        //     switch($request->clienttype){
        //         case 1: 
        //             $companyname = null;        $tinnumber = null;
        //             $companynumber = null;      $vatnumber = null;
        //             $firstname = $request->firstname; $lastname = $request->lastname;
        //             $nationalid = $request->nationalid;
        //         default:
        //         $firstname = null;          $lastname = null;
        //         $nationalid = null;
        //         $companyname = $request->companyname; $tinnumber = $request->tinnumber;
        //         $companynumber = $request->companynumber; $vatnumber = $request->vatnumber; }
        // }
        // $companyname = $request->companyname; $tinnumber = $request->tinnumber;
        // $companynumber = $request->companynumber; $vatnumber = $request->vatnumber;
        // $firstname = $request->firstname; $lastname = $request->lastname;
        // $nationalid = $request->nationalid;
            try {
                DB::table('propmanlandlord')
                ->where('id',$landlordid)
                ->update(['nationalid'=>$request->nationalid,
        'clienttypeid'=>$request->clienttype,'firstname'=>$request->firstname,'cell'=>$request->cell,
                        'email'=>$request->email,'tel'=>$request->tel,'approval'=>'N',
                        'lastname'=>$request->lastname, 'contactaddress'=>$request->billingaddress,
        'companynumber'=>$request->companynumber,'tinnumber'=>$request->tinumber,
                        'vatnumber'=>$request->vatnumber,'companyname'=>$request->companyname]);
            DB::table('propmanlandlordcontact')->where('id',$contactpersonid)
            ->update( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname]);
                return  redirect()->route('propdec.listlanddec') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewland',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.editviewland',$id)
            ->with('error', 'failed to load');
        }
}
public function disablelandlordcontact($id,$cid){
    try{
        $contactid = Crypt::decrypt($cid);
        try {
            if (DB::table('propmanlease')->select('id')->where('landlordcontactid',
             $contactid)->where('available','=','Y')->exists()) {
                return  redirect()->route('propma.editland',$id)
                    ->with('error', 'active property');
            }
            DB::table('propmanlandlordcontact')
                ->where('id',$contactid)->update(['available'=>'N']);
                return  redirect()->route('propma.editland',$id) 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propma.editland',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
}
public function disablelandlord($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            if (DB::table(table: 'propmanlandlordcontact')->select('id')->where('landlordid',
             $landlordid)->where('available','=','Y')->exists()) {
                return  redirect()->route('propma.landlist')
                    ->with('error', 'active contact persons');
            }
            DB::table('propmanlandlord')
                ->where('id',$landlordid)->update(['available'=>'N']);
                return  redirect()->route('propma.landlist') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propma.landlist')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.landlist')
            ->with('error', 'failed to load');
        }    
}
/*---------------end approval new landlord-----------------*/
/*---------------decline new lease-----------------*/
public function declinenewlease($id,Request $request){
    try{
        $leaseid = Crypt::decrypt($id);
            try {
                DB::table('propmanlease')
                ->where('id',$leaseid)
                ->update(['approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->reasons_comments]);
                return  redirect()->route('propapp.listlea') 
                ->with('success', 'record declined');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewlease',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propapp.viewlease',$id)
            ->with('error', 'failed to load');
        }
}
/*---------------end decline new lease-----------------*/
/*------------property----------------------------*/
public function disableproperty($id){
    try{
        $propertyid = Crypt::decrypt($id);
        try {
            if (DB::table('propmanlease')->select('id')->where('propertyid',
             $propertyid)->where('available','=','Y')->exists()) {
                return  redirect()->route('propma.landproplist')
                    ->with('error', 'active lease');
            }
            DB::table('propmanproperty')
                ->where('id',$propertyid)->update(['available'=>'N']);
                return  redirect()->route('propma.landproplist') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propma.landproplist')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.landproplist')
            ->with('error', 'failed to load');
        }
}
/*------------end property------------------------*/
/*------------tenant------------------------*/
public function disabletenant($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            if (DB::table('propmanlease')->select('id')->where('tenantid',
             $tenantid)->where('available','=','Y')->exists()) {
                return  redirect()->route('propma.tenalist')
                    ->with('error', 'active lease');
            }
            DB::table('propmantenant')
                ->where('id',$tenantid)->update(['available'=>'N']);
                return  redirect()->route('propma.tenalist') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propma.tenalist')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.tenalist')
            ->with('error', 'failed to load');
        }
}
public function disabletenantcontact($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            DB::table('propmantenantcontact')
                ->where('tenantid',$tenantid)->update(['available'=>'N']);
                return  redirect()->route('propma.viewtena',$id) 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propma.viewtena',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.viewtena',$id)
            ->with('error', 'failed to load');
        }
}
/*------------end tenant------------------------*/
}
