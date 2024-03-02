<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class PropertyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createnew()
    {
        $arr['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        $arr['currency']   = DB::table('currency')
        ->select('id','code')->get();
        $arr['province']   = DB::table('province')
        ->select('id','description')->get();
        $arr['propertytype']   = DB::table('propertytype')
        ->select('id','description')->get();
        $arr['commission']   = DB::table('interestoptions')
        ->select('id','description')->get();
      return view('property/add-property')
      ->with($arr);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function addnewproperty(Request $request)
    {
       try {
        $PropertyID = DB::table('property')
        ->insertGetId([
            'currencyid'=> $request->Currency, 'landlordid'=> $request->LandlordName, 'propertytypeid'=> $request->PropertyType,
            'provinceid'=> $request->Province, 'city'=> $request->City, 'location' => $request->LocationSurburb,
            'streetaddress' => $request->PropertyAddress, 'standnumber'=> $request->StandNumber,
            'comments'=> $request->Highlights, 'rooms'=> $request->Rooms, 'bedrooms'=> $request->Bedrooms,
            'bathrooms'=> $request->Bathrooms, 'stories'=> $request->Stories, 'totalarea'=> $request->TotalArea,
            'lettablearea'=> $request->LettableArea,'ratesqm'=> $request->ExpectedRate,'expectedrental'=> $request->ExpectedRental
        ]);
            DB::table('commissionpercent')
            ->updateOrInsert(['propertyid'=>$PropertyID],['interestoptionid'=>$request->CommissionType, 
                'percentage'=>$request->CommissionPercentage]);
                return  redirect()->route('property.newproperty') 
                ->with('success', 'property added successful');
       } catch (\Throwable $e) {
        return  redirect()->route('property.newproperty') 
        ->with('error', 'failed to add property');
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function vieweditproperty($id)
    {
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        $arr['currency']   = DB::table('currency')
        ->select('id','code')->get();
        $arr['province']   = DB::table('province')
        ->select('id','description')->get();
        $arr['propertytype']   = DB::table('propertytype')
        ->select('id','description')->get();
         $arr['commission']   = DB::table('interestoptions')
        ->select('id','description')->get();
            $arr['property']   = DB::table('allproperty')
            ->where('id', $propertyid)
            ->select('fullname','id','companyname','code','location','province',
            'propertytype','streetaddress','standnumber','comments','rooms','landlordtype',
            'bedrooms','bathrooms','stories','totalarea','lettablearea','ratesqm',
            'expectedrental','propertytypeid','commissionpercentage','commissionon','landlordclienttype',
            'commissionid','currencyid','propertytype','provinceid','city','landlordid')
            ->first();
            return view('property.edit-property')
           ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('property.rejected') 
            ->with('error', 'failed to load'.$e);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }
    public function  pendingapproval(){
        try {
            $arr['property']   = DB::table('allproperty')
        ->where('approval','=' ,'N')
        ->select('fullname','id','companyname','code','landlordclienttype',
        'location','propertytype','streetaddress')
        ->get();
        return view('property/pending-approval')
        ->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property') 
            ->with('error', 'failed to load');
        }
        
    }
    public function viewpending($id){
        $propertyid = Crypt::decrypt($id);
        try {
            $arr['property']   = DB::table('allproperty')
            ->where('id', $propertyid)
            ->select('fullname','id','companyname','code','location','province',
            'propertytype','streetaddress','city','standnumber','comments','rooms',
            'bedrooms','bathrooms','stories','totalarea','lettablearea','ratesqm',
            'expectedrental','propertytypeid','commissionpercentage','commissionon','landlordclienttype')
            ->first();
            return view('property/view-pending')
           ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('property.pending') 
            ->with('error', 'failed to load');
        }
        
    }
    public function approveproperty($id){
       
        try{
            $propertyid = Crypt::decrypt($id);
            $update = array('approval' => 'Y' , 'available'=> 'Y');
            DB::table('property')
            ->where('id',$propertyid)
            ->update($update);

            return  redirect()->route('property.pending') 
            ->with('success', 'property activated');
        } catch(QueryException $e){
            return  redirect()->route('property.pending') 
            ->with('error', 'failed to activate property');
        }
    }
    
    public function rejectproperty($id, Request $request){
       
        try{
            $propertyid = Crypt::decrypt($id);
            $update = array('approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->ReasonsForDecline);
            DB::table('property')
            ->where('id',$propertyid)
            ->update($update);

            return  redirect()->route('property.pending') 
            ->with('success', 'property rejected');
        } catch(QueryException $e){
            return  redirect()->route('property.pending') 
            ->with('error', 'failed to reject property');
        }
    }
    public function  rejected(){
        try {
            $arr['property']   = DB::table('allproperty')
            ->where('approval','=' ,'R')
            ->where('available','=' ,'N')
            ->select('fullname','id','companyname','code','landlordclienttype',
            'location','propertytype','streetaddress','reasons')
            ->get();
            return view('property/rejected')
            ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('property.pending') 
            ->with('error', 'failed to load');
        }
        
    }
    public function deleterejected($id){
        try{
            $propertyid = Crypt::decrypt($id);
            $update = array('available'=> 'D');
            DB::table('property')
            ->where('id',$propertyid)
            ->update($update);

            return  redirect()->route('property.rejected') 
            ->with('success', 'property deleted');
        } catch(QueryException $e){
            return  redirect()->route('property.rejected') 
            ->with('error', 'failed to deleted property');
        }
    }
    
    public function updateproperty($id, Request $request){
        try {
            $propertyid = Crypt::decrypt($id);
            DB::table('property')
            ->updateOrInsert(['id'=>$propertyid],
                ['currencyid'=> $request->Currency, 'landlordid'=> $request->LandlordName, 'propertytypeid'=> $request->PropertyType,
                'provinceid'=> $request->Province, 'city'=> $request->City, 'location' => $request->LocationSurburb,
                'streetaddress' => $request->PropertyAddress, 'standnumber'=> $request->StandNumber,
                'comments'=> $request->Highlights, 'rooms'=> $request->Rooms, 'bedrooms'=> $request->Bedrooms,
                'bathrooms'=> $request->Bathrooms, 'stories'=> $request->Stories, 'totalarea'=> $request->TotalArea,
                'lettablearea'=> $request->LettableArea,'ratesqm'=> $request->ExpectedRate,'expectedrental'=> $request->ExpectedRental
            ,'approval' => 'N' , 'available'=> 'N']);
                DB::table('commissionpercent')
                ->updateOrInsert(['propertyid'=>$propertyid],['interestoptionid'=>$request->CommissionType, 
                    'percentage'=>$request->CommissionPercentage]);
                    return  redirect()->route('property.rejected') 
                    ->with('success', 'property updated successful');
        } catch (QueryException $e) {
            return  redirect()->route('property.rejected') 
            ->with('error', 'failed to update');
        }
    }

    public function getpropertyaddress(Request $request, $id){

        $arr['property']   = DB::table('allproperty')
        ->where([['propertytypeid', $id],
        ['available','=' ,'Y']])
        ->orwhere([['occupation','=', 'E'],['occupation','=','P']])
        ->select('id','streetaddress','propertytypeid')
        ->get();
         return view('property/get-single-property')
         ->with($arr);
    }
    public function getpropertyareataken($id){
        $arr['prop'] = DB::table('propertyspacetaken')
        ->where('propertyid', $id)
        ->select('propertyid','totalareataken','roomstaken')
        ->first();
        return view('property/get-area-taken')
        ->with($arr);
    }
    public function getpropertyareaavailable($id){
        $arr['prop'] = DB::table('allproperty')
        ->where('id', $id)
        ->select('id','lettablearea')
        ->first();
        return view('property/get-area-available')
             ->with($arr);
    }
    public function  listproperties(){
        try {
            $arr['property']   = DB::table('allproperty')
            ->select('fullname','id','companyname','code','landlordclienttype',
            'location','propertytype','streetaddress','available','approval')
            ->get();
            return view('property/list')
            ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('property.rejected') 
            ->with('error', 'failed to load property list');
        }
    }

public function viewindividual($id){
    $propertyid = Crypt::decrypt($id);    
        try {
                BaseController::sharepropertyid($id);
                $arr['property']   = DB::table('allproperty')
                ->where('id', $propertyid)
                ->select('fullname','id','companyname','code','location','province',
                'propertytype','streetaddress','city','standnumber','comments','rooms',
                'bedrooms','bathrooms','stories','totalarea','lettablearea','ratesqm',
                'expectedrental','propertytypeid','commissionpercentage','commissionon','landlordclienttype')
                ->first();
            return view('property.view-single-property')
        ->with($arr);

        } catch (QueryException $e) {
            return  redirect()->route('property.list') 
            ->with('error', 'failed to load'.$e);
        }
    }
public function viewledgers($id){
        $propertyid = Crypt::decrypt($id);
              
        try {        
            $arr['property']   = DB::table('allproperty')
            ->where('id', $propertyid)
            ->select('id','companyname','landlordclienttype' ,'fullname','streetaddress')
            ->first();
            $arr['ledgers']   = DB::table('mappedsubledgersaccounts')
            ->where('propertyid', $propertyid)
            ->select('accountcode','currencycode','code','description')
            ->get();
            return view('property.view-ledgers')
        ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('property.list') 
            ->with('error', 'failed to load');
        }
    } 
public function createsubledgers($id,$product){
        // subledger account creation -> interface+system ledger+accountgl+id  
        $propertyid = Crypt::decrypt($id);
        $productdescription = Crypt::decrypt($product);

        try{
            $ledgers  = DB::table('mappedsubledgersaccounts')
            ->where('staticdescription',$productdescription)
            ->whereNotIn('code',DB::table('subledgers')->where('propertyid',$propertyid)
                ->select('ledgercode'))
            ->select('*')
            ->get();
            if(is_null($ledgers)|| $ledgers->isEmpty()){ 
                return  redirect()->route('property.ledgers',$id) 
                ->with('error', 'no ledgers found to map');
            }else{
                foreach($ledgers as $abc){
                $code = $abc->code;
                $generalledgerid = $abc->glid;
                $currencycode = $abc->currencycode;
                if(is_null($code) || is_null($generalledgerid) || is_null($currencycode)){
                    $caption = 'some ledgers are not configured correctly';
                    $head = 'error';
                }else{
                    $subledgeraccount = $code.''.$propertyid;
                    DB::table('subledgers')
                    ->insert(
                        ['accountcode'=>$subledgeraccount,'propertyid'=>$propertyid,
                         'staticledgerid'=>$abc->staticid,'ledgercode'=>$code]);
                    $caption = 'subledgers created';
                    $head = 'success';
                }
                    }
                    return  redirect()->route('property.ledgers',$id) 
                    ->with($head, $caption);
            }

        }catch(QueryException $e){
            return  redirect()->route('property.ledgers',$id) 
                    ->with('error', 'failed to load');
        }
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
public function disableproperty($id){
    try{
        $propertyid = Crypt::decrypt($id);
        $update = array('approval' => 'N' , 'available'=> 'N');
        $lease = DB::table('alllease')->where('propertyid',$propertyid)
        ->where('available', '=','Y')->select('id')->first();
        if(is_null($lease)){
            DB::table('property')
            ->where('id',$propertyid)
            ->update($update);
            return  redirect()->route('property.list') 
            ->with('success', 'property disabled');
        }else{
            return  redirect()->route('property.list') 
            ->with('error', 'property attached to active tenants');
        }
        
    } catch(QueryException $e){
        return  redirect()->route('property.list') 
        ->with('error', 'failed to disable property');
    }
}
}
