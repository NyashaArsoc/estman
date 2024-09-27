<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropManIntakeController extends Controller
{
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
            ->with('success', 'landlord added successfully');
    } catch (\Throwable $th) {
        return  redirect()->route('propin.addlandlord')
        ->with('error', 'failed to load');
    }
}
 /*---------------creating new landlord-----------------*/
}
