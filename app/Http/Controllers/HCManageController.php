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
