<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class HCManageController extends Controller
{
    /*----------list all staff members ---------------- */
    function listallstaff()
    {
        try {
            $arr['staff']   = DB::table('hcallstaff')
                ->select('*')->get();
            return view('hc.manage.list-all-staff')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    /*------------view single staff---------- */
    function viewsinglestaff($uid, $gid)
    {
        try {
            $userid = Crypt::decrypt($uid);
            $arr['staff']   = DB::table('hcallstaff')->where('staffid', $userid)->first();
            $arr['typegroup'] = DB::select('EXEC spGetHCLeaveDaysPerStaff ?', [$userid]);
            // $arr['typegroup'] = DB::table('hctypegroup')->join('hcallstaff', 'hctypegroup.groupid', '=', 'hcallstaff.groupid')
            //     ->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
            //     ->where('hcallstaff.staffid', $userid)->get();
            /*   $arr['staffgroup']   = DB::table('hcstaff')->join('hcleavegroups', 'hcstaff.groupid', '=', 'hcleavegroups.id')
                ->where('hcstaff.staffid', $userid)->first();
            $typeidstakeon = DB::table('hctakeondays')->where('staffid', $userid)->pluck('typegroupid')->toArray();
            $typeidsdays = DB::table('hcstaffdays')->where('staffid', $userid)->pluck('typegroupid')->toArray();
            $excludedtypegroupids = array_merge($typeidstakeon, $typeidsdays);

            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.groupid', $arr['staffgroup']->groupid)
                ->when(!empty($excludedtypegroupids), function ($query) use ($excludedtypegroupids) {
                    $query->whereNotIn('hctypegroup.id', $excludedtypegroupids);
                })->select('hcleavetype.description', 'hctypegroup.id')->get();*/
            return view('hc.manage.view-single-staff')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        }
    }
}
