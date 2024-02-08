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
public function receipting(){
    try {
        $arr['lease']   = DB::table('alllease')
        ->where('expiry','=','N')->where('approval','=','Y')
        ->where('available','=','Y')
        ->select('*')
        ->get();
        $arr['currency']   = DB::table('currency')
        ->select('id','code')->get();
        return  view('transact/tenant-recepting')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('invoice.listeditedprofoma') 
        ->with('error', 'failed to load');
    }
    
}
/*
public function addreceipts(Request $request){
    try {/*
        $ledger_bank            =       'bank';
        $productcolumn          =       'leaseid';
        $bankcode               =       $this->getgeneralledger($ledger_bank,$request->ReceiptCurrency);
        $systemdate             =       $this->systemdate();
        $trxid                  =       $this->transationid();
        $basecurrency           =       $this->getbasecurrency();
        $productsubledger       =       $this->getproductsubledger($productcolumn,$request->PropertyAddressDesc,$request->ReceiptCurrency);
          */
          /*check if the base currency is the one running 
                    use exchange rate as 1*/
      /*  if(trim($basecurrency)==trim($request->ReceiptCurrency)){ $exchangerate =1;}
        else{ $exchangerate  =  $this->getexchangerate($request->ReceiptCurrency);   }
        */
      /*  DB::table('payments')
        ->insert(['receiptnumber'=>$trxid,'leaseid'=>$request->PropertyAddressDesc
        ,'currencycode'=>$request->ReceiptCurrency,'amountpaid'=>$request->ReceiptAmount,
        'receiptdate'=>$request->ReceiptDate,
            'receiptreference'=>$request->ReceiptReference,'systemdate'=>$systemdate]);
        //double entry 
        $trxratedamt = $request->ReceiptAmount * $exchangerate;
        $trxdescription = 'Receipt Number '.$trxid;
        DB::table('accounttransactions')
        ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
            ,'trxtype'=>'TD','trxcurrencycode'=>$request->ReceiptCurrency,
            'trxamount'=>$request->ReceiptAmount,'trxratedamount'=>$trxratedamt,
            'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
            'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$productsubledger
           ,'trxtype'=>'TC','trxcurrencycode'=>$request->ReceiptCurrency,'trxamount'=>$request->ReceiptAmount,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
           'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
        */
           /*reducing the tenant balance by 
               starting with interest ->rental->rates->operational->vat starting with the 
               Old one FIFO*/
        /*   
            return 'yes';

    } catch (QueryException $e) {
        return  redirect()->route('transact.payment') 
        ->with('error', 'failed to load');
    }
    
}*/

