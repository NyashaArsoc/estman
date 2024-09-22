<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropManIntakeController extends Controller
{
    /*---------------creating new landlord-----------------*/
public function addlandlorddetails(){
    try {
        $arr['type']   = DB::table('clienttype')->select('id','description')->get();
        $arr['currency']   = DB::table('currency')->select('id','code')->get();
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
            if (DB::table('landlord')->select('id')->where('nationalID', $request->nationalid)->exists()) {
                return  redirect()->route('propin.addlandlord')
                ->with('error', 'client exists');
            }
        }elseif (!is_null($request->companynumber)){
            if (DB::table('landlord')->select('id')->where('companynumber', $request->companynumber)->exists()) {
                return  redirect()->route('propin.addlandlord')
                    ->with('error', 'client exists');
            }
        }
        $landlordid = DB::table('landlord')->insertGetId( ['nationalID'=>$request->nationalid,
        'clienttypeid'=>$request->clienttype,'firstname'=>$request->firstname,'cell'=>$request->cell,
                        'email'=>$request->email,'tel'=>$request->tel,'operatorid'=>session('alluser'),
                        'lastname'=>$request->lastname, 'contactaddress'=>$request->billingaddress,
    'companynumber'=>$request->companynumber,'bpnumber'=>$request->tinumber,
                        'vatnumber'=>$request->vatnumber,'companyname'=>$request->companyname]
        );
        DB::table('landlordcontact')->insert( ['email'=>$request->contactemail,'cell'=>$request->contactcell,
            'lastname'=>$request->contactlastname,'firstname'=>$request->contactfirstname,'landlordid'=>$landlordid]);
        while ($a   <   $arraytotal){
                DB::table('landlordbank')
                ->Insert(['accountnumber'=>$accountnumber[$a],'branch'=>$branch[$a],
                    'bankname'=>$bankname[$a],'accountname'=>$accountname[$a],'operatorid'=>session('alluser'),
                    'currencycode'=>$currencycode[$a],'landlordid'=>$landlordid,'available'=>'Y']);
                $a++;
            }
    return  redirect()->route('propin.addlandlord') 
            ->with('success', 'landlord added successfully');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addlandlord')
        ->with('error', 'failed to load');
    }
}
 /*---------------creating new landlord-----------------*/
}
