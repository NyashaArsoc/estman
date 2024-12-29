<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
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
public function gettenantbyid($id){
   
        try {
            $lease   = DB::table('propmanalllease')->where('id', $id)
            ->select('*')->first();
            $arr['tenant']   = DB::table('propmanalltenant')->where('id', $lease->tenantid)
        ->select('*')->first();
        $arr['balances']    = DB::select ('EXEC spGetPropManSingleLeaseCurrentAmountDue ?',
        [$id]);
            return view('propman.manage.get-single-tenant-leaseid')->with($arr);
        } catch (\Throwable $th) {
             return redirect()->route('dash.property')
             ->with('error', 'failed to load');
        }
}
/*------------end get by client type */
/*-----------------view landlord------ */
public function viewlandlorddetails($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->get();
            $arr['bank']   = DB::table('propmanlandlordbank')->where('landlordid', $landlordid)
            ->select('*')->get();
            $arr['property']   = DB::table('propmanallproperty')->where('landlordid', $landlordid)
            ->select('*')->get();
            return view('propman.manage.view-single-landlord-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.landlist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.landlist')
        ->with('error', 'failed to load');
    }
}
public function vieweditlandlorddetails($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('landlordid', $landlordid)
            ->select('*')->get();
            $arr['bank']   = DB::table('propmanlandlordbank')->where('landlordid', $landlordid)
            ->select('*')->get();
            $arr['property']   = DB::table('propmanallproperty')->where('landlordid', $landlordid)
            ->select('*')->get();
            $clienttype = $this->getclienttype();
            $arr['type'] = $clienttype;
            return view('propman.manage.edit-single-landlord-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.landlist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.landlist')
        ->with('error', 'failed to load');
    }
}
public function updatelandlorddetails($id, Request $request){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            DB::table('propmanlandlord')->where('id',$landlordid)
            ->update(['nationalid'=>$request->nationalid,'firstname'=>$request->firstname,'cell'=>$request->cell,
            'email'=>$request->email,'tel'=>$request->tel,'lastname'=>$request->lastname, 'contactaddress'=>
            $request->billingaddress,'companynumber'=>$request->companynumber,'tinnumber'=>$request->tinnumber,
            'vatnumber'=>$request->vatnumber,'companyname'=>$request->companyname]);
            return  redirect()->route('propma.landlist') 
                ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }
}
public function vieweditlandlordcontact($id,$cid){
    try{
        $landlordid = Crypt::decrypt($id);
        $contactid = Crypt::decrypt($cid);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            $arr['contact']   = DB::table('propmanlandlordcontact')
            ->where('id', $contactid)
            ->select('*')->first();
            return view('propman.manage.edit-single-landlord-contact')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }
}
public function updatelandlordcontact($id,$cid,Request $request){
    try{
        $contactid = Crypt::decrypt($cid);
        try {
            DB::table('propmanlandlordcontact')->where('id',$contactid)
            ->update( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname]);
            return  redirect()->route('propma.editland',$id) 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editlandcon',[$id,$cid])
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editlandcon',[$id,$cid])
        ->with('error', 'failed to load');
    }
}
public function vieweditlandlordbank($id,$bid){
    try{
        $landlordid = Crypt::decrypt($id);
        $bankid = Crypt::decrypt($bid);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            $arr['bank']   = DB::table('propmanlandlordbank')
            ->where('id', $bankid)
            ->select('*')->first();
            $currencycode = $this->getcurrencycode();
            $arr['currency'] = $currencycode; 
            return view('propman.manage.edit-single-landlord-bank')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }  
}
public function updatelandlordbank($id,$bid,Request $request){
    try{
        $bankid = Crypt::decrypt($bid);
        try {
            DB::table('propmanlandlordbank')->where('id',$bankid)
            ->update( ['currencycode'=>$request->currencycode,'accountname'=>$request->accountname,
            'accountnumber'=>$request->accountnumber,'branch'=>$request->branch,
        'bankname'=>$request->bankname]);
            return  redirect()->route('propma.editland',$id) 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editlandban',[$id,$bid])
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editlandban',[$id,$bid])
        ->with('error', 'failed to load');
    }
}
/*-----------------landlord------ */
/*----------------- property -----------------*/
public function listallproperty(){
    try {
        $arr['property']   = DB::table('propmanallproperty')->select('*')->get();
        return view('propman.manage.list-all-property')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function viewpropertydetails($id){
    try{
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['property']   = DB::table('propmanallproperty')
            ->where('id', $propertyid)->select('*')->first(); 
            $arr['lease']   = DB::table('propmanalllease')
            ->where('id', $propertyid)->select('*')->get();  
            return view('propman.manage.view-single-property-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.landlist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.landlist')
        ->with('error', 'failed to load');
    }
}
public function vieweditpropertydetails($id){
    try{
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['property']   = DB::table('propmanallproperty')
            ->where('id', $propertyid)->select('*')->first(); 
            $arr['province']   = DB::table('setupprovince')->select('*')->get();
            $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
            $currencycode = $this->getcurrencycode();
            $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
            $arr['currency'] = $currencycode; 
            return view('propman.manage.edit-single-property')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.landproplist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.landproplist')
        ->with('error', 'failed to load');
    }
}
public function updatepropertydetails($id, Request $request){
    try{
        $propertyid = Crypt::decrypt($id);
        try {
            DB::table('propmanproperty')->where('id',$propertyid)
            ->update( ['currencycode'=> $request->currencycode,'city' 
            =>ucfirst($request->city),'location' => ucfirst($request->locationsurburb),
             'streetaddress'=> $request->billingaddress,'standnumber'=> $request->standnumber, 
             'comments'=> $request->commentshighlights, 'rooms'=>  $request->rooms,'bedrooms'=> 
             $request->bedrooms, 'bathrooms'=> $request->bathrooms,'stories'=> $request->stories,
                'totalarea'=> $request->totalarea,'lettablearea'=> $request->lettablearea,'ratesqm'=>
                $request->expectedrate,'expectedrental'=> $request->expectedrental,'provinceid'=> 
                $request->province ]);
            DB::table('propmancommissionpercent')->where('propertyid',$propertyid)
                ->update(['percentage'=>$request->commissionpercentage]);
            return  redirect()->route('propma.landproplist') 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.landproplist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.landproplist')
        ->with('error', 'failed to load');
    } 
}
/*----------------------end property--------------------*/
/*-----------------------tenant--------------------------*/
public function listalltenants(){
    try {
        $arr['tenant']   = DB::table('propmanalltenant')->select('*')->get();
        return view('propman.manage.list-all-tenant')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function viewtenantdetails($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            $arr['contact']   = DB::table('propmantenantcontact')
            ->where('tenantid', $tenantid)->select('*')->get();
            $arr['keen']   = DB::table('propmantenantkeen')->where('tenantid', $tenantid)
            ->select('*')->get();
            $arr['lease']   = DB::table('propmanalllease')->where('tenantid', $tenantid)
            ->select('*')->get();
            return view('propman.manage.view-single-tenant-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.tenalist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.tenalist')
        ->with('error', 'failed to load');
    }
}
public function viewedittenantdetails($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            $arr['contact']   = DB::table('propmantenantcontact')
            ->where('tenantid', $tenantid)
            ->select('*')->get();
            $arr['keen']   = DB::table('propmantenantkeen')->where('tenantid', $tenantid)
            ->select('*')->get();
            return view('propman.manage.edit-single-tenant-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.tenalist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.tenalist')
        ->with('error', 'failed to load');
    } 
}
public function viewedittenantkeen($id,$cid){
    try{
        $tenantid = Crypt::decrypt($id);
        $keenid = Crypt::decrypt($cid);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            $arr['contact']   = DB::table('propmantenantkeen')
            ->where('id', $keenid)
            ->select('*')->first();
            return view('propman.manage.edit-single-tenant-keen')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }  
}
public function updatetenantkeen($id,$cid,Request $request){
    try{
        $contactid = Crypt::decrypt($cid);
        try {
            DB::table('propmantenantkeen')->where('id',$contactid)
            ->update( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname]);
            return  redirect()->route('propma.edittena',$id) 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittenkeen',[$id,$cid])
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittenkeen',[$id,$cid])
        ->with('error', 'failed to load');
    }
}
public function updatetenantdetails($id, Request $request){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            DB::table('propmantenant')->where('id',$tenantid)
            ->update(['nationalid'=>$request->nationalid,'firstname'=>$request->firstname,'cell'=>$request->cell,
            'email'=>$request->email,'tel'=>$request->tel,'lastname'=>$request->lastname, 'contactaddress'=>
            $request->billingaddress,'companynumber'=>$request->companynumber,'tinnumber'=>$request->tinnumber,
            'vatnumber'=>$request->vatnumber,'companyname'=>$request->companyname]);
            return  redirect()->route('propma.tenalist') 
                ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }
}
public function viewedittenantcontact($id,$cid){
    try{
        $tenantid = Crypt::decrypt($id);
        $contactid = Crypt::decrypt($cid);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            $arr['contact']   = DB::table('propmantenantcontact')
            ->where('id', $contactid)
            ->select('*')->first();
            return view('propman.manage.edit-single-tenant-contact')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }  
}
public function updatetenantcontact($id,$cid,Request $request){
    try{
        $contactid = Crypt::decrypt($cid);
        try {
            DB::table('propmantenantcontact')->where('id',$contactid)
            ->update( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname]);
            return  redirect()->route('propma.edittena',$id) 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittencon',[$id,$cid])
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittencon',[$id,$cid])
        ->with('error', 'failed to load');
    }
}
/*-----------------------end tenant----------------------*/
/*-----------------------lease----------------------*/
public function listallleases(){
    try {
        $arr['lease']   = DB::table('propmanalllease')->select('*')->get();
        return view('propman.manage.list-all-lease')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function viewleasedetails($id){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            $arr['lease']   = DB::table('propmanalllease')->where('id', $leaseid)
            ->select('*')->first();
            $arr['rates']   = DB::table('propmanleasecurrentbillrates')->where('leaseid',
             $leaseid)->select('*')->get();
            return view('propman.manage.view-single-lease-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.lealist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.lealist')
        ->with('error', 'failed to load');
    }
}
public function vieweditleasedetails($id){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            $arr['lease']   = DB::table('propmanalllease')->where('id', $leaseid)
            ->select('*')->first();
            $currencycode = $this->getcurrencycode();
            $arr['rates']   = DB::table('propmanleasecurrentbillrates')->where('leaseid',
             $leaseid)->select('*')->get();
             $arr['currency'] = $currencycode; 
            return view('propman.manage.edit-single-lease-detail')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.lealist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.lealist')
        ->with('error', 'failed to load');
    }
}
public function vieweditleaserate($rid,$id){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            $arr['lease']   = DB::table('propmanalllease')->where('id', $leaseid)
            ->select('*')->first();
            $arr['rates']   = DB::table('propmanleasecurrentbillrates')->where('leaseid',
             $leaseid)->select('*')->first();
             $currencycode = $this->getcurrencycode();
             $arr['currency'] = $currencycode;
            return view('propman.manage.edit-single-lease-rate')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.lealist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.lealist')
        ->with('error', 'failed to load');
    }
}
public function updateleasedetails($id,Request $request){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            $rental = ($request->propertytype ==1) ? $request->expectedrental
                        : $request->expectedrate * $request->areataken;

            DB::table('propmanlease')->where('id',$leaseid)
            ->update(['validfrom'=>$request->leasevalidfrom,'validto'=>$request->leasevalidto,
            'areataken'=>$request->areataken,'rental'=>$rental,'currencycode'=>$request->currencycode,
            'ratesqm'=>$request->expectedrate,'propertydescription'=>$request->propertydescription,
            'rentreview'=>$request->rentreviewperiod,'inspectionreview'=>$request->inspectionperiod]);
            return  redirect()->route('propma.lealist') 
                ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editlea',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editlea',$id)
        ->with('error', 'failed to load');
    }
}
public function updateleaserate($id,$rid,Request $request){
    try{
        $rateid = Crypt::decrypt($rid);
        try {
            DB::table('propmanleasecurrentbillrates')->where('id',$rateid)
            ->update( [
                'currencycode'=>$request->currencycode,
            'operationalcosts'=>$request->leaseoperationalcost, 'ratescosts'=>$request->leaseratescost]);
            return  redirect()->route('propma.editlea',$id) 
            ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editlearat',[$rid,$id])
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editlearat',[$rid,$id])
        ->with('error', 'failed to load');
    }
}
public function reactivatesinglelease($id){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            DB::table('propmanlease')->where('id',$leaseid)
            ->update(['approval'=> 'N']);
            return  redirect()->route('propma.lealist') 
                ->with('success', 'record updated for approval');
        } catch (\Throwable $th) {
            return redirect()->route('propma.lealist')
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.lealist')
        ->with('error', 'failed to load');
    }
}
public function viewrenewleasedetails($id){
    try{
        $leaseid = Crypt::decrypt($id);
            try {
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode; 
                $arr['lease']   = DB::table('propmanalllease')->where('id',
                 $leaseid)->select(columns: '*')->first();
                $arr['rates']   = DB::table('propmanleasecurrentbillrates')->where('leaseid',
                 $leaseid) ->select('*')->get();
                $arr['clienttype']   = DB::table('propmanalltenant')->where('id',
                 $arr['lease']->tenantid) ->select('*')->first();
                return view('propman.manage.view-single-lease-renewal')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.lealist')
                ->with('error', 'failed to load');
            }
        }catch (DecryptException $th) {
            return redirect()->route('propma.lealist')
            ->with('error', 'failed to load');
        }
}
public function updatesingleleaserenew($id,Request $request){
    try{
        $leaseid = Crypt::decrypt($id);
        try {
            $request->validate([
                'mandate' => 'leaseagreement',
            ]);
             //checking if the attachment is there 
         if ($request->hasFile('leaseagreement')) {
            $reportdoc = $request->file('leaseagreement');
            $reportdocname = $request->propertydescription . '.' . $reportdoc->getClientOriginalExtension();
            $reportdoc->storeAs('public/documents/prop/lease', $reportdocname);
        }
            $rental = (trim($request->propertytype) ==1) ? $request->expectedrental
                        : $request->expectedrate * $request->areataken;
            $lease   = DB::table('propmanlease')->where('id',
                        $leaseid)->select('*')->first();
           
        DB::table('propmanleaserenewal')->insert(['leaseid'=>$lease->id,'tenantid'=>
        $lease->tenantid,'propertyid'=>$lease->propertyid,'approvedby'=>$lease->approvedby,
        'dateapproved'=>$lease->dateapproved,'operatorid'=>$lease->operatorid,'validfrom'=>$lease
        ->validfrom,'validto'=>$lease->validto,'areataken'=>$lease->areataken,'rental'=>$lease
        ->rental,'currencycode'=>$lease->currencycode,'approval'=>$lease->approval,'available'=>$lease
        ->available,'expiry'=>$lease->expiry,'ratesqm'=>$lease->ratesqm,'reasons'=>$lease->reasons,
        'propertydescription'=>$lease->propertydescription,'landlordcontactid'=>$lease->landlordcontactid,
        'dateactioned'=>$lease->datestamp,'rentreview'=>$lease->rentreview,'inspectionreview'=>$lease
        ->inspectionreview,'agreement'=> $lease->agreement]);

            DB::table('propmanlease')->where('id',$leaseid)
            ->update(['validfrom'=>$request->leasevalidfrom,'validto'=>$request->leasevalidto,
            'areataken'=>$request->areataken,'rental'=>$rental,'currencycode'=>$request->currencycode,
            'ratesqm'=>$request->expectedrate,'propertydescription'=>$request->propertydescription,
            'rentreview'=>$request->rentreviewperiod,'inspectionreview'=>$request->inspectionperiod,
        'approval'=>'N','expiry'=>'N','agreement'=> $reportdocname,'datestamp'=>now()]);
            return  redirect()->route('propma.lealist') 
                ->with('success', 'record updated');
        } catch (\Throwable $th) {
            return redirect()->route('propma.renlea',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.renlea',$id)
        ->with('error', 'failed to load');
    }
}

/*-----------------------end lease----------------------*/
}
