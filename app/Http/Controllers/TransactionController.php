<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
public function __construct(){
        $this->middleware(['loginauth']);
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
        $user = $this->userdetail();
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
                ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,'trxcreatedby'=>$user->username,
                'trxamount'=>$request->amountprocessed,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$request->amountprocessed,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,'trxcreatedby'=>$user->username,
           'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
        }
        // for comission
        if ($request->BillCommission <> 0){
            $trxratedamt = $request->BillCommission * $exchangerate;
        $trxcomdescription = 'Commission for '.$property->streetaddress;
            DB::table('accounttransactions')
            ->insert(['trxreference'=>$trxid,'trxglaccount'=>$comissioncode
                ,'trxtype'=>'TD','trxcurrencycode'=>$currencycode,'trxcreatedby'=>$user->username,
                'trxamount'=>$request->BillCommission,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxcomdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$currencycode,'trxamount'=>$request->BillCommission,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,'trxcreatedby'=>$user->username,
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
        $user                   =       $this->userdetail();
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
                ,'trxtype'=>'TD','trxcurrencycode'=>$request->ReceiptCurrency,'trxcreatedby'=>$user->username,
                'trxamount'=>$request->ReceiptAmount,'trxratedamount'=>$trxratedamt,
                'trxexchangerate'=>$exchangerate,'trxdescription'=>$trxdescription,
                'trxsystemdate'=>$systemdate]);
           //transaction credit
           DB::table('accounttransactions')
           ->insert(['trxreference'=>$trxid,'trxglaccount'=>$bankcode
           ,'trxtype'=>'TC','trxcurrencycode'=>$request->ReceiptCurrency,'trxamount'=>$request->ReceiptAmount,
           'trxratedamount'=>$trxratedamt,'trxexchangerate'=>$exchangerate,'trxcreatedby'=>$user->username,
           'trxdescription'=>$trxdescription,'trxsystemdate'=>$systemdate]);
           return  redirect()->route('transact.viewpay') 
           ->with('success', 'payment processed');
    } catch (\Throwable $th) {
        return  redirect()->route('transact.remit') 
        ->with('error', 'failed to load property list');
    }
}
}