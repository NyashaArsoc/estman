<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    // $validaddress = Validator::make($request->all(), [
    //     'propertyaddress' => 'required|min:5|max:255'
    // ]);
    // if ($validaddress->fails()) {
    //     return  redirect()->route('valin.addprop') 
    //     ->with('error', 'address is required');
    // }
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
        ->with('error', 'failed to load'.$th);
}
}
public function createportfolio(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.create-new-portfolio')->with($arr);
}
public function addinstructionportfolio(){
    $arr['type']   = DB::table('clienttype')
          ->select('id','description')->get();
   return view('val.intake.new-instruction-portfolio-1')->with($arr);
}
public function addinstructionnormal(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.intake.new-instruction-normal-1')->with($arr);
}
public function listpropertyallocatesteptwo($id,$valuerid,$portfolioid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.intake.new-instruction-step-2')->with($arr);
}
}
