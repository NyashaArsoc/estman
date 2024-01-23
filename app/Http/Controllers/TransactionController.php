<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function viewnewbalances(){
        try {
                $arr['balances'] = DB::select('EXEC spGetallunpostedleaserates');
                return  view('transact.new-lease-bal') 
                ->with($arr);

        } catch (QueryException $th) {
            return  redirect()->route('lease.list') 
            ->with('error', 'failed to load');
        }
      
    }

public function postnewleasebalances($id,$code,$name){
        /* required general ledgers 
                bank, deposits, administration,DebtorsGL */
        $productcolumn          =       'leaseid';
        $ledger_bank            =       'bank';
        $ledger_deposit         =       'deposits';
        $ledger_admin           =       'administration';
        $leaseid                =       Crypt::decrypt($id);
        $currencycode           =       Crypt::decrypt($code);
        $tenantname             =       Crypt::decrypt($name);
        $systemdate             =       $this->systemdate();
        $trxid                  =       $this->transationid();
        $basecurrency           =       $this->getbasecurrency();
         /*check if the base currency is the one running 
                    use exchange rate as 1*/
        if(trim($basecurrency)==trim($currencycode)){ $exchangerate =1;}
        else{ $exchangerate  =  $this->getexchangerate($currencycode);   }
        $rentalsubledger        =       $this->getrentalsubledger($leaseid,$currencycode);
        $productsubledger       =       $this->getproductsubledger($productcolumn,$leaseid,$currencycode);
        $bankcode               =       $this->getgeneralledger($ledger_bank,$currencycode);
        $depositcode            =       $this->getgeneralledger($ledger_deposit,$currencycode);
        $admincode              =       $this->getgeneralledger($ledger_admin,$currencycode);

       
        if($systemdate == 'failed'){//check if system is open & date is available
            return  redirect()->route('transact.newbal') 
            ->with('error', 'failed to load system date');
        }else{
            if($trxid == 'failed'){//check if trxID is available
                return  redirect()->route('transact.newbal') 
            ->with('error', 'failed to load transaction reference');
            }else{
                if($basecurrency =='failed'){ //check if base currency is set
                    return  redirect()->route('transact.newbal') 
                    ->with('error', 'base currency not set');
                }else{
                        if($exchangerate=='failed'){//check if exchange rate of currency is set
                            return  redirect()->route('transact.newbal') 
                            ->with('error', 'exchange rate not found');
                        }else{
                            if($rentalsubledger=='failed' || $productsubledger=='failed' || $bankcode=='failed'
                            || $depositcode=='failed' || $admincode=='failed'){
                                return  redirect()->route('transact.newbal') 
                            ->with('error', 'one/more ledgers not mapped correctly');
                            }else{ // correct ledgers
                                try {
                                    // get the rates/charges & balance to post
                                    $unposted = collect(DB::select('EXEC  spGetOneUnpostedLeaseRatesByCurrency ?,?',
                                    array($leaseid,$currencycode)))->first();

                                    //1. get the grace-period details.
                                    $graceperiod   = DB::table('arrearsconfig')
                                    ->select('*')->where('currencycode',$currencycode)
                                    ->latest('id')->first();
                                    if(is_null($graceperiod)){ //when grace period is not set
                                        return  redirect()->route('transact.newbal') 
                                        ->with('error', 'grace period not set');
                                    }else{ //when grace period is set
                                   //2. post transactions with Debit (TD) and Credit (TC) to the transaction table
                                    //post balance bd
                                    if($unposted->balancebd <> 0){
                                        $trxratedamt = $unposted->balancebd * $exchangerate;
                                        $trxdescription = 'Balance bd of '.$tenantname;
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$productsubledger
                                        ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->balancebd,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                        //transaction credit
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$rentalsubledger
                                        ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->balancebd,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                    }
                                    //post admin fees
                                    if($unposted->adminpaid <> 0){
                                        $trxratedamt = $unposted->adminpaid * $exchangerate;
                                        $trxdescription = 'Admin fees of '.$tenantname;
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
                                        ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->adminpaid,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                        //transaction credit
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxglaccount'=>$admincode
                                        ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->adminpaid,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                    }
                                    //post deposit paid
                                    if($unposted->deposit <> 0){
                                        $trxratedamt = $unposted->deposit * $exchangerate;
                                        $trxdescription = 'Deposit of '.$tenantname;
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
                                        ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->deposit,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                        //transaction credit
                                        DB::table('accounttransactions')
                                        ->insert(['trxreference'=>$trxid,'trxglaccount'=>$depositcode
                                        ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$unposted->deposit,
                                        'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
                                        'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
                                     }
                                    /*3. call a procedure to clear balances 
                                    post in lease arrears, post in prepayments post in lease billrates*/
                                    DB::select('EXEC spPostSingleLeaseBalAndBill
                                    ?,?,?,?,?',array($systemdate,$leaseid,$currencycode,
                                    $graceperiod->balancebdperiod,$unposted->balancebd));
                                        return  redirect()->route('transact.newbal') 
                                        ->with('success', 'lease rates posted');
                                    }
                                } catch (QueryException $th) {
                                    return  redirect()->route('transact.newbal') 
                                    ->with('error', 'failed to load');
                                }
                            }
                        }
                }
            }
        }//end system date */
    }
public function interestcalculation(){
 try { 
    
    $currencyavailable = DB::table('currency')->select('id','code')->get();
    if(is_null($currencyavailable)){
        return 'failed';
    }else{
        //call days in month run
        $monthday = collect(DB::select('EXEC  spGetDaysInThisMonth'))->first();
        foreach($currencyavailable as $abc){
            $graceperiod = $this->getgraceperiod($abc->code);
            if($graceperiod != 'failed'){
                $interestrate   = (((float)$graceperiod->intrestcharged /100)
                / (int)$monthday->DaysInMonth);
                // get calculated interests
                $interestcalculated = DB::select('EXEC spGetArrearsInterestCalculated ?,?,?',
                array($interestrate,$abc->code,$graceperiod->interestperiod));
                //run through results in a procedure
                foreach($interestcalculated as $abcd){
                    if ($graceperiod->applyintereston =='rental'){
                        //take rent bal bd only
                        $interest = $abcd->rentint ;
                    }else if ($graceperiod->applyintereston =='rental and rates'){
                        //take rent bal bd and rates
                        $interest = $abcd->rentratesint ;
                    }else if ($graceperiod->applyintereston =='rental and operation cost'){
                        //take rent bal bd and operation
                        $interest = $abcd->rentopeint;
                    }else{
                         //take rent bal bd and operation & rates
                         $interest = $abcd->allint;
                    }
                    $update = array('balinterest'=> $interest);
                    DB::table('leasearrearsdetails')
                    ->where('id',$abcd->id)
                    ->update($update);
                    return 'success';
                } 
            }
        }
    }

    //return $monthday->DaysInMonth;
 } catch (QueryException $th) {
    return 'query failed';
 }
}
}
