<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropManManageController extends Controller
{
public function listalllandlords(){
    try {
        $arr['landlord']   = DB::table('propmanalllandlord')
        ->select('*')->get();
       return view('propman.manage.list-all-landlord')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.property');
    }
}
}
