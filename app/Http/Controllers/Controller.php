<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
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
    public function transationid(){
        try {
            $trxid = DB::select('EXEC spTriggerGetTrxID');
            if(is_null($trxid)){
                return 'failed';
            }else{
                return $trxid;
            }
        } catch (QueryException $th) {
            return 'failed';
        }
    }

    public function getgeneralledger($ledger,$currencycode){
        try {
            $generalledger   = DB::table('mappedsubledgersaccounts')
            ->select('*')->where('staticdescription',$ledger)
            ->where('currencycode',$currencycode)
            ->latest('id')->first();
            if(is_null($generalledger)){
                return 'failed';
            }else{
                if(is_null($generalledger->ledgercode)){
                    return 'failed';
                }else{
                    return $generalledger->ledgercode;
                } 
            }
        } catch (QueryException $th) {
            return 'failed';
        }
    }
public function getsubledger($productcolumn,$id,$currencycode){
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
public function getrentalsubledger($leaseid,$currencycode){
    try {
        $rentalsubledger = DB::table('mappedsubledgersaccounts')
        ->whereIn('propertyid',DB::table('alllease')->where('id',$leaseid)
        ->select('propertyid'))
        ->where('currencycode',$currencycode)
        ->select('*')->first();
        if(is_null($rentalsubledger)){
            return 'failed empty';
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
}
