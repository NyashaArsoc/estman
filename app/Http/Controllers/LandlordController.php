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