public function processreceipt(Request $request){
    try {
        $systemdate             =       $this->systemdate();
        $trxid                  =       $this->transationid();
        $basecurrency           =       $this->getbasecurrency();
        $ledger_bank            =       'bank';
        $productcolumn          =       'leaseid';
        $bankcode               =       $this->getgeneralledger($ledger_bank,$request->ReceiptCurrency);
        $productsubledger       =       $this->getproductsubledger($productcolumn,$request->PropertyAddressDesc,$request->ReceiptCurrency);
       /*check if the base currency is the one running 
                    use exchange rate as 1*/
        if(trim($basecurrency)==trim($request->ReceiptCurrency)){ $exchangerate =1;}
        else{ $exchangerate  =  $this->getexchangerate($request->ReceiptCurrency);   }

        // Retrieve the payment amount
        $remainingamount = $request->ReceiptAmount;
                
        // Retrieve the arrears data ordered by priority (expenses, levies, rates, rental)
        $arrears   = DB::table('leasearrearsdetails')
                ->where('leaseid',$request->PropertyAddressDesc)
                ->where('currencycode',$request->ReceiptCurrency)
                    ->select('*')->oldest('id')->get();
         // Retrieve the prepayment account
         $prepayment   = DB::table('leaseprepayments')
         ->where('leaseid',$request->PropertyAddressDesc)
         ->where('currencycode',$request->ReceiptCurrency)
             ->select('*')->latest('id')->first();
        // Iterate through the arrears data
        foreach ($arrears as $abc) {
    
            if ($remainingamount <= 0) {
                break; // No remaining amount, exit the loop
            }
            if ($remainingamount >= $abc->balinterest) {
                // Deduct from interest
                $remainingamount -= $abc->balinterest;
                $abc->balinterest = 0;
            } else {
                // Deduct partially from inerest
                $abc->balinterest -= $remainingamount;
                $remainingamount = 0;
            }
            if ($remainingamount >= $abc->balrent) {
                // Deduct from levies
                $remainingamount -= $abc->balrent;
                $abc->balrent = 0;
            } else {
                // Deduct partially from levies
                $abc->balrent -= $remainingamount;
                $remainingamount = 0;
            }
            if ($remainingamount >= $abc->balrates) {
                // Deduct from rates
                $remainingamount -= $abc->balrates;
                $abc->balrates = 0;
            } else {
                // Deduct partially from rates
                $abc->balrates -= $remainingamount;
                $remainingamount = 0;
            }
            if ($remainingamount >= $abc->baloperational) {
                // Deduct from opperational cost
                $remainingamount -= $abc->baloperational;
                $abc->baloperational = 0;
            } else {
                // Deduct partially from operational cost
                $abc->baloperational -= $remainingamount;
                $remainingamount = 0;
            }
            if ($remainingamount >= $abc->balvat) {
                // Deduct from vat
                $remainingamount -= $abc->balvat;
                $abc->balvat = 0;
            } else {
                // Deduct partially from vat
                $abc->balvat -= $remainingamount;
                $remainingamount = 0;
            }
          
            // Update the arrears record with the cleared balances
            $updatereceipt = array('balvat' => $abc->balvat, 'balinterest'=> $abc->balinterest,
                    'balrent'=>$abc->balrent,'balrates'=>$abc->balrates,'baloperational'=>$abc->baloperational);
            DB::table('leasearrearsdetails')
            ->where('leaseid',$request->PropertyAddressDesc)
            ->where('currencycode',$request->ReceiptCurrency)
                            ->update($updatereceipt);
            if(is_null($prepayment)){
                DB::table('leaseprepayments') 
                ->insert(['balance'=>$remainingamount,'currencycode'=>$request->ReceiptCurrency
            ,'leaseid'=>$request->PropertyAddressDesc]);
            }else{
                DB::table('leaseprepayments') 
                ->updateOrInsert(['id'=>$prepayment->id],
                ['balance'=>$prepayment->balance += $remainingamount]);
            }
            
        }
        //clean  arrears table balances
        DB::select('EXEC spCleanArrearsZeroBalances');
        //post into payments table 
        DB::table('payments')
        ->insert(['receiptnumber'=>$trxid,'leaseid'=>$request->PropertyAddressDesc
        ,'currencycode'=>$request->ReceiptCurrency,'amountpaid'=>$request->ReceiptAmount,
        'receiptdate'=>$request->ReceiptDate,
            'receiptreference'=>$request->ReceiptReference,'systemdate'=>$systemdate]);
          //completing double entry 
          $trxratedamt = $request->ReceiptAmount * $exchangerate;
          $trxdescription = 'Receipt Number '.$trxid;
          DB::table('accounttransactions')
          ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
              ,'trxtype'=>'TD','trxcurrencycode'=>$request->ReceiptCurrency,
              'trxamount'=>$request->ReceiptAmount,'trxratedamount'=>$trxratedamt,
              'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
              'trxsystemdate'=>$systemdate]);
             //transaction credit
             DB::table('accounttransactions')
             ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$productsubledger
             ,'trxtype'=>'TC','trxcurrencycode'=>$request->ReceiptCurrency,'trxamount'=>$request->ReceiptAmount,
             'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
             'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
        return redirect()->route('transact.payment') 
        ->with('success', 'balance updated');
    } catch (QueryException $th) {
        return  redirect()->route('transact.payment') 
            ->with('error', 'failed to load');
    }
}
public function viewremit(){
    try {
        $arr['remit']   = DB::table('preremitlist')
        ->whereNotNull('totaldeduction')
        ->select('*')
        ->get();
        return view('transact/remittance-schedule')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('property.rejected') 
            ->with('error', 'failed to load property list');
    }
}
public function addscheduleremit($id){
    $remitid = Crypt::decrypt($id);
    try {
        $arr['remit']   = DB::table('preremitlist')
        ->where('id', $remitid)
        ->select('*')->first();
        return view('transact/remittance-process')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
}
