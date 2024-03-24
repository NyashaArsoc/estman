<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TenantController extends BaseController
{
public function __construct(){
        $this->middleware(['loginauth']);
}
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
        try {
            $arr_owner['type']   = DB::table('clienttype')
                ->select('id','description')->get();
        return view('tenant/add-tenant')
             ->with($arr_owner);
        } catch (QueryException $e) {
            return  redirect()->route('tenant.pending') 
            ->with('error', 'failed to load');
        }


       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addnewtenant(Request $request)
    {
        try{
            if ($request->TenantClientType == 1){//individual
                $ExistTenant = DB::table('tenant')
                ->where('nationalid','=',$request->NationalID)->get();
                if ($ExistTenant->isEmpty() ){
                    $TenantID = DB::table('tenant')
                    ->insertGetId(
                        ['nationalid'=>$request->NationalID,'clienttypeid'=>$request->TenantClientType,
                         'firstname'=>$request->FirstName,'cell'=>$request->Cell,
                        'email'=>$request->Email,'tel'=>$request->Tel, 
                        'lastname'=>$request->LastName, 'contactaddress'=>$request->ContactAddress]
                    );
                    DB::table('tenantkeen')
                    ->updateOrInsert(
                        ['email'=>$request->KeenEmail],
                        ['cell'=>$request->KeenCell,'lastname'=>$request->KeenLastName,
                        'firstname'=>$request->KeenFirstName,'tenantid'=>$TenantID]
                    );
                    return  redirect()->route('tenant.newtenant') 
                    ->with('success', 'tenant added');
                }else{
                    return  redirect()->route('tenant.newtenant') 
                    ->with('error', 'failed tenant already exists');
                }
            }else{// company / corporate
                $ExistTenant = DB::table('tenant')
                ->where('companynumber','=',$request->CompanyNumber)->get();
                if ($ExistTenant->isEmpty()){
                    $TenantID = DB::table('tenant')
                    ->insertGetId(
                        ['companynumber'=>$request->CompanyNumber,
                        'clienttypeid'=>$request->TenantClientType,
                        'email'=>$request->Email,'tel'=>$request->Tel, 'cell'=>$request->Cell,
                         'contactaddress'=>$request->ContactAddress,'bpnumber'=>$request->BPNumber,
                        'vatnumber'=>$request->VATNumber,'companyname'=>$request->CompanyName]
                    );
                    DB::table('tenantcontact') 
                    ->updateOrInsert(
                        ['email'=>$request->ContactEmail],
                        ['cell'=>$request->ContactCell,'lastname'=>$request->ContactLastName,
                        'firstname'=>$request->ContactFirstName,'tenantid'=>$TenantID]
                    );
                    return  redirect()->route('tenant.newtenant') 
                    ->with('success', 'tenant added');
                }else{
                    return  redirect()->route('tenant.newtenant') 
                    ->with('error', 'failed tenant already exists');
                }
               
            }
        }catch (QueryException $e){
            return  redirect()->route('tenant.newtenant') 
            ->with('error', 'failed to add tenant');
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function viewedittenant($id)
    {
        $tenantid = Crypt::decrypt($id);
        try {
            $arr['tenant']   = DB::table('alltenant')
            ->where('id', $tenantid)
            ->select('firstname','lastname','id','companyname','nationalid','companynumber',
            'cell','email','clienttypeid','typedescription','vatnumber','bpnumber',
            'contactaddress','tel')
            ->first();
            $arr['contact']   = DB::table('tenantcontact')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
            $arr['keen']   = DB::table('tenantkeen')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
            $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            return view('tenant/edit-tenant')
        ->with($arr);

        } catch (QueryException $e) {
            return  redirect()->route('tenant.rejected') 
            ->with('error', 'failed to load');
        }
    
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
    public function  pendingapproval(){
        try {
            $arr_owner['tenant']   = DB::table('alltenant')
        ->where('approval','=' ,'N')
        ->select('fullname','id','companyname','nationalid','companynumber',
        'cell','email','clienttypeid','typedescription')
        ->get();
        return view('tenant/pending-approval')
        ->with($arr_owner);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property') 
            ->with('error', 'failed to load');
        } 
    }
    public function viewpending($id){
        $tenantid = Crypt::decrypt($id);
        try {
          
            $arr_owner['tenant']   = DB::table('alltenant')
            ->where('id', $tenantid)
            ->select('fullname','id','companyname','nationalid','companynumber',
            'cell','email','clienttypeid','typedescription','vatnumber','bpnumber',
            'contactaddress','tel')
            ->first();
            $arr_owner['contact']   = DB::table('tenantcontact')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
            $arr_owner['keen']   = DB::table('tenantkeen')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
            return view('tenant/view-pending')
            ->with($arr_owner);
        } catch (QueryException $e) {
            return  redirect()->route('tenant.pending') 
            ->with('error', 'failed to load'.$e);
        }
        
    }
    
    public function approvetenant($id){
        try{
            $tenantid = Crypt::decrypt($id);
            $updatetenant = array('approval' => 'Y' , 'available'=> 'Y');

            DB::table('tenant')
            ->where('id',$tenantid)
            ->update($updatetenant);

            return  redirect()->route('tenant.pending') 
            ->with('success', 'tenant activated');
        } catch(QueryException $e){
            return  redirect()->route('tenant.pending') 
            ->with('error', 'failed to activate tenant');
        }
    }
    public function rejecttenant($id, Request $request){
       
        try{
            $tenantid = Crypt::decrypt($id);
            $update = array('approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->ReasonsForDecline);
            DB::table('tenant')
            ->where('id',$tenantid)
            ->update($update);

            return  redirect()->route('tenant.pending') 
            ->with('success', 'tenant rejected');
        } catch(QueryException $e){
            return  redirect()->route('tenant.pending') 
            ->with('error', 'failed to reject tenant');
        }
    }
 
    public function  rejected(){
        $arr['tenant']   = DB::table('alltenant')
        ->where('approval','=' ,'R')
        ->where('available','=' ,'N')
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','typedescription','reasons')
        ->get();
        return view('tenant/rejected')
        ->with($arr);
    }
 
    public function updatetenant($id, Request $request){

        try {
            $tenantid = Crypt::decrypt($id);
            DB::table('tenant')
            ->updateOrInsert(['id'=>$tenantid],
            ['companynumber'=>$request->CompanyNumber,'clienttypeid'=>$request->TenantClientType,
            'email'=>$request->Email,'tel'=>$request->Tel, 'cell'=>$request->Cell,
             'contactaddress'=>$request->ContactAddress,'bpnumber'=>$request->BPNumber,
            'vatnumber'=>$request->VATNumber,'companyname'=>$request->CompanyName,
            'nationalid'=>$request->NationalID,'firstname'=>$request->FirstName,
            'lastname'=>$request->LastName,'approval' => 'N']  );
            DB::table('tenantcontact')
                    ->updateOrInsert(
                        ['email'=>$request->ContactEmail,'tenantid'=>$tenantid],
                        ['cell'=>$request->ContactCell,'lastname'=>$request->ContactLastName,
                        'firstname'=>$request->ContactFirstName]
                    );
            DB::table('tenantkeen')
                    ->updateOrInsert(
                        ['email'=>$request->KeenEmail,'tenantid'=>$tenantid],
                        ['cell'=>$request->KeenCell,'lastname'=>$request->KeenLastName,
                        'firstname'=>$request->KeenFirstName]
                    );
            return  redirect()->route('tenant.rejected') 
            ->with('success', 'submitted for approval');
        } catch (QueryException $e) {
            return  redirect()->route('tenant.rejected') 
            ->with('error', 'failed to update');
        }
    }

    public function  listtenants(){
        try {
            $arr['tenant']   = DB::table('alltenant')
            ->select('fullname','id','companyname','nationalid','companynumber',
            'cell','email','clienttypeid','typedescription','available','approval')
            ->get();
            return view('tenant/list')
            ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('tenant.approval') 
            ->with('error', 'failed to load tenant list');
        }
        
    }
    public function gettenant(Request $request, $id){

        $arr['tenant']   = DB::table('alltenant')
        ->where([['clienttypeid', $id],
        ['available','=' ,'Y']])
        ->select('id','companyname','clienttypeid','fullname')
        ->get();
         return view('tenant/get-single-tenant')
         ->with($arr);
    }
public function gettenantdetails($id){
    try { 
        $arr['tenant']    = collect(DB::select ('EXEC spGetSingleTenantByLeaseID ?',
        [$id]))->first();
        $arr['balances']    = DB::select ('EXEC spGetSingleLeaseCurrentAmountDue ?',
       [$id]);

       return view('tenant/get-single-tenant-alldetails')
         ->with($arr);
    }catch (QueryException $e) {
        return 'failed'.$e;
    }
    
    
}
public function viewindividual($id){
    $tenantid = Crypt::decrypt($id);
          
    try {
            BaseController::sharetenantid($id);
            $arr['tenant']   = DB::table('alltenant')
            ->where('id', $tenantid)
            ->select('fullname','id','companyname','nationalid','companynumber',
            'cell','email','clienttypeid','typedescription','vatnumber','bpnumber',
            'contactaddress','tel')
            ->first();
            $arr['contact']   = DB::table('tenantcontact')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
            $arr['keen']   = DB::table('tenantkeen')
            ->where('tenantid', $tenantid)
            ->select('email','cell','lastname','firstname')->latest('id')
            ->first();
        $arr['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        return view('tenant.view-single-tenant')
    ->with($arr);

    } catch (QueryException $e) {
        return  redirect()->route('tenant.list') 
        ->with('error', 'failed to load');
    }
}
public function viewtenantlease($id){
    $tenantid = Crypt::decrypt($id);
              
    try {        
        $arr['tenant']   = DB::table('alltenant')
            ->where('id', $tenantid)
            ->select('fullname','id','companyname','nationalid','companynumber',
            'cell','email','clienttypeid','typedescription','vatnumber','bpnumber',
            'contactaddress','tel')
            ->first();
        $arr['lease']   = DB::table('alllease')
            ->where('tenantid', $tenantid)
            ->select('fullname','companyname','id','clienttypeid','validfrom','available',
            'validto','propertydescription','rentalcurrency','rental','propertyid','approval','expiry')
            ->get();
        return view('tenant.view-tenant-leases')
    ->with($arr);
    } catch (QueryException $e) {
        return  redirect()->route('tenant.list') 
        ->with('error', 'failed to load');
    }
}
public function disabletenant($id){
    try{
        $tenantid = Crypt::decrypt($id);
        $update = array('approval' => 'N' , 'available'=> 'N');
        $lease = DB::table('alllease')->where('tenantid',$tenantid)
        ->where('available', '=','Y')->select('id')->first();
        if(is_null($lease)){
            DB::table('tenant')
            ->where('id',$tenantid)
            ->update($update);
            return  redirect()->route('tenant.list') 
            ->with('success', 'tenant disabled');
        }else{
            return  redirect()->route('tenant.list') 
            ->with('error', 'tenant attached to active leases');
        }
        
    } catch(QueryException $e){
        return  redirect()->route('tenant.list') 
        ->with('error', 'failed to disable tenant');
    }
}
}
