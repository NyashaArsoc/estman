<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValApprovalController extends Controller
{
public function listallinstructionacknowledgement(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-acknowledge')->with($arr);
}
}
