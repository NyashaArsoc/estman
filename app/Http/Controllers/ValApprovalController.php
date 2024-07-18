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
public function viewsingleacknowledge($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-instruct-acknowledge-port')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
public function listallinstructioncompile(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.list-instruct-compile')->with($arr);
}
public function viewsinglecompile($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.approval.view-single-instruct-compile')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
}
