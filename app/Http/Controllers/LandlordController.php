<?php

namespace App\Http\Controllers;

use App\Models\Landlord;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LandlordController  extends BaseController
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
                            'currencyid'=>$CurrencyID[$a],'landlordid'=>$LandlordID,'available'=>'Y']
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
                            'currencyid'=>$CurrencyID[$a],'landlordid'=>$LandlordID,'available'=>'Y']
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
            ->where('available', '=','Y')
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
        ->where('approval','=' ,'N')
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description')
        ->get();
        return view('landlord/pending-approval')
        ->with($arr_owner);
    }
    public function  rejected(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,'R')
        ->where('available','=' ,'N')
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description','reasons')
        ->get();
        return view('landlord/rejected')
        ->with($arr_owner);
    }
    public function  listlandlords(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where('approval','=' ,'Y')
        ->where('available','=' ,'Y')
        ->orwhere('available','=' ,'R')
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
        ['available','=' ,'Y']])
        ->select(DB::raw("concat(firstname,' ',lastname) As fullname"),'id','companyname','clienttypeid')
        ->get();

         return view('landlord/get-single-landlord')
         ->with($arr_owner);
    }

    public function approvelandlord($id){
       
        try{
            $landlordid = Crypt::decrypt($id);
            $update = array('approval' => 'Y' , 'available'=> 'Y');
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
            $update = array('approval' => 'R' , 'available'=> 'N', 'reasons'=> $request->ReasonsForDecline);
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
            ->where('available', '=','Y')
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
            'lastname'=>$request->LastName,'approval' => 'N']  );
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
            $update = array('available'=> 'D');
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

    public function viewindividual($id){
        $landlordid = Crypt::decrypt($id);
              
        try {
                
               
                BaseController::sharelandlordid($id);
            $arr['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)
            ->select('firstname','lastname','id','companyname','nationalID','companynumber',
            'cell','email','clienttypeid','description','vatnumber','bpnumber',
            'contactaddress','tel','fullname')
            ->first();
            $arr['contact']   = DB::table('landlordcontact')
            ->where('landlordid', $landlordid)
            ->where('available', '=','Y')
            ->select('email','cell','lastname','firstname')
            ->first();
            $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
            
            return view('landlord.view-single-landlord')
        ->with($arr);

        } catch (QueryException $e) {
            return  redirect()->route('landlord.list') 
            ->with('error', 'failed to load');
        }
    }
    public function viewledgers($id){
        $landlordid = Crypt::decrypt($id);
              
        try {        
            $arr['landlord']   = DB::table('alllandlord')
            ->where('id', $landlordid)
            ->select('id','companyname','clienttypeid' ,'fullname','description')
            ->first();
            $arr['ledgers']   = DB::table('mappedsubledgersaccounts')
            ->where('landlordid', $landlordid)
            ->select('accountcode','currencycode','code','description')
            ->get();
            return view('landlord.view-ledgers')
        ->with($arr);
        } catch (QueryException $e) {
            return  redirect()->route('landlord.list') 
            ->with('error', 'failed to load');
        }
    }
    public function createsubledgers($id,$product){
        // subledger account creation -> interface+accountgl+prduct+system ledger+id  
        $landlordid = Crypt::decrypt($id);
        $productdescription = Crypt::decrypt($product);

        try{
            $ledgers  = DB::table('mappedsubledgersaccounts')
            ->where('productdescription',$productdescription)
            ->select('*')
            ->get();
            if($ledgers->isEmpty()){ 
                return  redirect()->route('landlord.ledgers',$id) 
                ->with('error', 'no products found to map');
            }else{
                foreach($ledgers as $abc){
                $code = $abc->code;
                $productid = $abc->productid;
                $systemledgerid = $abc->staticid;
                if(is_null($code) || is_null($productid) || is_null($systemledgerid)){
                    $caption = 'some ledgers are not configured correctly';
                    $head = 'error';
                }else{
                    $subledgeraccount = $code.''.$productid.''.$systemledgerid.''.$landlordid;
                    DB::table('subledgers')
                    ->insert(
                        ['accountcode'=>$subledgeraccount,'landlordid'=>$landlordid,
                         'staticledgerid'=>$systemledgerid,'ledgercode'=>$code]);
                    $caption = 'subledgers created';
                    $head = 'success';
                }
                    }
                    return  redirect()->route('landlord.ledgers',$id) 
                    ->with($head, $caption);
            }

        }catch(QueryException $e){
            return  redirect()->route('landlord.ledgers',$id) 
                    ->with('error', 'failed to load');
        }
    }
}

