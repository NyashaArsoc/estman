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
                ->with('success', 'record updated');
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
public function declinenewproperty($id,Request $request){
    try{
        $propertyid = Crypt::decrypt($id);
            try {
                DB::table('propmanproperty')
                ->where('id',$propertyid)
                ->update(['approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->reasons_comments]);
                return  redirect()->route('propapp.listprop') 
                ->with('success', 'record declined');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewprop',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propapp.viewprop',$id)
            ->with('error', 'failed to load');
        } 
}
public function listdeclinedproperty(){
    try {
        $arr['property']   = DB::table('propmanallproperty')
        ->where('approval','=' ,'R')
        ->select('*')->get();
        return view('propman.declined.list-property-declined-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function vieweditsingleproperty($id){
    try{
        $propertyid = Crypt::decrypt($id);
            try {
                $clienttype = $this->getclienttype();
                $currencycode = $this->getcurrencycode();
                $arr['property']   = DB::table('propmanallproperty')
            ->where('id', $propertyid)->select('*')->first();  
            $arr['province']   = DB::table('setupprovince')->select('*')->get();
            $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
            $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
            $arr['currency'] = $currencycode; 
            $arr['type'] = $clienttype; 
                return view('propman.declined.view-single-property-edit')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listlanddec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listlanddec')
            ->with('error', 'failed to load');
        }
}
public function updatesingleproperty($id, Request $request){
    try{
        $propertyid = Crypt::decrypt($id);
            try {
                $request->validate([
                    'mandate' => 'required',
                ]);
                //checking if the attachment is there 
         if ($request->hasFile('mandate')) {
            $reportdoc = $request->file('mandate');
            $reportdocname = $request->billingaddress . '.' . $reportdoc->getClientOriginalExtension();
            $reportdoc->storeAs('public/documents/prop/mandate', $reportdocname);
        }
        //checking if the attachment is there 
        if ($request->hasFile('otherattachment')) {
            $otherattachment = $request->file('otherattachment');
            $otherattachmentname = $request->billingaddress. '.' . $otherattachment->getClientOriginalExtension();
            $otherattachment->storeAs('public/documents/prop/other', $otherattachmentname);
        }$otherattachmentname = null;

                DB::table('propmanproperty')
                ->where('id',$propertyid)
                ->update(['currencycode'=> $request->currencycode, 'landlordid'=> $request->landlordname,'operatorid'=>
            session('alluser'), 'propertytypeid'=> $request->propertytype, 'city' =>ucfirst($request->city),
            'location' => ucfirst($request->locationsurburb), 'streetaddress'=> $request->billingaddress,'standnumber'
            => $request->standnumber, 'comments'=> $request->commentshighlights, 'rooms'=>  $request->rooms,
            'bedrooms'=> $request->bedrooms, 'bathrooms'=> $request->bathrooms,'stories'=> $request->stories,
            'totalarea'=> $request->totalarea,'lettablearea'=> $request->lettablearea,'ratesqm'=>
            $request->expectedrate,'expectedrental'=> $request->expectedrental, 'mandate'=> $reportdocname,
            'otherattachement'=>$otherattachmentname,'approval'=>'N','provinceid'=> $request->province ]);

            DB::table('propmancommissionpercent')->where('propertyid',$propertyid)
            ->update( ['setupcommissionoptionid'=>$request->commissiontype, 
                'percentage'=>$request->commissionpercentage]);
                return  redirect()->route('propdec.listpropdec') 
                ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewprop',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.editviewprop',$id)
            ->with('error', 'failed to load');
        }
}
public function deletesingleproperty($id){
    try{
        $propertyid = Crypt::decrypt($id);
            try {
                if (DB::table('propmanalllease')->select('id')->where('propertyid',
                 $propertyid)->where('available','=','Y')->exists()) {
                    return  redirect()->route('propdec.listpropdec')
                    ->with('error', 'active leases still attached');
                }
                DB::table('propmanproperty')
                ->where('id',$propertyid)
                ->update(['approval' => 'D' , 'available'=> 'N','approvedby'=>session('alluser'),
            'dateapproved'=>now()]);
                return  redirect()->route('propdec.listpropdec') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listpropdec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listpropdec')
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
public function declinenewtenant($id,Request $request){
    try{
        $tenantid = Crypt::decrypt($id);
            try {
                DB::table('propmantenant')
                ->where('id',$tenantid)
                ->update(['approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->reasons_comments]);
                return  redirect()->route('propapp.listten') 
                ->with('success', 'record declined');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewten',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propapp.viewten',$id)
            ->with('error', 'failed to load');
        } 
}
public function listdeclinetenant(){
    try {
        $arr['tenant']   = DB::table('propmanalltenant')
        ->where('approval','=' ,'R')
        ->select('*')->get();
        return view('propman.declined.list-tenant-declined-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function vieweditsingletenant($id){
    try{
        $tenantid = Crypt::decrypt($id);
            try {
                $clienttype = $this->getclienttype();
                $arr['type'] = $clienttype;
                $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select(columns: '*')->first();  
            $arr['contact']   = DB::table('propmantenantcontact')
            ->where('tenantid', $tenantid)
            ->select('*')->latest('id')->first();
            $arr['keen']   = DB::table('propmantenantkeen')
            ->where('tenantid', $tenantid)
            ->select('*')->latest('id')->first();
                return view('propman.declined.view-single-tenant-edit')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listlanddec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listlanddec')
            ->with('error', 'failed to load');
        }
}
public function updatesingletenant($id, Request $request){
    try{
        $tenantid = Crypt::decrypt($id);
            try {
                if(!is_null($request->nationalid)){
                    /*----------values to update in table keen ---------*/
                    $tablearray = ['email'=>$request->keenemail,'lastname'=>$request->keenlastname,
                    'firstname'=>$request->keenfirstname,'operatorid'=>session('alluser'),
                    'cell'=>$request->keencell];
                    $tablename = 'propmantenantkeen';
                }elseif (!is_null($request->companynumber)){
                    $tablearray = ['email'=>$request->contactemail,'lastname'=>$request->contactlastname,
                    'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),'cell'
                    =>$request->contactcell];
                    $tablename = 'propmantenantcontact';
                }
           DB::table('propmantenant')->where('id',$tenantid)->
           update( ['nationalid'=>$request->nationalid,'clienttypeid'=>$request->clienttype,
           'firstname'=>$request->firstname,'cell'=>$request->cell,'email'=>$request->email,'approval'
           =>'N','tel'=>$request->tel,'operatorid'=>session('alluser'),'lastname'=>$request->lastname, 
           'contactaddress'=>$request->billingaddress,'companynumber'=>$request->companynumber,
           'tinnumber'=>$request->tinnumber,'vatnumber'=> $request->vatnumber,'companyname'=>
           $request->companyname]);
                //updating values
           DB::table($tablename)->where('tenantid',$tenantid)
           ->update($tablearray);
                return  redirect()->route('propdec.listtendec') 
                ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewten',$id)
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.editviewten',$id)
            ->with('error', 'failed to load');
        }
}
public function deletesingletenant($id){
    try{
        $tenantid = Crypt::decrypt($id);
            try {
                if (DB::table('propmanalllease')->select('id')->where('tenantid',
                 $tenantid)->where('available','=','Y')->exists()) {
                    return  redirect()->route('propdec.listtendec')
                    ->with('error', 'active leases still attached');
                }
                DB::table('propmantenant')
                ->where('id',$tenantid)
                ->update(['approval' => 'D' , 'available'=> 'N','approvedby'=>session('alluser'),
            'dateapproved'=>now()]);
                return  redirect()->route('propdec.listtendec') 
                ->with('success', 'record removed');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.listtendec')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propdec.listtendec')
            ->with('error', 'failed to load');
        }
}
/*------------end tenant------------------------*/
}
