<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
class PropManIntakeController extends Controller
{
    private $monthlyvalue;   private $quarterlyvalue; 
    private $halfyearlyvalue; private $yearlyvalue; 
public function __construct(){
    $todayvalue = date("Y-m-d H:i:s");
    $timeinseconds = strtotime($todayvalue);
    $addmonthlyvalue  = $timeinseconds + (3600*24)*30;
    $addquarterlyvalue = $timeinseconds + (3600*24)*90;
    $addhalfyearlyvalue = $timeinseconds + (3600*24)*180;
    $addyearlyvalue = $timeinseconds + (3600*24)*360;
    $this->monthlyvalue  = date("Y-m-d", $addmonthlyvalue);
    $this->quarterlyvalue  = date("Y-m-d", $addquarterlyvalue);
    $this->halfyearlyvalue  = date("Y-m-d", $addhalfyearlyvalue);
    $this->yearlyvalue  = date("Y-m-d", $addyearlyvalue);
}
    /*---------------creating new landlord-----------------*/
public function addlandlorddetails(){
    try {
        $currencycode = $this->getcurrencycode();
        $clienttype = $this->getclienttype();
        switch ($currencycode){
         case 'failed':
             return  redirect()->route('setin.property')->with('error', 'failed to load');
           default: $arr['currency'] = $currencycode; }

         switch ($clienttype){case 'failed':
                return  redirect()->route('setin.property')->with('error', 'failed to load');
              default: $arr['type'] = $clienttype; }
        return view('propman.intake.add-landlord')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function addnewlandlorddetails(Request $request){
    try {
        $accountnumber = (!empty($request->accountnumber)) ? $request->accountnumber : 0;
        $currencycode = (!empty($request->currencycode)) ? $request->currencycode : 0;
        $accountname = (!empty($request->accountname)) ? $request->accountname : 0;
        $bankname = (!empty($request->bankname)) ? $request->bankname : 0;
        $branch = (!empty($request->branch)) ? $request->branch : 0;
        $arraytotal         =       count($accountnumber);
        $a  = 0;
        if(!is_null($request->nationalid)){
            if (DB::table('propmanlandlord')->select('id')->where('nationalid', $request->nationalid)->exists()) {
                return  redirect()->route('propin.addlandlord')
                ->with('error', 'client exists');
            }
        }elseif (!is_null($request->companynumber)){
            if (DB::table('propmanlandlord')->select('id')->where('companynumber', $request->companynumber)->exists()) {
                return  redirect()->route('propin.addlandlord')
                    ->with('error', 'client exists');
            }
        }
        $landlordid = DB::table('propmanlandlord')->insertGetId( ['nationalid'=>$request->nationalid,
        'clienttypeid'=>$request->clienttype,'firstname'=>$request->firstname,'cell'=>$request->cell,
                        'email'=>$request->email,'tel'=>$request->tel,'operatorid'=>session('alluser'),
                        'lastname'=>$request->lastname, 'contactaddress'=>$request->billingaddress,
    'companynumber'=>$request->companynumber,'tinnumber'=>$request->tinumber,
                        'vatnumber'=>$request->vatnumber,'companyname'=>$request->companyname]
        );
        DB::table('propmanlandlordcontact')->insert( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),
            'landlordid'=>$landlordid]);
        while ($a   <   $arraytotal){
                DB::table('propmanlandlordbank')
                ->Insert(['accountnumber'=>$accountnumber[$a],'branch'=>$branch[$a],
                    'bankname'=>$bankname[$a],'accountname'=>$accountname[$a],'operatorid'=>session('alluser'),
                    'currencycode'=>$currencycode[$a],'landlordid'=>$landlordid]);
                $a++;
            }
    return  redirect()->route('propin.addlandlord') 
            ->with('success', 'record added');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addlandlord')
        ->with('error', 'failed to load');
    }
}
public function addlandlordcontact($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();  
            return view('propman.intake.add-single-landlord-contact')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }
}
public function addlandlordnewcontact(Request $request, $id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            DB::table('propmanlandlordcontact')->insert( ['email'=>$request->contactemail,
            'cell'=>$request->contactcell, 'lastname'=>$request->contactlastname,
            'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),
            'landlordid'=>$landlordid]);
            return  redirect()->route('propma.editland',$id) 
            ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }
}
public function addlandlordbank($id){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
            ->where('id', $landlordid)->select('*')->first();
            $currencycode = $this->getcurrencycode();
            $arr['currency'] = $currencycode;  
            return view('propman.intake.add-single-landlord-bank')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    }
}
public function addlandlordnewbank($id, Request $request){
    try{
        $landlordid = Crypt::decrypt($id);
        try {
            DB::table('propmanlandlordbank')->insert( ['operatorid'=>session('alluser'),
            'landlordid'=>$landlordid,'currencycode'=>$request->currencycode,'accountname'=>$request->accountname,
            'accountnumber'=>$request->accountnumber,'branch'=>$request->branch,
        'bankname'=>$request->bankname]);
            return  redirect()->route('propma.editland',$id) 
            ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('propma.editland',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.editland',$id)
        ->with('error', 'failed to load');
    } 
}
 /*---------------end creating new landlord-----------------*/
 /*---------------creating new property-----------------*/
 public function addpropertydetails(){
    try {
        $currencycode = $this->getcurrencycode();
        $clienttype = $this->getclienttype();
        $arr['province']   = DB::table('setupprovince')->select('*')->get();
        $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
        $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
        $arr['currency'] = $currencycode; 
        $arr['type'] = $clienttype; 
        return view('propman.intake.add-property')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
 }
 public function addnewpropertydetails(Request $request){
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
        
        $propertyid = DB::table('propmanproperty')
        ->insertGetId([
            'currencycode'=> $request->currencycode, 'landlordid'=> $request->landlordname,'operatorid'=>
            session('alluser'), 'propertytypeid'=> $request->propertytype, 'city' =>ucfirst($request->city),
            'location' => ucfirst($request->locationsurburb), 'streetaddress'=> $request->billingaddress,'standnumber'
            => $request->standnumber, 'comments'=> $request->commentshighlights, 'rooms'=>  $request->rooms,
            'bedrooms'=> $request->bedrooms, 'bathrooms'=> $request->bathrooms,'stories'=> $request->stories,
            'totalarea'=> $request->totalarea,'lettablearea'=> $request->lettablearea,'ratesqm'=>
            $request->expectedrate,'expectedrental'=> $request->expectedrental, 'mandate'=> $reportdocname,
            'otherattachement'=>$otherattachmentname,'provinceid'=> $request->province ]);
            DB::table('propmancommissionpercent')
            ->Insert(['propertyid'=>$propertyid,'setupcommissionoptionid'=>$request->commissiontype, 
                'percentage'=>$request->commissionpercentage]);
                return  redirect()->route('propin.addproperty') 
                ->with('success', 'record added');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addproperty')
        ->with('error', 'failed to load');
    }
 }
 /*---------------end creating new property-----------------*/
  /*---------------creating new tenant-----------------*/
public function addtenantdetails(){
    try {
        $clienttype = $this->getclienttype();
        $arr['type'] = $clienttype; 
        return view('propman.intake.add-tenant')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    } 
 }
 public function addnewtenantdetails(Request $request){
    try {
        if(!is_null($request->nationalid)){
            if (DB::table('propmantenant')->select('id')->where('nationalid', $request->nationalid)->exists()) {
                return  redirect()->route('propin.addtenant')
                ->with('error', 'record exists');
            }
            /*----------values to insert in table keen ---------*/
            $tablearray = ['email'=>$request->keenemail,'lastname'=>$request->keenlastname,
            'firstname'=>$request->keenfirstname,'operatorid'=>session('alluser'),
            'cell'=>$request->keencell];
            $tablename = 'propmantenantkeen';
        }elseif (!is_null($request->companynumber)){
            if (DB::table('propmantenant')->select('id')->where('companynumber', $request->companynumber)->exists()) {
                return  redirect()->route('propin.addtenant')
                    ->with('error', 'record exists');
            }
            $tablearray = ['email'=>$request->contactemail,'lastname'=>$request->contactlastname,
            'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),'cell'
            =>$request->contactcell];
            $tablename = 'propmantenantcontact';
        }
        //-------------------table insert tenant----------------
        $tenantid = DB::table('propmantenant')->insertGetId( ['nationalid'=>
        $request->nationalid,'clienttypeid'=>$request->clienttype,'firstname'=>$request->firstname,
        'cell'=>$request->cell,'email'=>$request->email,'tel'=>$request->tel,'operatorid'
        =>session('alluser'),'lastname'=>$request->lastname, 'contactaddress'=>$request->billingaddress,
        'companynumber'=>$request->companynumber,'tinnumber'=>$request->tinnumber,'vatnumber'=>
        $request->vatnumber,'companyname'=>$request->companyname] );
        $idarray  = ['tenantid'=>$tenantid]; //define the tenantId
        $combinedarray = array_merge($idarray, $tablearray);
        DB::table($tablename)->insert($combinedarray);

    return  redirect()->route('propin.addtenant') 
            ->with('success', 'record added');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addtenant')
        ->with('error', 'failed to load');
    }
 }
public function addtenantkeen($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            return view('propman.intake.add-single-tenant-keen')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }
}
public function addtenantnewkeen(Request $request, $id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            DB::table('propmantenantkeen')->insert( ['email'=>$request->contactemail,
            'cell'=>$request->contactcell, 'lastname'=>$request->contactlastname,
            'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),
            'tenantid'=>$tenantid]);
            return  redirect()->route('propma.edittena',$id) 
            ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }
}  
   /*---------------end creating new tenant-----------------*/
 /*---------------creating new lease-----------------*/
