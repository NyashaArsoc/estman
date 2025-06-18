<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HCIntakeController extends Controller
{
    /*------------ import staff from users ---------*/
    function importstafflist()
    {
        try {
            $staffids = DB::table('hcstaff')->pluck('staffid');
            $arr['staff']   = DB::table('systusers')->where('isavailable', 'Y')->where('username', '!=', 'admin')
                ->whereNotIn('id', $staffids)->select('*')->get();
            $arr['group']   = DB::table('hcleavegroups')->where('isactive', 'Y')->select('*')->get();
            return view('hc.intake.import-staff')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
    function createstafflist(Request $request)
    {
        try {
            DB::table('hcstaff')->insert([
                'staffid' => $request->staff,
                'groupid' => $request->leavegroup,
                'operatorid' => session('alluser')
            ]);
            return  redirect()->route('hcin.impstaf')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
}
