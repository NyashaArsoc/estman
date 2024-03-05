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
        $arr['property']   = DB::table('allproperty')
            ->where('id', $arr['remit']->propertyid)
            ->select('id','companyname','landlordclienttype' ,'fullname','streetaddress',
            'commissionpercentage','commissionon','landlordid')
            ->first();
            $arr['bank'] = DB::table('landlordbank')->join ('currency',
            'landlordbank.currencyid','=','currency.id')
            ->where('landlordbank.landlordid',$arr['property']->landlordid)
            ->where('currency.code',$arr['remit']->currencycode)
            ->select('*')->latest('landlordbank.id')->first();
            $arr['remitbal']=collect(DB::select('EXEC spGetSingleRemitList ?,?,?'
        ,array($arr['remit']->period,$arr['remit']->propertyid,$arr['remit']->currencycode)))->first();
        return view('transact/remittance-process')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load property list');
    }
}
public function processremit(Request $request,$id,$pid,$currency,$lid){
    $remitid = Crypt::decrypt($id);
    $propertyid = Crypt::decrypt($pid);
    $currencycode = Crypt::decrypt($currency);
    $landlordid = Crypt::decrypt($lid);

    $systemdate             =       $this->systemdate();
    $trxid                  =       $this->transationid();
    $basecurrency           =       $this->getbasecurrency();
    $ledger_bank            =       'bank';
    $ledger_commission      =       'commission';
    $productcolumn          =       'landlordid';
    $bankcode               =       $this->getgeneralledger($ledger_bank,$currencycode);
    $productsubledger       =       $this->getproductsubledger($productcolumn,$landlordid,$currencycode);
    $comissioncode          =       $this->getgeneralledger($ledger_commission,$currencycode);
        /*check if the base currency is the one running 
                    use exchange rate as 1*/
        if(trim($basecurrency)==trim($currency)){ $exchangerate =1;}
        else{ $exchangerate  =  $this->getexchangerate($currency);   }
   
    try {
        if($request->amountprocessed <0 || $request->amountprocessed > $request->totalremittance){
            return  redirect()->route('transact.scheduleremit',$id) 
        ->with('error', 'total remittance is less/more');
        }
        // updating property deductions to be paid to suppliers 
        $remitbal   = DB::table('propertyremitdeductions')
        ->where('propertyid', $propertyid)->where('currency',$currencycode)
        ->select('*')->first();
        if(is_null($remitbal)){
            $remitbalvat =$request->BillVAT; $remitbalinterest =$request->BillInterest;
            $remitbalrates =$request->BillRates; $remitbaloperationalcost =$request->BillOppC;
            $remitbalcommission =$request->BillCommission; $remitbalsecurity =$request->SecurityCharge;
            $remitbalcaretaker =$request->CaretakerCharge; $remitbalotherexpenses =$request->OtherExpensesCharge;
        }else{
            $remitbalvat = $remitbal->vat += $request->BillVAT; 
            $remitbalinterest =$remitbal->interest +=$request->BillInterest;
            $remitbalrates =$remitbal->rates +=$request->BillRates; 
            $remitbaloperationalcost =$remitbal->operationalcost +=$request->BillOppC;
            $remitbalcommission =$remitbal->commission +=$request->BillCommission; 
            $remitbalsecurity =$remitbal->security +=$request->SecurityCharge;
            $remitbalcaretaker =$remitbal->caretaker +=$request->CaretakerCharge; 
            $remitbalotherexpenses =$remitbal->otherexpenses +=$request->OtherExpensesCharge;
        }
        $property   = DB::table('allproperty')
        ->where('id', $propertyid)->select('streetaddress')->first();
        $updatedeductions = array('vat'=>$remitbalvat,'interest'=>$remitbalinterest ,
        'rates'=>$remitbalrates,'operationalcost'=>$remitbaloperationalcost ,
        'commission'=>$remitbalcommission,
        'security'=>$remitbalsecurity,'caretaker'=>$remitbalcaretaker,
        'otherexpenses'=>$remitbalotherexpenses);
        DB::table('propertyremitdeductions') 
                ->updateOrInsert(['propertyid'=>$propertyid,'currency'=>$currencycode],
                $updatedeductions);
        //completing double entry 
        // for amount remited
        if ($request->amountprocessed <> 0){
            $trxratedamt = $request->amountprocessed * $exchangerate;
        $trxdescription = 'Remittance for '.$property->streetaddress;
            DB::table('accounttransactions')
            ->insert(['trxreference'=>$trxid,'trxsubglaccount'=>$productsubledger
                ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,
                'trxamount'=>$request->amountprocessed,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$request->amountprocessed,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
           'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
        }
        // for comission
        if ($request->BillCommission <> 0){
            $trxratedamt = $request->BillCommission * $exchangerate;
        $trxcomdescription = 'Commission for '.$property->streetaddress;
            DB::table('accounttransactions')
            ->insert(['trxreference'=>$trxid,'trxglaccount'=>$comissioncode
                ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,
                'trxamount'=>$request->BillCommission,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxcomdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$request->BillCommission,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
           'trxdescription'=>$trxcomdescription,'trxsystemdate'=>$systemdate]);
        }
  
       DB::select('EXEC  spPostSingleRemit ?,?,?', array($trxid,$systemdate,$remitid));
       return  redirect()->route('transact.remit') 
       ->with('success', 'remittance processed');
    } catch (\Throwable $th) {
        return  redirect()->route('transact.remit') 
        ->with('error', 'failed to load property list');
    }
}
public function creditorview(){
    try {
        $arr['property']   = DB::table('allproperty')
        ->where('approval','=','Y')->where('available','=','Y')
        ->select('*')->get();
        $arr['currency']   = DB::table('currency')
        ->select('id','code')->get();
        return  view('transact/creditor-payment')
        ->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('transact.remit') 
        ->with('error', 'failed to load property list');
    }
}
public function getlandlorddetails($id){
    try { 
        $arr['property']   = DB::table('allproperty')
        ->where('id',$id)
        ->select('*')->first();
       return view('property/get-single-landlord-remit')
         ->with($arr);
    }catch (QueryException $e) {
        return 'failed';
    }
    
    
}
public function getcreditorbal($column,$id){
    try { 
        if($column=='otherexp'){$columnname = 'otherexpenses';}
        else if ($column=='caretaker'){$columnname = 'caretaker';}
        else if ($column=='security'){$columnname = 'security';}
        else if ($column=='vat'){$columnname = 'vat';}
        else if ($column=='oppcost'){$columnname = 'operationalcost';}
        else if ($column=='rates'){$columnname = 'rates';}
        $arr['balance']   = DB::table('propertyremitdeductions')
        ->where('propertyid',$id)
        ->select('currency',$columnname)->get();
       return view('transact/get-creditor-balance')
         ->with($arr);
    }catch (QueryException $e) {
        return 'failed';
    }
}
public function creditorpayment(Request $request){
    try {
        $systemdate             =       $this->systemdate();
        $trxid                  =       $this->transationid();
        $basecurrency           =       $this->getbasecurrency();
        $ledger_bank            =       'bank';
        $ledger_creditor        =       'creditors';
        $bankcode               =       $this->getgeneralledger($ledger_bank,$request->ReceiptCurrency);
        $creditorcode           =       $this->getgeneralledger($ledger_creditor,$request->ReceiptCurrency);
        /*check if the base currency is the one running 
                    use exchange rate as 1*/
        if(trim($basecurrency)==trim($request->ReceiptCurrency)){ $exchangerate =1;}
        else{ $exchangerate  =  $this->getexchangerate($request->ReceiptCurrency);   }

        if($request->CreditorCode=='otherexp'){$columnname = 'otherexpenses';}
        else if ($request->CreditorCode=='caretaker'){$columnname = 'caretaker';}
        else if ($request->CreditorCode=='security'){$columnname = 'security';}
        else if ($request->CreditorCode=='vat'){$columnname = 'vat';}
        else if ($request->CreditorCode=='oppcost'){$columnname = 'operationalcost';}
        else if ($request->CreditorCode=='rates'){$columnname = 'rates';}
        //get balance for exact product if not in then reject process
        $creditorbal   = DB::table('propertyremitdeductions')
        ->where('propertyid',$request->PropertyAddressDesc)
        ->where('currency',$request->ReceiptCurrency)
        ->select($columnname)->first();
        if(is_null($creditorbal)){
            return  redirect()->route('transact.viewpay') 
            ->with('error', 'no balance for the creditor');
        }
        if($creditorbal->$columnname == 0 || $creditorbal->$columnname ==''){
            return  redirect()->route('transact.viewpay') 
            ->with('error', 'no balance for the creditor');
        }
        $newcreditorbal = $creditorbal->$columnname -= $request->ReceiptAmount;
        if($newcreditorbal < 0){
            return  redirect()->route('transact.viewpay') 
            ->with('error', 'payment amount exceeds balance');
        }
        DB::table('propertyremitdeductions') 
                ->updateOrInsert(['propertyid'=>$request->PropertyAddressDesc,
                'currency'=>$request->ReceiptCurrency],[$columnname=>$newcreditorbal]);
        //insert creditors payment record
        DB::table('paymentscreditors')
           ->insert(['reference'=>$trxid,'propertyid'=>$request->PropertyAddressDesc
           ,'currencycode'=>$request->ReceiptCurrency,$columnname=>$request->ReceiptAmount]);
        //double entry for creditor balances 
        $trxratedamt = $request->ReceiptAmount * $exchangerate;
        $trxdescription = 'Payment for '.$columnname.' reference number '.$trxid;
            DB::table('accounttransactions')
            ->insert(['trxreference'=>$trxid,'trxglaccount'=>$creditorcode
                ,'trxtype'=>'TD','trxcurrencycode'=>$request->ReceiptCurrency,
                'trxamount'=>$request->ReceiptAmount,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$request->ReceiptCurrency,'trxamount'=>$request->ReceiptAmount,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,
           'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
           return  redirect()->route('transact.viewpay') 
           ->with('success', 'payment processed');
    } catch (\Throwable $th) {
        return  redirect()->route('transact.remit') 
        ->with('error', 'failed to load property list');
    }
}
}