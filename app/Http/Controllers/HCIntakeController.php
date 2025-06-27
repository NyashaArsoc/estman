<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

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
    /*-------------------apply----------------------- */
    function applyleave()
    {
        try {
            $staffids = DB::table('hcstaff')->pluck('staffid');
            $arr['staff']   = DB::table('systusers')->where('isavailable', 'Y')->where('username', '!=', 'admin')
                ->whereNotIn('id', $staffids)->select('*')->get();
            $arr['group']   = DB::table('hcleavegroups')->where('isactive', 'Y')->select('*')->get();
            return view('hc.intake.apply-leave')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
    /*------------------------add leave days----------------*/
    function addleavedays()
    {
        try {
            $staffids = DB::table('hcstaff')->pluck('staffid');
            $arr['staff']   = DB::table('systusers')->where('isavailable', 'Y')->where('username', '!=', 'admin')
                ->whereIn('id', $staffids)->select('*')->get();
            return view('hc.intake.add-day-stafflist')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
    function listgroupsperuser($id)
    {
        try {
            $userid = Crypt::decrypt($id);
            $arr['staff']   = DB::table('systusers')->where('id', $userid)->first();
            $arr['staffgroup']   = DB::table('hcstaff')->where('staffid', $userid)->first();
            $arr['type']   = DB::table('hcstaff')->where('staffid', $userid)->first();
            $tenant = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->select('hcleavetype.description', 'hctypegroup.id')->get();
        } catch (\Throwable $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        }
    }
}
