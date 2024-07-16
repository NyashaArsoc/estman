<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValManageController extends Controller
{
public function listallclient(){
        $arr['client']   = DB::table('clienttype')
              ->select('*')->get();
       return view('val.manage.list-client')->with($arr);
}
public function editsingleclient($id){
    $arr['type']   = DB::table('clienttype')
    ->select('id','description')->get();
    return view('val.manage.edit-single-client')
    ->with($arr);
}
public function viewsingleclient($id){
    $arr['client']   = DB::table('clienttype')
              ->select('*')->get();
    return view('val.manage.view-single-client')
    ->with($arr);
}
}
