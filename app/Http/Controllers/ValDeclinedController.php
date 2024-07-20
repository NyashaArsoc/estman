<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValDeclinedController extends Controller
{
public function listalldeclinedacknowledgement(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    return view('val.declined.list-instruct-acknowledge')->with($arr);
}
public function viewdeclinedsingleacknowledge($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.declined.view-single-instruct-acknowledge')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
public function listalldeclinedinstructionqualitycheck(){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.declined.list-instruct-quality-check')->with($arr);
}
public function viewdeclinedsinglequalitycheck($proid,$instrid){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
return view('val.declined.view-single-instruct-quality-check')->with($arr);
//return view('val.approval.view-single-instruct-acknowledge-norm')->with($arr);
}
}