public function addleasedetails(){
    try {
        $currencycode = $this->getcurrencycode();
        $clienttype = $this->getclienttype();
        $arr['province']   = DB::table('setupprovince')->select('*')->get();
        $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
        $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
        $arr['currency'] = $currencycode; 
        $arr['type'] = $clienttype; 
        return view('propman.intake.add-lease')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
public function addnewleasedetails(Request $request){
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
        switch($request->rentreviewperiod){
            case 'monthly': $nextrentreview = $this->monthlyvalue;
            case 'quarterly': $nextrentreview = $this->quarterlyvalue;
            case 'halfyearly': $nextrentreview = $this->halfyearlyvalue;
            case 'yearly': $nextrentreview = $this->yearlyvalue;}

        switch($request->inspectionperiod){
            case 'monthly': $nextinspection = $this->monthlyvalue;
            case 'quarterly': $nextinspection = $this->quarterlyvalue;
            case 'halfyearly': $nextinspection = $this->halfyearlyvalue;
            case 'yearly': $nextinspection = $this->yearlyvalue; }
        
        $currencycode = (!empty($request->leaseitemcurrencycode)) ? $request->leaseitemcurrencycode : [0];
        $leasebalancebd = (!empty($request->leasebalancebd)) ? $request->leasebalancebd : [0];
        $leaseratescost = (!empty($request->leaseratescost)) ? $request->leaseratescost :[0];
        $leaseoperationalcost = (!empty($request->leaseoperationalcost)) ? $request->leaseoperationalcost : [0];
        $leasedepositpaid = (!empty($request->leasedepositpaid)) ? $request->leasedepositpaid : [0];
        $leaseadminpaid = (!empty($request->leaseadminpaid)) ? $request->leaseadminpaid : [0];
        $arraytotal         =       count($currencycode);
        //check on the availability of array first 
        $a  = 0;
        $rental = ($request->propertytype ==1) ? $request->expectedrental
         : $request->expectedrate * $request->areataken;

         $leaseid    = DB::table('propmanlease')->insertGetId(['tenantid'=>$request->tenantname,
         'propertyid'=>$request->propertyaddress,'operatorid'=>session('alluser'), 
         'validfrom'=>$request->leasevalidfrom,'validto'=>$request->leasevalidto,'areataken'=>
         $request->areataken,'rental'=>$rental,'currencycode'=>$request->currencycode,'ratesqm'=>
         $request->expectedrate,'propertydescription'=>$request->propertydescription,'landlordcontactid'
         =>$request->landlordname,'rentreview'=>$request->rentreviewperiod,'inspectionreview'=>
         $request->inspectionperiod,'agreement'=> $reportdocname]);
         
         DB::table('propmanleaseschedules')->insert(['leaseid'=>$leaseid,
         'nextinspection'=>$nextinspection,'nextrentreview'=>$nextrentreview]);
         while ($a   <   $arraytotal){
            if($leasebalancebd[$a] > 0){
                $tablearray = ['leaseid'=>$leaseid,'currencycode'=>$currencycode[$a],
            'leasebalancebd'=>$leasebalancebd[$a],'operatorid'=>session('alluser'),'baldays'=>10];
            $tablename = 'propmanleasearrearsdetails';
            }else{
            $tablearray = ['leaseid'=>$leaseid,'currencycode'=>$currencycode[$a],
            'balance'=>$leasebalancebd[$a] * -1];
            $tablename = 'propmanleaseprepayments';
            }
            if($currencycode[$a]<>0){
                DB::table($tablename)->insert($tablearray);
                DB::table('propmanleasecurrentbillrates')
                ->Insert(['deposit'=>$leasedepositpaid[$a],'ratescosts'=>$leaseratescost[$a],
                    'operationalcosts'=>$leaseoperationalcost[$a],'adminstrationfee'=>$leaseadminpaid[$a],
                    'currencycode'=>$currencycode[$a],'leaseid'=>$leaseid]);
            }
            $a++;
        }
        if($request->propertytype ==1){
            DB::table('propmanproperty')
            ->where('id',$request->propertyaddress)
            ->update(['occupation' => 'F']);
        }
        return  redirect()->route('propin.addlease') 
        ->with('success', 'record added');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addlease')
        ->with('error', 'failed to load'.$th);
    }
}
public function addtenantcontact($id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
            ->where('id', $tenantid)->select('*')->first();  
            return view('propman.intake.add-single-tenant-contact')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }
}
public function addtenantnewcontact(Request $request, $id){
    try{
        $tenantid = Crypt::decrypt($id);
        try {
            DB::table('propmantenantcontact')->insert( ['email'=>$request->contactemail,
            'cell'=>$request->contactcell, 'lastname'=>$request->contactlastname,
            'firstname'=>$request->contactfirstname,'operatorid'=>session('alluser'),
            'tenantid'=>$tenantid]);
            return  redirect()->route('propma.edittena',$id) 
            ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('propma.edittena',$id)
            ->with('error', 'failed to load');
        }
    }catch (DecryptException $th) {
    return redirect()->route('propma.edittena',$id)
        ->with('error', 'failed to load');
    }
}
  /*---------------end creating new lease-----------------*/
}
