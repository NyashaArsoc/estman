<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class LeaseController extends BaseController
{
    private $monthlyvalue;
    private $addmonthlyvalue;
    private $quarterlyvalue;
    private $addquarterlyvalue;
    private $halfyearlyvalue;
    private $addhalfyearlyvalue;
    private $yearlyvalue;
    private $addyearlyvalue;
    private $todayvalue;
    private $timeinseconds;

    public function __construct(){
        $this->todayvalue = date("Y-m-d H:i:s");
        $this->timeinseconds = strtotime($this->todayvalue);
        $this->addmonthlyvalue  = $this->timeinseconds + ((3600*24)*30);
        $this->addquarterlyvalue = $this->timeinseconds + ((3600*24)*90);
        $this->addhalfyearlyvalue = $this->timeinseconds + ((3600*24)*180);
        $this->addyearlyvalue = $this->timeinseconds + ((3600*24)*360);
        $this->monthlyvalue  = date("Y-m-d", $this->addmonthlyvalue);
        $this->quarterlyvalue  = date("Y-m-d", $this->addquarterlyvalue);
        $this->halfyearlyvalue  = date("Y-m-d", $this->addhalfyearlyvalue);
        $this->yearlyvalue  = date("Y-m-d", $this->addyearlyvalue);
    }
    public function getDate(){
         $todayvalue         = now()->format('Y-m-d');
         return $todayvalue;
    }
         /* Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
            $arr['province']   = DB::table('province')
            ->select('id','description')->get();
            $arr['propertytype']   = DB::table('propertytype')
            ->select('id','description')->get();
            $arr['period']   = DB::table('periodviews')
            ->select('id','description')->get();
          return view('lease/add-lease')
          ->with($arr);
            
        } catch (QueryException $e) {
            return  redirect()->route('tenant.create') 
            ->with('error', 'failed to load lease');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            // inspection schedule
            if($request->InspectionPeriod == 'monthly') {
               $inspectionperiod   = $this->monthlyvalue;
            }else if($request->InspectionPeriod == 'quarterly') {
                $inspectionperiod   = $this->quarterlyvalue;
            }else if($request->InspectionPeriod == 'half yearly') {
                $inspectionperiod   = $this->halfyearlyvalue;
            }else if($request->InspectionPeriod == 'yearly') {
                $inspectionperiod   = $this->yearlyvalue;
            }
            // rental review
            if($request->RentReviewPeriod == 'monthly') {
                $rentreviewperiod   = $this->monthlyvalue;
             }else if($request->RentReviewPeriod == 'quarterly') {
                 $rentreviewperiod   = $this->quarterlyvalue;
             }else if($request->RentReviewPeriod == 'half yearly') {
                 $rentreviewperiod   = $this->halfyearlyvalue;
             }else if($request->RentReviewPeriod == 'yearly') {
                 $rentreviewperiod   = $this->yearlyvalue;
             }
             // property type
            if($request->PropertyType==1) {
                $rental = $request->ExpectedRental;
            }else{
                $rental = $request->RateSqm * $request->AreaTaken;
      //          $areabalance = $request->AvailableLettableArea -($request->OccupiedArea + $request->AreaTaken);
            }
            $LeaseID    = DB::table('lease')
            ->insertGetId(['tenantid'=>$request->TenantName,'propertyid'=>$request->PropertyAddress,
                        'validfrom'=>$request->LeaseValidFrom, 'validto'=>$request->LeaseValidTo,
                        'areataken'=>$request->AreaTaken,'rates'=>$request->RatesCost,'operatingcosts'
                        =>$request->OperationalCost,'rental'=>$rental,'rentalcurrencyid'=>
                        $request->RentCurrency,'deposit'=>$request->DepositPaid,'depositcurrencyid'=>$request
                        ->DepositCurrency,'balancebdcurrencyid'=>$request->BalanceBDCurrency,
                        'balancebd'=>$request->BDamount,'ratescurrencyid'=>$request->RatesCurrency,
                        'operatingcostcurrencyid'=>$request->OperationCurrency,'ratesqm'=>
                        $request->RateSqm,'propertydescription'=>$request->PropertyDescription]);
            DB::table('propertyinspection')
            ->insert(['leaseid'=>$LeaseID,'nextinspectiondate'=>$inspectionperiod]);
            DB::table('rentreview')
            ->insert(['leaseid'=>$LeaseID,'nextreviewdate'=>$rentreviewperiod]);
            DB::table('leaseschedules')
            ->insert(['leaseid'=>$LeaseID,'rentreview'=>$request->RentReviewPeriod,
            'inspectionperiod'=>$request->InspectionPeriod]);
          
            return  redirect()->route('lease.create') 
            ->with('success', 'lease added');
        }catch (QueryException $e) {
            return  redirect()->route('lease.create') 
            ->with('error', 'failed to add lease');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Lease $lease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function vieweditlease($id)
    {
        $leaseid = Crypt::decrypt($id);
        try {
        $arr['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        $arr['currency']   = DB::table('currency')
        ->select('id','code')->get();
        $arr['province']   = DB::table('province')
        ->select('id','description')->get();
        $arr['propertytype']   = DB::table('propertytype')
        ->select('id','description')->get();
        $arr['period']   = DB::table('periodviews')
        ->select('id','description')->get();
        $arr['lease']   = DB::table('alllease')
        ->where('id', $leaseid)
        ->select('*')
        ->first();
        $arr['inspection'] = DB::table('propertyinspection')
        ->where('leaseid', $leaseid)
        ->select('*')
        ->orderBy('id','desc')
        ->first();
        $arr['review'] = DB::table('rentreview')
        ->where('leaseid', $leaseid)
        ->select('*')
        ->orderBy('id','desc')
        ->first();
        $arr['balances'] = DB::select('EXEC spGetunpostedleaserates ?',[$leaseid]);
        return view('lease.edit-lease')
        ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('property.rejected') 
        ->with('error', 'failed to load'.$e);
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lease $lease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lease $lease)
    {
        //
    }
    
    public function  pendingapproval(){
        try {
            $arr['lease']   = DB::table('alllease')
            ->where('approval','=' ,'N')
            ->select('fullname','companyname','id','clienttypeid','validfrom',
            'validto','propertydescription','rentalcurrency','rental','propertyid')
            ->get();
            return view('lease/pending-approval')
            ->with($arr);
        } catch (QueryException $th) {
            return  redirect()->route('lease.addcreate') 
            ->with('error', 'failed to load');
        }
       
    }
    // public function viewpendingoldnotin($id){
    //     $leaseid = Crypt::decrypt($id);
    //     try {
    //         $arr['lease']   = DB::table('alllease')
    //         ->where('id', $leaseid)
    //         ->select('*')
    //         ->first();
    //         $arr['inspection'] = DB::table('propertyinspection')
    //         ->where('leaseid', $leaseid)
    //         ->select('*')
    //         ->orderBy('id','desc')
    //         ->first();
    //         $arr['review'] = DB::table('rentreview')
    //         ->where('leaseid', $leaseid)
    //         ->select('*')
    //         ->orderBy('id','desc')
    //         ->first();
    //     //return $arr;
    //        return view('lease/view-pending')
    //         ->with($arr);
    //     } catch (QueryException $e) {
    //         return  redirect()->route('lease.pending') 
    //         ->with('error', 'failed to load');
    //     }
        
    // }
    public function rejectlease($id, Request $request){
       
        try{
            $leaseid = Crypt::decrypt($id);
            $update = array('approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->ReasonsForDecline);
            DB::table('lease')
            ->where('id',$leaseid)
            ->update($update);

            return  redirect()->route('lease.pending') 
            ->with('success', 'lease rejected');
        } catch(QueryException $e){
            return  redirect()->route('lease.pending') 
            ->with('error', 'failed to reject lease');
        }
    }
    public function approvelease($id,$pid,$product){
        $leaseid = Crypt::decrypt($id);
        $propertyid = Crypt::decrypt($pid);
        try{
            $property   = DB::table('allproperty')
            ->where('id', $propertyid)
           ->where('available','=' ,'Y')
            ->select('totalarea','lettablearea','propertytypeid','streetaddress')
            ->first();
            if(is_null($property)) {
                return  redirect()->route('lease.pending') 
                ->with('error', 'failed to approve property not found');  
            }else{   
                $lease   = DB::table('alllease')
            ->where('id', $leaseid)
            ->select('areataken')
            ->first();
              
                $space   = DB::table('propertyspacetaken')
                ->where('propertyid', $propertyid)
                ->select('totalareataken')
                ->first();    
                if(is_null($space)){$spacetaken = 0; }
                else{$spacetaken = $space->totalareataken;}
                $minmuinpercentage = 0.015 * $property->lettablearea;
                $remainingspace  = $property->lettablearea - ($lease->areataken + $spacetaken);  
                if($property->propertytypeid ==1){ //Residential building
                    $occupationstatus = 'F';
                }else{
                    if($remainingspace >= 0 and $remainingspace <= $minmuinpercentage){
                        $occupationstatus = 'F';
                    }elseif($remainingspace > $minmuinpercentage){
                        $occupationstatus = 'P';
                    }else{
                        return  redirect()->route('lease.pending') 
                        ->with('error', 'property'.$property->streetaddress.'if fully occupied');
                    }
                }
             
            $updatelease    = array('approval' => 'Y' , 'available'=> 'Y');
            $updateproperty = array('occupation' => $occupationstatus );
            DB::table('lease')
            ->where('id',$leaseid)
            ->update($updatelease);
            DB::table('property')
            ->where('id',$propertyid)
            ->update($updateproperty);

            $this->createsubledgers($id,$product);
            
           return  redirect()->route('lease.pending') 
           ->with('success', 'lease approved'); 
            }
        } catch(QueryException $e){
            return  redirect()->route('lease.pending') 
            ->with('error', 'failed to approve lease');
        }
    }
    public function  rejected(){
        try {
            $arr['lease']   = DB::table('alllease')
            ->where('approval','=' ,'R')
            ->where('available','=' ,'N')
            ->select('fullname','companyname','id','clienttypeid','validfrom',
            'validto','propertydescription','rentalcurrency','rental','reasons')
            ->get();
            return view('lease/rejected')
            ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('lease.pending') 
            ->with('error', 'failed to load');
        }
       
    }
    public function  listleases(){
        try {
            $arr['lease']   = DB::table('alllease')
            ->select('fullname','companyname','id','clienttypeid','validfrom','available','expiry',
            'validto','propertydescription','rentalcurrency','rental','propertyid','approval')
            ->get();
            return view('lease/list')
            ->with($arr);
        } catch (QueryException $th) {
            return  redirect()->route('lease.addcreate') 
            ->with('error', 'failed to load');
        }
    }
    
    public function updatelease($id, Request $request){
        try {
            $leaseid = Crypt::decrypt($id);
             // inspection schedule
             if($request->InspectionPeriod == 'monthly') {
                $inspectionperiod   = $this->monthlyvalue;
             }else if($request->InspectionPeriod == 'quarterly') {
                 $inspectionperiod   = $this->quarterlyvalue;
             }else if($request->InspectionPeriod == 'half yearly') {
                 $inspectionperiod   = $this->halfyearlyvalue;
             }else if($request->InspectionPeriod == 'yearly') {
                 $inspectionperiod   = $this->yearlyvalue;
             }
             // rental review
            if($request->RentReviewPeriod == 'monthly') {
                $rentreviewperiod   = $this->monthlyvalue;
             }else if($request->RentReviewPeriod == 'quarterly') {
                 $rentreviewperiod   = $this->quarterlyvalue;
             }else if($request->RentReviewPeriod == 'half yearly') {
                 $rentreviewperiod   = $this->halfyearlyvalue;
             }else if($request->RentReviewPeriod == 'yearly') {
                 $rentreviewperiod   = $this->yearlyvalue;
             }
              // property type
            if($request->PropertyType==1) {
                $rental = $request->ExpectedRental;
            }else{
                $rental = $request->RateSqm * $request->AreaTaken;
            }
            DB::table('lease')
            ->updateOrInsert(['id'=>$leaseid],
            ['tenantid'=>$request->TenantName,'propertyid'=>$request->PropertyAddress,
            'validfrom'=>$request->LeaseValidFrom, 'validto'=>$request->LeaseValidTo,
            'areataken'=>$request->AreaTaken,'rental'=>$rental,'rentalcurrencyid'=>
            $request->RentCurrency,'ratesqm'=>
            $request->RateSqm,'propertydescription'=>$request->PropertyDescription
            ,'approval' => 'N' , 'available'=> 'N']);

            DB::table('leaseschedules')
            ->updateOrInsert(['leaseid'=>$leaseid],
            ['inspectionperiod'=>$request->InspectionPeriod,'rentreview'=>$request->RentReviewPeriod]);
        
          return  redirect()->route('lease.rejected') 
                    ->with('success', 'lease updated successful');
        } catch (QueryException $e) {
            return  redirect()->route('lease.rejected') 
            ->with('error', 'failed to update');
        }
    }

    public function addcreate()
    {
        try {
            $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
            $arr['province']   = DB::table('province')
            ->select('id','description')->get();
            $arr['propertytype']   = DB::table('propertytype')
            ->select('id','description')->get();
            $arr['period']   = DB::table('periodviews')
            ->select('id','description')->get();
          return view('lease/add-lease')
          ->with($arr);
            
        } catch (QueryException $e) {
            return  redirect()->route('tenant.addcreate') 
            ->with('error', 'failed to load lease');
        }
    }
    public function addstore(Request $request)
    {
        try {
            IF (!empty($request->LeaseItemCurrencyID)){ 
                $CurrencyID         =      $request->LeaseItemCurrencyID;
             }Else { $CurrencyID = [0]; }
             IF (!empty($request->LeaseItemBDamount)){ 
              $BalanceBD         =      $request->LeaseItemBDamount;
              }Else { $BalanceBD = [0];}
              IF (!empty($request->LeaseItemRatesCost)){ 
                $RatesCost         =      $request->LeaseItemRatesCost;
              }Else {  $RatesCost = [0]; }
              IF (!empty($request->LeaseItemOperationalCost)){ 
                $OperationalCost         =      $request->LeaseItemOperationalCost;
              }Else {  $OperationalCost = [0]; }
              IF (!empty($request->LeaseItemDepositPaid)){ 
                $DepositPaid         =      $request->LeaseItemDepositPaid;
              }Else { $DepositPaid = [0];  }
              IF (!empty($request->LeaseItemAdminPaid)){ 
                $AdminPaid         =      $request->LeaseItemAdminPaid;
              }Else {  $AdminPaid = [0];  }
            $NumbersInArray         =       count($CurrencyID);
            $a  = 0;
            
            // inspection schedule
            if($request->InspectionPeriod == 'monthly') {
               $inspectionperiod   = $this->monthlyvalue;
            }else if($request->InspectionPeriod == 'quarterly') {
                $inspectionperiod   = $this->quarterlyvalue;
            }else if($request->InspectionPeriod == 'half yearly') {
                $inspectionperiod   = $this->halfyearlyvalue;
            }else if($request->InspectionPeriod == 'yearly') {
                $inspectionperiod   = $this->yearlyvalue;
            }
            // rental review
            if($request->RentReviewPeriod == 'monthly') {
                $rentreviewperiod   = $this->monthlyvalue;
             }else if($request->RentReviewPeriod == 'quarterly') {
                 $rentreviewperiod   = $this->quarterlyvalue;
             }else if($request->RentReviewPeriod == 'half yearly') {
                 $rentreviewperiod   = $this->halfyearlyvalue;
             }else if($request->RentReviewPeriod == 'yearly') {
                 $rentreviewperiod   = $this->yearlyvalue;
             }
             // property type
            if($request->PropertyType==1) {
                $rental = $request->ExpectedRental;
            }else{
                $rental = $request->RateSqm * $request->AreaTaken;
      //          $areabalance = $request->AvailableLettableArea -($request->OccupiedArea + $request->AreaTaken);
            }
            $LeaseID    = DB::table('lease')
            ->insertGetId(['tenantid'=>$request->TenantName,'propertyid'=>$request->PropertyAddress,
                        'validfrom'=>$request->LeaseValidFrom, 'validto'=>$request->LeaseValidTo,
                        'areataken'=>$request->AreaTaken,'rental'=>$rental,'rentalcurrencyid'=>
                        $request->RentCurrency,'propertydescription'=>$request->PropertyDescription,
                    'ratesqm'=>$request->RateSqm]);
            DB::table('propertyinspection')
            ->insert(['leaseid'=>$LeaseID,'nextinspectiondate'=>$inspectionperiod]);
            DB::table('rentreview')
            ->insert(['leaseid'=>$LeaseID,'nextreviewdate'=>$rentreviewperiod]);
            DB::table('leaseschedules')
            ->insert(['leaseid'=>$LeaseID,'rentreview'=>$request->RentReviewPeriod,
            'inspectionperiod'=>$request->InspectionPeriod]);
            while ($a   <   $NumbersInArray){
                DB::table('unpostedleaserates')
                ->Insert(
                    ['leaseid'=>$LeaseID,'currencyid'=>$CurrencyID[$a],'adminpaid'=>$AdminPaid[$a],
                    'balancebd'=>$BalanceBD[$a],'deposit'=>$DepositPaid[$a],
                    'ratescosts'=>$RatesCost[$a],'operationalcosts'=>$OperationalCost[$a]]
                );
                $a++;
            }
          
            return  redirect()->route('lease.addcreate') 
            ->with('success', 'lease added');
        }catch (QueryException $e) {
            return  redirect()->route('lease.addcreate') 
            ->with('error', 'failed to add lease'.$e);
        }
    }

    public function viewpending($id){
        $leaseid = Crypt::decrypt($id);
        try {
            $arr['lease']   = DB::table('alllease')
            ->where('id', $leaseid)
            ->select('*')
            ->first();
            $arr['inspection'] = DB::table('propertyinspection')
            ->where('leaseid', $leaseid)
            ->select('*')
            ->orderBy('id','desc')
            ->first();
            $arr['review'] = DB::table('rentreview')
            ->where('leaseid', $leaseid)
            ->select('*')
            ->orderBy('id','desc')
            ->first();
            $arr['balances'] = DB::select('EXEC spGetunpostedleaserates ?',[$leaseid]);
        //return $arr;
           return view('lease/view-pending')
            ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('lease.pending') 
            ->with('error', 'failed to load');
        }
       
    }

public function viewindividual($id){
    $leaseid = Crypt::decrypt($id);   
try {
      BaseController::shareleaseid($id);
         $arr['lease']   = DB::table('alllease')
          ->where('id', $leaseid)
          ->select('*')->first();
          $arr['inspection'] = DB::table('propertyinspection')
          ->where('leaseid', $leaseid)
          ->select('*')
          ->orderBy('id','desc')->first();
          $arr['review'] = DB::table('rentreview')
          ->where('leaseid', $leaseid)
          ->select('*')->orderBy('id','desc')->first();
          //procedure deleted, the reason being to restructure 
          $arr['balances'] = DB::select('EXEC spGetunpostedleaserates ?',[$leaseid]);
       return view('lease.view-single-lease')
            ->with($arr);
    
            } catch (QueryException $e) {
                return  redirect()->route('lease.list') 
                ->with('error', 'failed to load');
            }
        }

public function viewledgers($id){
            $leaseid = Crypt::decrypt($id);
                  
            try {        
                $arr['lease']   = DB::table('alllease')
                ->where('id', $leaseid)
                ->select('id','clienttypeid' ,'fullname','propertydescription','companyname')
                ->first();
                $arr['ledgers']   = DB::table('mappedsubledgersaccounts')
                ->where('leaseid', $leaseid)
                ->select('accountcode','currencycode','code','description')
                ->get();
                return view('lease.view-ledgers')
            ->with($arr);
            } catch (QueryException $e) {
                return  redirect()->route('lease.list') 
                ->with('error', 'failed to load');
            }
        }
public function createsubledgers($id,$product){
            // subledger account creation -> interface+accountgl+prduct+system ledger+id  
            $leaseid = Crypt::decrypt($id);
            $productdescription = Crypt::decrypt($product);
    
            try{
                $ledgers  = DB::table('mappedsubledgersaccounts')
                ->where('staticdescription',$productdescription)
                ->whereNotIn('code',DB::table('subledgers')->where('leaseid',$leaseid)
                ->select('ledgercode'))
                ->select('*')
                ->get();
                if(is_null($ledgers) || $ledgers->isEmpty()){ 
                    return  redirect()->route('lease.ledgers',$id) 
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
                        $subledgeraccount = $code.''.$leaseid;
                        DB::table('subledgers')
                        ->insert(
                            ['accountcode'=>$subledgeraccount,'leaseid'=>$leaseid,
                             'staticledgerid'=>$abc->staticid,'ledgercode'=>$code]);
                        $caption = 'subledgers created';
                        $head = 'success';
                    }
                        }
                        return  redirect()->route('lease.ledgers',$id) 
                        ->with($head, $caption);
                    
                }
    
            }catch(QueryException $e){
                return  redirect()->route('lease.ledgers',$id) 
                        ->with('error', 'failed to load'.$e);
            }
        } 
public function disablelease($id){
            try{
                $leaseid = Crypt::decrypt($id);
                $update = array('approval' => 'N' , 'available'=> 'N');
                DB::table('lease')
                    ->where('id',$leaseid)
                    ->update($update);
                    return  redirect()->route('lease.list') 
                    ->with('success', 'lease disabled');
                
            } catch(QueryException $e){
                return  redirect()->route('lease.list') 
                ->with('error', 'failed to disable lease');
            }
        }
public function viewrenewal($id){
            $leaseid = Crypt::decrypt($id);   
        try {
                 $arr['lease']   = DB::table('alllease')
                  ->where('id', $leaseid)
                  ->select('*')->first();
                  $arr['inspection'] = DB::table('propertyinspection')
                  ->where('leaseid', $leaseid)
                  ->select('*')
                  ->orderBy('id','desc')->first();
                  $arr['review'] = DB::table('rentreview')
                  ->where('leaseid', $leaseid)
                  ->select('*')->orderBy('id','desc')->first();
                  //procedure deleted, the reason being to restructure 
                  $arr['balances'] = DB::select('EXEC spGetunpostedleaserates ?',[$leaseid]);
               return view('lease.view-single-lease-renewal')
                    ->with($arr);
            
                    } catch (QueryException $e) {
                        return  redirect()->route('lease.list') 
                        ->with('error', 'failed to load');
                    }
}
public function singlerenewal($id, Request $request){
    $leaseid = Crypt::decrypt($id);  
    try {
        DB::select('EXEC spPutSingleLeaseRenewal
        ?,?,?',array($leaseid,$request->LeaseValidFrom,$request->LeaseValidTo));
        return  redirect()->route('lease.list') 
        ->with('success', 'lease renewed');
    } catch (\Throwable $th) {
        return  redirect()->route('lease.list') 
        ->with('error', 'failed to load'.$th);
    }
}
}
