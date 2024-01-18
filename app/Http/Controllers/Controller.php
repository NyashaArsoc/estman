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
}
