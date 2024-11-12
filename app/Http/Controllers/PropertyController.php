<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PropertyController extends BaseController
{
public function __construct(){
        $this->middleware(['loginauth']);
}


public function remitlist(){
    try {
        $arr['remit']   = DB::table('preremitlist')
        ->select('*')
        ->get();
        return view('property/remittance-list')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('property.rejected') 
            ->with('error', 'failed to load property list');
    }
}
public function compilepreremitlist(){
    try {
        $period = DB::table('checkperiodrun')
                ->where('isinvoicerun','=',1)
                ->where('isremitlistrun','=',0)
                ->select('*')->latest('id')->first();
        if(is_null($period)){
            return 'no pending period';
        }

        $arr= DB::select('EXEC spGetRemitList ?',[$period->period]);
        if(is_null($arr)){
            return 'problem in connection';
        }else{
            $result = $arr[0]->ReturnValue;
            if($result ==1){
                //success full run 
                return 'success';
            }else{
                //already run 
                return 'you can only run once';
            }
        }
    } catch (QueryException $th) {
        return 'failed to execute query';
    }
    
}
public function prepareremittance($id,$currency,$period){
    $propertyid = Crypt::decrypt($id);
    $currencycode = Crypt::decrypt($currency);
    $remitperiod = Crypt::decrypt($period);
    try {
        $arr['property']   = DB::table('allproperty')
            ->where('id', $propertyid)
            ->select('id','companyname','landlordclienttype' ,'fullname','streetaddress',
            'commissionpercentage','commissionon','landlordid')
            ->first();
        $arr['remit']=collect(DB::select('EXEC spGetSingleRemitList ?,?,?'
        ,array($remitperiod,$propertyid,$currencycode)))->first();
        $arr['bank'] = DB::table('landlordbank')->join ('currency',
        'landlordbank.currencyid','=','currency.id')
        ->where('landlordbank.landlordid',$arr['property']->landlordid)
        ->where('currency.code',$currencycode)
        ->select('*')->latest('landlordbank.id')->first();

        return view('property/remittance-prepare')
        ->with($arr);
        if(is_null($arr)){
            return  redirect()->route('property.rejected') 
            ->with('error', 'failed to load property list');
        }
    } catch (QueryException $th) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list'.$th);
    }
}
public function addpreremit(Request $request,$id,$currency){
    $propertyid = Crypt::decrypt($id);
    $currencycode = Crypt::decrypt($currency);
    try {
        $totaldeduction = $request->BillInterest + $request->BillCommission + 
    $request->BillRates + $request->BillOppC + $request->BillVAT + $request->SecurityCharge +
    $request->CaretakerCharge + $request->OtherExpensesCharge;
    $toremit = $request->BillCollections - $totaldeduction;
    if($toremit < 0){
        return  redirect()->route('property.remit') 
        ->with('error', 'remittance is negative'.$toremit);
    }
        // Update the remittance balances
    $update = array('deductsecurity' => $request->SecurityCharge, 'deductcaretaker'=> 
    $request->CaretakerCharge,'deductother'=>$request->OtherExpensesCharge,'deductcommission'=>
    $request->BillCommission,'totaldeduction'=>$totaldeduction);
    DB::table('preremitlist')
        ->where('propertyid',$propertyid)
        ->where('currencycode',$currencycode)
                    ->update($update);
    return  redirect()->route('property.remit') 
    ->with('success', 'remittance set');
    } catch (\Throwable $th) {
        return  redirect()->route('property.remit') 
        ->with('error', 'failed to set remittance');
    }
    
}

}
