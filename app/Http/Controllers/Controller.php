<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
//current system date
    public function systemdate(){
        try {      
            $sysdate   = DB::table('sysdates')
            ->select('*')->where('OpenClose','=','O')
            ->latest('id')->first();
            if(is_null($sysdate)){
                return 'failed';
            }else{
                return $sysdate->systemdate;
            }
        } catch (QueryException $th) {
           return 'failed';
        }
       
    }
// take the transaction id for all transactions
    public function transationid(){
        try {
            $trxid = collect(DB::select('EXEC spTriggerGetTrxID'))->first();
            if(is_null($trxid)){
                return 'failed';
            }else{
                return $trxid->trxid;
            }
        } catch (QueryException $th) {
            return 'failed';
        }
    }
//find general ledger for accounts without subledgers
    public function getgeneralledger($ledger,$currencycode){
        try {
            $generalledger   = DB::table('mappedsubledgersaccounts')
            ->select('*')->where('staticdescription',$ledger)
            ->where('currencycode',$currencycode)
            ->latest('id')->first();
            if(is_null($generalledger)){
                return 'failed not found';
            }else{
                if(is_null($generalledger->code)){
                    return 'failed empty';
                }else{
                    return $generalledger->code;
                } 
            }
        } catch (QueryException $th) {
            return 'failed'.$th;
        }
    }
//find subledger of all products(property,landlord,lease)
public function getproductsubledger($productcolumn,$id,$currencycode){
    try {
        $subledgerledger   = DB::table('mappedsubledgersaccounts')
        ->select('*')->where($productcolumn,$id)
        ->where('currencycode',$currencycode)
        ->latest('id')->first();
        if(is_null($subledgerledger)){
            return 'failed';
        }else{
            if(is_null($subledgerledger->accountcode)){
                return 'failed';
            }else{
                return $subledgerledger->accountcode;
            } 
        }
    } catch (QueryException $th) {
        return 'failed';
    }
}
//find rental subledger corresponding to a lease
public function getrentalsubledger($leaseid,$currencycode){
    try {
        $rentalsubledger = DB::table('mappedsubledgersaccounts')
        ->whereIn('propertyid',DB::table('alllease')->where('id',$leaseid)
        ->select('propertyid'))
        ->where('currencycode',$currencycode)
        ->select('*')->latest('id')->first();
        if(is_null($rentalsubledger)){
            return 'failed';
        }else{
            if(is_null($rentalsubledger->accountcode)){
                return 'failed';
            }else{
                return $rentalsubledger->accountcode;
            } 
        }
    } catch (QueryException $th) {
        return 'failed';
    }
}
//find latest exchange rate for currency
public function getexchangerate($currencycode){
    try {
        $exchangerate   = DB::table('currencyrate')
            ->select('*')->where('currencycode',$currencycode)
            ->latest('id')->first();
        if(is_null($exchangerate)){
            return 'failed';
        }else{
            if(is_null($exchangerate->meanrate)){
                return 'failed';
            }else{
                return $exchangerate->meanrate;
            } 
        }
    } catch (QueryException $th) {
        return 'failed';
    }
}
//find active base currency
public function getbasecurrency(){
    try {      
        $basecurrency   = DB::table('currencybase')
        ->select('*')->where('active','=','Y')
        ->latest('id')->first();
        if(is_null($basecurrency)){
            return 'failed';
        }else{
            return $basecurrency->code;
        }
    } catch (QueryException $th) {
       return 'failed';
    }
}

public function getgraceperiod($currencycode){
    try {
    $grace   = DB::table('arrearsconfig')
            ->select('*')->where('currencycode',$currencycode)
            ->latest('id')->first();
        if(is_null($grace)){ return 'failed'; }
        else{ return $grace;}
    } catch (QueryException $th) {
        return 'failed';
    }
}
public function getlicensecheck(){
    try {
        $licensecheck = DB::table('systmetacheck')
        ->select('*')->latest('id')->first();
        if(is_null($licensecheck)){
            return 'failed';
        }else{
            try {
                $license = Crypt::decrypt($licensecheck->checktil);
                $systemdate = $this->systemdate();
                $firstcheck = \Carbon\Carbon::parse($systemdate);
                $secondcheck = \Carbon\Carbon::parse($license);
                if($secondcheck >$firstcheck ){ return 'valid';}else{return 'notvalid';}
            } catch (DecryptException $th) {
               return 'failed';
            }
        }
    } catch (\Throwable $th) {
        return 'failed';
    }
}
public function userforcelogout($error){
    if(session()->has('alluser')){
        try {
            $logouttime = date("Y-m-d H:i:s", strtotime('+2 hours', strtotime(now())));
           $lastlogin = DB::table('systlogins')->where('username',session('alluser'))
            ->orderBy('id','desc')->first();
            DB::table('systlogins')->where('id',$lastlogin->id)
           ->update(['logoutdate' => $logouttime]);
            session()->pull('alluser');
            return  redirect()->route('login.signin') 
                ->with('error', $error);
        } catch (\Throwable $th) {
            session()->pull('alluser');
            return  redirect()->route('login.signin') 
                ->with('error', $error);
        }
    }
}
}
