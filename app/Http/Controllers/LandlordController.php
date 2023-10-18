<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandlordController extends Controller
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
    public function create()
    {
        $arr_owner['type']   = DB::table('clienttype')
          ->select('id','description')->get();
          $arr_owner['currency']   = DB::table('currency')
          ->select('id','code')->get();
        return view('landlord/add-landlord')
        ->with($arr_owner);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        IF (!empty($request->AccountNumber)){ 
            $AccountNumber         =      $request->AccountNumber;
         }Else { $AccountNumber = [0]; }
         IF (!empty($request->CurrencyID)){ 
          $CurrencyID         =      $request->CurrencyID;
          }Else { $CurrencyID = [0];}
          IF (!empty($request->BankName)){ 
            $BankName         =      $request->BankName;
          }Else {
            $BankName = [0];
          }
          IF (!empty($request->AccountName)){ 
            $AccountName         =      $request->AccountName;
          }Else {
            $AccountName = [0];
          }
          IF (!empty($request->Branch)){ 
            $Branch         =      $request->Branch;
          }Else {
            $Branch = [0];
          }
        $NumbersInArray         =       count($CurrencyID);
        $a  = 0;

        try{
            if ($request->LandlordClientType    ==   1){//individual
                $ExistLandlord = DB::table('landlord')
                ->where('nationalID','=',$request->NationalID)->get();
                if  ( $ExistLandlord->isEmpty() ) {
                   $LandlordID = DB::table('landlord')
                    ->insertGetId(
                        ['nationalID'=>$request->NationalID,'clienttypeid'=>$request->LandlordClientType,
                         'firstname'=>$request->FirstName,'cell'=>$request->Cell,
                        'email'=>$request->Email,'tel'=>$request->Tel, 
                        'lastname'=>$request->LastName, 'contactaddress'=>$request->ContactAddress]
                    );
                    while ($a   <   $NumbersInArray){
                        DB::table('landlordbank')
                        ->updateOrInsert(
                            ['accountnumber'=>$AccountNumber[$a]],
                            ['branch'=>$Branch[$a],'bankname'=>$BankName[$a],'accountname'=>$AccountName[$a],
                            'currencyid'=>$CurrencyID[$a],'landlordid'=>$LandlordID]
                        );
                        $a++;
                    }
                    return  redirect()->route('landlord.create') 
                    ->with('success', 'landlord added successfully');
                }else{
                    return  redirect()->route('landlord.create') 
                    ->with('error', 'failed landlord already exists');
                }     
            }else{
                $ExistLandlord = DB::table('landlord')
                ->where('companynumber','=',$request->CompanyNumber)->get();
                if ( $ExistLandlord->isEmpty() ) {
                    $LandlordID = DB::table('landlord')
                    ->insertGetId(
                        ['companynumber'=>$request->CompanyNumber,
                        'clienttypeid'=>$request->LandlordClientType,
                        'email'=>$request->Email,'tel'=>$request->Tel, 'cell'=>$request->Cell,
                         'contactaddress'=>$request->ContactAddress,'bpnumber'=>$request->BPNumber,
                        'vatnumber'=>$request->VATNumber,'companyname'=>$request->CompanyName]
                    );
                    DB::table('landlordcontact')
                    ->updateOrInsert(
                        ['email'=>$request->ContactEmail],
                        ['cell'=>$request->ContactCell,'lastname'=>$request->ContactLastName,
                        'firstname'=>$request->ContactFirstName,'landlordid'=>$LandlordID]
                    );
                    while ($a   <   $NumbersInArray){
                        DB::table('landlordbank')
                        ->updateOrInsert(
                            ['accountnumber'=>$AccountNumber[$a]],
                            ['branch'=>$Branch[$a],'bankname'=>$BankName[$a],'accountname'=>$AccountName[$a],
                            'currencyid'=>$CurrencyID[$a],'landlordid'=>$LandlordID,'available'=>1]
                        );
                        $a++;
                    }
                    return  redirect()->route('landlord.create') 
                    ->with('success', 'landlord added successfully');
                }else{// exist landlord
                    return  redirect()->route('landlord.create') 
                    ->with('error', 'failed landlord already exists');
                }
               
            }
        }catch (QueryException $e){
            return  redirect()->route('landlord.create') 
            ->with('error', 'failed to add landlord');
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Landlord $landlord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $landlordid = Crypt::decrypt($id);
        try {
            $arr_owner['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)
            ->select('firstname','lastname','id','companyname','nationalID','companynumber',
            'cell','email','clienttypeid','description','vatnumber','bpnumber',
            'contactaddress','tel','fullname')
            ->first();
            $arr_owner['contact']   = DB::table('landlordcontact')
            ->where('landlordid', $landlordid)
            ->where('available', '=',1)
            ->select('email','cell','lastname','firstname')
            ->first();
            $arr_owner['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            return view('landlord.edit-landlord')
        ->with($arr_owner);

        } catch (QueryException $e) {
            return  redirect()->route('landlord.rejected') 
            ->with('error', 'failed to load');
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Landlord $landlord)
    {
        //
    }
    public function  addbanking(){
        $arr_owner['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        $arr_owner['currency']   = DB::table('currency')
        ->select('id','code')->get();
      return view('landlord/banking-details')
      ->with($arr_owner);
    }
    public function  pendingapproval(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,0)
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description')
        ->get();
        return view('landlord/pending-approval')
        ->with($arr_owner);
    }
    public function  rejected(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,2)
        ->where('available','=' ,0)
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description','reasons')
        ->get();
        return view('landlord/rejected')
        ->with($arr_owner);
    }
    public function  listlandlords(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,1)
        ->where('available','=' ,1)
        ->orwhere('available','=' ,2)
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description','reasons')
        ->get();
        return view('landlord/list')
        ->with($arr_owner);
    }
    public function getlandlord(Request $request, $id){
       // $request->landlordclientid
      //$id =1;
        $arr_owner['landlord']   = DB::table('landlord')
        ->where([['clienttypeid', $id],
        ['available','=' ,1]])
        ->select(DB::raw("concat(firstname,' ',lastname) As fullname"),'id','companyname','clienttypeid')
        ->get();
      // return $arr_owner['landlord'];
   
         return view('landlord/get-single-landlord')
         ->with($arr_owner);
    }

    public function approvelandlord($id){
       
        try{
            $landlordid = Crypt::decrypt($id);
            $update = array('approval' => 1 , 'available'=> 1);
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update($update);

            return  redirect()->route('landlord.pending') 
            ->with('success', 'landlord approved');
        } catch(QueryException $e){
            return  redirect()->route('landlord.pending') 
            ->with('error', 'failed to approve landlord');
        }
    }

    public function rejectlandlord($id, Request $request){
       
        try{
            $landlordid = Crypt::decrypt($id);
            $update = array('approval' => 2 , 'available'=> 0, 'reasons'=> $request->ReasonsForDecline);
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update($update);

            return  redirect()->route('landlord.pending') 
            ->with('success', 'landlord rejected');
        } catch(QueryException $e){
            return  redirect()->route('landlord.pending') 
            ->with('error', 'failed to reject landlord');
        }
    }
    public function viewpending($id){
        $landlordid = Crypt::decrypt($id);
        try {
            $arr_owner['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)
            ->select('fullname','id','companyname','nationalID','companynumber',
            'cell','email','clienttypeid','description','vatnumber','bpnumber',
            'contactaddress','tel')
            ->first();
            $arr_owner['contact']   = DB::table('landlordcontact')
            ->where('landlordid', $landlordid)
            ->where('available', '=',1)
            ->select('email','cell','lastname','firstname')
            ->first();

            return view('landlord/view-pending')
           ->with($arr_owner);
        } catch (QueryException $e) {
            return  redirect()->route('landlord.pending') 
            ->with('error', 'failed to load');
        }
        
    }

    public function updatelandlord($id, Request $request){

        try {
            $landlordid = Crypt::decrypt($id);
            DB::table('landlord')
            ->updateOrInsert(['id'=>$landlordid],
            ['companynumber'=>$request->CompanyNumber,'clienttypeid'=>$request->LandlordClientType,
            'email'=>$request->Email,'tel'=>$request->Tel, 'cell'=>$request->Cell,
             'contactaddress'=>$request->ContactAddress,'bpnumber'=>$request->BPNumber,
            'vatnumber'=>$request->VATNumber,'companyname'=>$request->CompanyName,
            'nationalID'=>$request->NationalID,'firstname'=>$request->FirstName,
            'lastname'=>$request->LastName,'approval' => 0 , 'available'=> 1]  );
            DB::table('landlordcontact')
                    ->updateOrInsert(
                        ['email'=>$request->ContactEmail],
                        ['cell'=>$request->ContactCell,'lastname'=>$request->ContactLastName,
                        'firstname'=>$request->ContactFirstName,'landlordid'=>$landlordid]
                    );
            return  redirect()->route('landlord.rejected') 
            ->with('success', 'submitted for approval');
        } catch (QueryException $e) {
            return  redirect()->route('landlord.rejected') 
            ->with('error', 'failed to update');
        }
    }

    public function deleterejected($id){
        try{
            $landlordid = Crypt::decrypt($id);
            $update = array('available'=> 3);
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update($update);

            return  redirect()->route('landlord.rejected') 
            ->with('success', 'landlord deleted');
        } catch(QueryException $e){
            return  redirect()->route('landlord.rejected') 
            ->with('error', 'failed to deleted landlord');
        }
    }
}

