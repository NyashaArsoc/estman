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
            $arr['myuser'] = $this->userdetail();
            $arr['staffgroup']   = DB::table('hcstaff')->where('hcstaff.staffid', $arr['myuser']->id)->first();
            $arr['myrole'] = DB::table('systroles')->where('id', $arr['myuser']->roleid)->select('*')->first();
            $arr['typegroup'] = DB::table('hcstaff')->join('hctypegroup', 'hcstaff.groupid', '=', 'hctypegroup.groupid')
                ->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')->where('hcstaff.staffid', $arr['myuser']->id)
                ->select('hcleavetype.description', 'hctypegroup.id as typegroupid', 'hcstaff.staffid', 'hcstaff.groupid')->get();
            return view('hc.intake.apply-leave')->with($arr);
        } catch (\Throwable $th) {
            return $th;
            return  redirect()->route('dash.hc');
        }
    }
    /*------------------------add leave days----------------*/
    function addleavedays()
    {
        try {
            /* $staffids = DB::table('hcstaff')->pluck('staffid');
            $arr['staff']   = DB::table('systusers')->where('isavailable', 'Y')->where('username', '!=', 'admin')
                ->whereIn('id', $staffids)->select('*')->get();*/
            $arr['staff']   = DB::table('hcstafftakeondays')->get();

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
            $arr['staffgroup']   = DB::table('hcstaff')->join('hcleavegroups', 'hcstaff.groupid', '=', 'hcleavegroups.id')
                ->where('hcstaff.staffid', $userid)->first();
            $typeidstakeon = DB::table('hctakeondays')->where('staffid', $userid)->pluck('typegroupid')->toArray();
            $typeidsdays = DB::table('hcstaffdays')->where('staffid', $userid)->pluck('typegroupid')->toArray();
            $excludedtypegroupids = array_merge($typeidstakeon, $typeidsdays);

            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.groupid', $arr['staffgroup']->groupid)
                ->when(!empty($excludedtypegroupids), function ($query) use ($excludedtypegroupids) {
                    $query->whereNotIn('hctypegroup.id', $excludedtypegroupids);
                })->select('hcleavetype.description', 'hctypegroup.id')->get();
            return view('hc.intake.add-day-stafflist-type')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.addday')
                ->with('error', 'failed to load');
        }
    }
    function addtypedaytouser($id, $uid)
    {
        try {
            $typegroupid    = Crypt::decrypt($id);
            $userid         = Crypt::decrypt($uid);
            $arr['staff']   = DB::table('systusers')->where('id', $userid)->first();
            $arr['staffgroup']   = DB::table('hcstaff')->join('hcleavegroups', 'hcstaff.groupid', '=', 'hcleavegroups.id')
                ->where('hcstaff.staffid', $userid)->first();
            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.id', $typegroupid)->select('hcleavetype.description', 'hctypegroup.id')->first();
            return view('hc.intake.add-takeon-type-staff-day')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcin.lstgrpusr', $uid)
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.lstgrpusr', $uid)
                ->with('error', 'failed to load');
        }
    }
    function staffaddtakeonbalances($id, $tid, Request $request)
    {
        try {
            $typegroupid    = Crypt::decrypt($tid);
            $userid         = Crypt::decrypt($id);
            DB::table('hctakeondays')->insert([
                'staffid' => $userid,
                'typegroupid' => $typegroupid,
                'days' => $request->takeondays,
                'operatorid' => session('alluser')
            ]);
            return redirect()->route('hcin.lstgrpusr',  $id)
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('hcin.daytotyp', [$tid, $id])
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.daytotyp', [$tid, $id])
                ->with('error', 'failed to load');
        }
    }
    function getdaysavailable($uid, $tid)
    {
        try {
            $arr['days']   = DB::table('hcstaffdays')->where('typegroupid', $tid)
                ->where('staffid', $uid)->first();
            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.id', $tid)->select('hcleavetype.description', 'hctypegroup.id')->first();
            return view('hc.intake.get-single-staff-days')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcin.applev')
                ->with('error', 'failed to load');
        }
    }
    /*-------------apply leave */
    function createleave(Request $request, $uid, $rid)
    {
        try {
            $request->validate([
                'dateto' => 'required',
                'datefrom' => 'required',
            ]);
            $userid         = Crypt::decrypt($uid);
            $routeto         = Crypt::decrypt($rid);
            $typegroup   = DB::table('hctypegroup')->where('id', $request->leavegroup)->first();

            DB::table('hcleaveapplication')->insert([
                'daysapplied' => $request->daysapplied,
                'daysavailable' => $request->daysavailable,
                'comments' => $request->commentshighlights,
                'dateto' => $request->dateto,
                'datefrom' => $request->datefrom,
                'attachments' => $request->leaveattachment,
                'operatorid' => session('alluser'),
                'hctypegroupid' => $request->leavegroup,
                'staffid' => $userid,
                'groupid' => $typegroup->groupid,
                'typeid' => $typegroup->typeid,
                'routeto' => $routeto
            ]);
            return redirect()->route('hcin.applev')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('hcin.applev')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcin.applev')
                ->with('error', 'failed to load');
        }
    }
    /*----------take working days------------------ */
    function getgroupworkingdays($gid)
    {
        $workdays = DB::table('hcleavegroupworkday')->where('groupid', $gid)->pluck('day')
            ->map(function ($day) {
                return trim($day);
            });
        $holidays = DB::table('hcholiday')->pluck('holidaydate')
            ->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            });
        return response()->json(['workdays' => $workdays, 'holidays' => $holidays]);
    }
}
