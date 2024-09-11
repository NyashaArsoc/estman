<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ValIntakeController extends Controller
{
public function __construct(){
    $this->middleware(['loginauth']);
}
public function addclientdetails(){
    try {
        $arr['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        return view('val.intake.add-client-details')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function addnewclientdetails(Request $request){
    try {
        if ($request->clienttype ==1){
            $contactemail       =   $request->email;
            $contactcell        =   $request->cell;
            $contactlastname    =   $request->lastname;
            $contactfirstname   =   $request->firstname;
        }else{
            $contactemail       =   $request->contactemail;
            $contactcell        =   $request->contactcell;
            $contactlastname    =   $request->contactlastname;
            $contactfirstname   =   $request->contactfirstname;
        }
        //check if client already exist
        if(DB::table('valclientdetail')->select('id')->where('email',$request->email)->exists()){
            return  redirect()->route('valin.addclient') 
            ->with('error', 'client already exists');
        }elseif(DB::table('valclientcontactperson')->select('id')->where('email',$request->contactemail)->exists()){
            return  redirect()->route('valin.addclient') 
            ->with('error', 'client already exists');
        }
        else{
        $clientid = DB::table('valclientdetail')
            ->insertGetId( ['email'=>$request->email,'operatorid'=>session('alluser'),
            'clienttypeid'=>$request->clienttype,'cell'=>$request->cell,
                 'firstname'=>$request->firstname,'tel'=>$request->tel,'companyname'=>$request->companyname,
                'lastname'=>$request->lastname, 'contactddress'=>$request->contactaddress]);
          DB::table('valclientcontactperson')
           ->insert(['email'=>$contactemail,'cell'=>$contactcell,
           'lastname'=>$contactlastname,'firstname'=>$contactfirstname,
            'clientid'=>$clientid]);
            return  redirect()->route('valin.addclient') 
        ->with('success', 'client added'); 
        }
    } catch (\Throwable $th) {
        return  redirect()->route('valin.addclient') 
        ->with('error', 'failed to load');
    }
}
/*get client by clienttype id*/
public function getsingleclient($id){
    $arr['client']   =DB::table('valclientdetail')->where('clienttypeid',$id)
          ->select('*')->get();
   return view('val.intake.get-all-clients')->with($arr);
}
public function getsingleclientcontact($id){
    $arr['client']   =DB::table('valclientcontactperson')->where('clientid',$id)
    ->where('isavailable','=','Y')  ->select('*')->get();
   return view('val.intake.get-all-client-contacts')->with($arr);
}
public function addpropertydetails(){
    try {
        $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
    $arr['proptype']   = DB::table('propertytype')
          ->select('id','description')->get();
    $arr['town']   = DB::table('vallocations')
          ->select('*')->get();
   return view('val.intake.add-new-property')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val') 
            ->with('error', 'failed to load');
    }
}
public function addnewpropertydetails(Request $request){
try {
    $numbersinarray         =       count($request->propertyaddress);
    $a = 0;
            while ($a   <   $numbersinarray){
                $propertytypeid = strstr($request->propertytype[$a], "-", true);
                $suburbid = strstr($request->propertysurbub[$a], "-", true);
                DB::table('valclientproperty')
                ->insert(['clientid'=>$request->propertyclientname,'propertytypeid'=>$propertytypeid,
                    'suburbid'=>$suburbid,'streetaddress'=>$request->propertyaddress[$a],
                'operatorid'=>session('alluser')]);
                $a++;
            }
        return  redirect()->route('valin.addprop') 
            ->with('success', 'properties added'); 

} catch (\Throwable $th) {
    return  redirect()->route('valin.addprop') 
        ->with('error', 'failed to load');
}
}
public function createportfolio(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    $arr['purpose']   = DB::table('valpurpose')
    ->select('id','description')->get();
    $arr['valtype']   = DB::table('valtype')
    ->select('id','description')->get();
    $arr['payment']   = DB::table('valpaymentagreement')
    ->select('id','description')->get();
   return view('val.intake.create-new-portfolio')->with($arr);
}
public function createnewportfolio(Request $request){
    try {  
        $invoicedatedue = Carbon::parse(now())->addMinutes(60);
       $id = DB::table('valinstrportfolio') ->insertGetId(['datedue'=>$request
        ->portfolioduedate,'totalproperties'=>$request->totalnumberpropertyportfolio,'operatorid'
        =>session('alluser'), 'purpose'=>$request->valuationpurpose,'type'=>$request->valuationtype,
        'paymentterms'=>$request->valuationpaymentagreement,
        'clientcontactid'=>$request->clientcontactname,'clientid'=>$request->propertyclientname]);

        DB::table('valinstrinvoicingportfolio') ->insert(['portfolioid'=>$id,'operatorid'=>
        session('alluser'),'datedue'=>$invoicedatedue]);
       
        return  redirect()->route('valin.crtportfoli') 
            ->with('success', 'portfolio created');
        
    } catch (\Throwable $th) {
        return  redirect()->route('valin.crtportfoli') 
                ->with('error', 'failed to load');
    }
}
public function addinstructionportfolio(){
    $arr['valuer'] = DB::select('EXEC spValGetValuers');
    $arr['port'] = DB::table('valinstrlistportfolio')->where('totalproperties', '>', DB::raw(
        'ISNULL(CAST(propertiescaptured AS INT),0)'))->select('*')->get();
            return view('val.intake.new-instruction-portfolio-1')->with($arr);
}
public function addinstructionportsubmit(Request $request){
    try{
    $id = Crypt::encrypt($request->portfolioname);
    $vid = Crypt::encrypt($request->valuername);
    return  redirect()->route('valin.portlstpropallo',[$id,$vid]);
 } catch (DecryptException $th) {
     return  redirect()->route('valin.addinstport') 
             ->with('error', 'failed to load');
 }
}
public function addinstructionportsteptwo($id,$vid){
    try{
        $portfolioid = Crypt::decrypt($id);
        $valuerid = Crypt::decrypt($vid);
        try {
        $arr['valuer']   = DB::table('systusers')->where('id',$valuerid)
            ->select('*')->first();        
        $arr['port']   = DB::table('valinstrlistportfolio')->where('id',$portfolioid)
        ->select('*')->first();
        $arr['property'] = DB::select('EXEC spValGetInstrPropertyToCapture ?',[$arr['port']->clientid]);
        return view('val.intake.new-instruction-port-step-2')->with($arr);
        
        } catch (\Throwable $th) {
            return  redirect()->route('valin.addinstport') 
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return  redirect()->route('valin.addinstport') 
                ->with('error', 'failed to load');
    }
}
public function addnewinstructionport(Request $request){
    try {  
        $port   = DB::table('valinstrlistportfolio')->where('id',$request->portfolio)
        ->select('*')->first();

        $selectedids = $request->input('selectedids');
        $NumbersInArray         =       count($selectedids);
        $a  = 0;
        $capturedproperties = $port->propertiescaptured + $NumbersInArray;
        $allproperties = $port->totalproperties -  $capturedproperties;
        if($allproperties >= 0){
            while ($a   <   $NumbersInArray){
                $id = DB::table('valinstructions') ->insertGetId(['allocatedto'=>$request
                ->allocateto,'propertyid'=>$selectedids[$a],'operatorid'=>session('alluser'), 
                'portfolioid'=>$request->portfolio,'isportfolio'=>'Y']);
    
                DB::table('valinstracknowledgement')
                ->insert(['instructionid'=>$id,'operatorid'=>session('alluser'),
                'allocatedto'=>$request->user,]);
                DB::table('valinstrportfolio')->where('id', $request->portfolio)
            ->update(['propertiescaptured'=>$capturedproperties]);
                $a++;
            }
            return  redirect()->route('valin.addinstport') 
                ->with('success', 'instruction created');
        }else{
            return  redirect()->route('valin.addinstport') 
            ->with('error', 'more properties than expected');
        }
    } catch (\Throwable $th) {
        return  redirect()->route('valin.addinstport') 
                ->with('error', 'failed to load');
    }
}
public function addinstructionnormal(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    $arr['purpose']   = DB::table('valpurpose')
    ->select('id','description')->get();
    $arr['valtype']   = DB::table('valtype')
    ->select('id','description')->get();
    $arr['payment']   = DB::table('valpaymentagreement')
    ->select('id','description')->get();
    $arr['valuer'] = DB::select('EXEC spValGetValuers');
return view('val.intake.new-instruction-normal-1')->with($arr);
}
public function addinstructionnormalsubmit(Request $request){
        try{
        $id = Crypt::encrypt($request->propertyclientname);
        $vid = Crypt::encrypt($request->valuername);
        $cid = Crypt::encrypt($request->clientcontactname);
        $pid = Crypt::encrypt($request->valuationpurpose);
        $tid = Crypt::encrypt($request->valuationtype);
        $payid = Crypt::encrypt($request->valuationpaymentagreement);
        $accessdate = Crypt::encrypt($request->accessdatetime);
        return  redirect()->route('valin.lstpropallo',[$id,$vid,$cid,$pid,$tid,$payid,$accessdate]);
     } catch (DecryptException $th) {
         return  redirect()->route('valin.addinstnom') 
                 ->with('error', 'failed to load');
     }
}
public function addinstructionnormalsteptwo($id,$vid,$cid,$pid,$tid,$payid,$accessdate){
    try{
        $clientid = Crypt::decrypt($id);
        $valuerid = Crypt::decrypt($vid);
        $contactid = Crypt::decrypt($cid);
        $purposeid = Crypt::decrypt($pid);
        $typeid = Crypt::decrypt($tid);
        $paymentid = Crypt::decrypt($payid);
        $accessdatetime = Crypt::decrypt($accessdate);
        try {
            $arr['valuer']   = DB::table('systusers')->where('id',$valuerid)
            ->select('*')->first();
        $arr['contact']   = DB::table('valclientcontactperson')->where('id',$contactid)
        ->select('*')->first();
        $arr['purpose']   = DB::table('valpurpose')->where('id',$purposeid)
        ->select('*')->first();
        $arr['valtype']   = DB::table('valtype')->where('id',$typeid)
        ->select('*')->first();
        $arr['payment']   = DB::table('valpaymentagreement')->where('id',$paymentid)
        ->select('*')->first();
        $arr['access'] = $accessdatetime;
            $arr['property'] = DB::select('EXEC spValGetInstrPropertyToCapture ?',[$clientid]);
        return view('val.intake.new-instruction-normal-step-2')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('valin.addinstnom') 
                ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return  redirect()->route('valin.addinstnom') 
                ->with('error', 'failed to load');
    }
}
public function addnewinstructionnormal(Request $request){
    try {  
        $selectedids = $request->input('selectedids');
        $NumbersInArray         =       count($selectedids);
        $accessdatetime = Carbon::parse($request->accessdatetime);
        $a  = 0;
        while ($a   <   $NumbersInArray){
            $id = DB::table('valinstructions') ->insertGetId(['allocatedto'=>$request
            ->allocateto,'propertyid'=>$selectedids[$a],'operatorid'=>session('alluser'), 
            'purpose'=>$request->purpose,'type'=>$request->valtype,'paymentterms'=>$request->payment,
            'contactid'=>$request->contact,'datedueaccessdate'=>$accessdatetime]);

            DB::table('valinstracknowledgement')
            ->insert(['instructionid'=>$id,'operatorid'=>session('alluser'),
            'allocatedto'=>$request->user,]);
            $a++;
        }
        return  redirect()->route('valin.addinstnom') 
            ->with('success', 'instruction created');
        
    } catch (\Throwable $th) {
        return  redirect()->route('valin.addinstnom') 
                ->with('error', 'failed to load'.$th);
    }
}
}
