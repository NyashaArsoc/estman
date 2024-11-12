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
        $this->middleware(['loginauth']);
    }
    public function getDate(){
         $todayvalue         = now()->format('Y-m-d');
         return $todayvalue;
    }
         /* Display a listing of the resource.
     */

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
