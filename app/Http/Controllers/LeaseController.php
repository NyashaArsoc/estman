<?php

namespace App\Http\Controllers;

use App\Models\Lease;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
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
                $isoccupied =1;
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
                        $request->RateSqm]);
            DB::table('propertyinspection')
            ->insert(['leaseid'=>$LeaseID,'nextinspectiondate'=>$inspectionperiod]);
            DB::table('rentreview')
            ->insert(['leaseid'=>$LeaseID,'nextreviewdate'=>$rentreviewperiod]);
          
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
    public function edit(Lease $lease)
    {
        //
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
        return view('lease/pending-approval');
    }
    public function  rejected(){
        return view('lease/rejected');
    }
    public function  listlandlords(){
        return view('lease/list');
    }
}
