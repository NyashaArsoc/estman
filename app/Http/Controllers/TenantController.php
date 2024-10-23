<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TenantController extends BaseController
{
public function __construct(){
        $this->middleware(['loginauth']);
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


}
