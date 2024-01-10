<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function viewnewbalances(){
        try {
            $arr['balances'] = DB::select('EXEC spGetallunpostedleaserates');
            return  view('transact.new-lease-bal') 
            ->with($arr);
        } catch (QueryException $th) {
            return  redirect()->route('lease.list') 
            ->with('error', 'failed to load');
        }
      
    }
}
