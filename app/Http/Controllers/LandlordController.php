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

    public function  addbanking(){
        $arr_owner['type']   = DB::table('clienttype')
        ->select('id','description')->get();
        $arr_owner['currency']   = DB::table('currency')
        ->select('id','code')->get();
      return view('landlord/banking-details')
      ->with($arr_owner);
    }
public function capturebankingdetails(Request $request){
    $user = $this->userdetail();
    IF (!empty($request->AccountNumber)){ 
        $AccountNumber         =      $request->AccountNumber;
     }Else { $AccountNumber = [0]; }
     IF (!empty($request->Currency)){ 
      $Currency         =      $request->Currency;
      }Else { $Currency = [0];}
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
    //  $arrayData = json_decode($Currency, true);
    $NumbersInArray         =       count($AccountName);
    $a  = 0;
    
    try {
        while ($a   <   $NumbersInArray){
            DB::table('landlordbank')
            ->Insert(['accountnumber'=>$AccountNumber[$a],'branch'=>$Branch[$a],
            'bankname'=>$BankName[$a],'accountname'=>$AccountName[$a],
                'currencycode'=>$Currency[$a],'landlordid'=>$request->LandlordName,'available'=>'Y',
                'operatorid'=>$user->username]);
            $a++;
        }
        return  redirect()->route('landlord.addbanking') 
                        ->with('success', 'landlord bank added');
    } catch (\Throwable $th) {
        return  redirect()->route('landlord.addbanking') 
        ->with('error', 'failed to add landlord bank');
    }
    
}

    public function  listlandlords(){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->select('fullname','id','companyname','nationalID','companynumber',
        'cell','email','clienttypeid','description','reasons','available','approval')
        ->get();
        return view('landlord/list')
        ->with($arr_owner);
    }
    public function getlandlord($id){
        $arr_owner['landlord']   = DB::table('alllandlord')
        ->where([['clienttypeid', $id],
        ['available','=' ,'Y']])
        ->select('fullname','id','companyname','clienttypeid')
        ->get();

         return view('landlord/get-single-landlord')
         ->with($arr_owner);
    }
/*
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
    }*/

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
        // subledger account creation -> interface+system ledger+accountgl+id  
        $landlordid = Crypt::decrypt($id);
        $productdescription = Crypt::decrypt($product);

        try{
            $ledgers  = DB::table('mappedsubledgersaccounts')
            ->where('staticdescription',$productdescription)
            ->whereNotIn('code',DB::table('subledgers')->where('landlordid',$landlordid)
                ->select('ledgercode'))
            ->select('*')
            ->get();
            if(is_null($ledgers)|| $ledgers->isEmpty()){ 
                return  redirect()->route('landlord.ledgers',$id) 
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
                    $subledgeraccount = $code.''.$landlordid;
                    DB::table('subledgers')
                    ->insert(
                        ['accountcode'=>$subledgeraccount,'landlordid'=>$landlordid,
                         'staticledgerid'=>$abc->staticid,'ledgercode'=>$code]);
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
public function disablelandlord($id){
    try{
        $landlordid = Crypt::decrypt($id);
        $update = array('approval' => 'N' , 'available'=> 'N');
        $property = DB::table('property')->where('landlordid',$landlordid)
        ->where('available', '=','Y')->select('id')->first();
        if(is_null($property)){
            DB::table('landlord')
            ->where('id',$landlordid)
            ->update($update);
            return  redirect()->route('landlord.list') 
            ->with('success', 'landlord disabled');
        }else{
            return  redirect()->route('landlord.list') 
            ->with('error', 'landlord attached to active properties');
        }
        
    } catch(QueryException $e){
        return  redirect()->route('landlord.list') 
        ->with('error', 'failed to disable landlord');
    }
}
}

