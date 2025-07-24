<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HCApprovalController extends Controller
{
    function listpendingapproval()
    {
        try {
            $myuser = $this->userdetail();
            $myrole = DB::table('systroles')->where('id', $myuser->roleid)->select('id')->first();
            $arr['application']   = DB::table('hcleaveapplication')->join('systusers', 'hcleaveapplication.staffid', '=', 'systusers.id')
                ->select(
                    'systusers.firstname',
                    'systusers.lastname',
                    'hcleaveapplication.id',
                    'hcleaveapplication.datefrom',
                    'hcleaveapplication.dateto',
                    'hcleaveapplication.daysapplied'
                )
                ->where('hcleaveapplication.routeto', $myrole->id)->where('hcleaveapplication.status', 'P')->get();

            return view('hc.approval.list-leave-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
    /*------------view single application---------- */
    function viewsingleapplication($id)
    {
        try {
            $applicationid = Crypt::decrypt($id);
            $arr['application']   = DB::table('hcleaveapplication')->where('id', $applicationid)->first();
            $arr['days']   = DB::table('hcstaffdays')->where('typegroupid', $arr['application']->hctypegroupid)
                ->where('staffid', $arr['application']->staffid)->first();
            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.id', $arr['application']->hctypegroupid)->select('hcleavetype.description')->first();
            $arr['staff']   = DB::table('systusers')->where('id', $arr['application']->staffid)->first();
            if (!$arr['typegroup']) {
                return redirect()->route('hcapp.listlev')
                    ->with('error', 'leave group no longer exist');
            }
            return view('hc.approval.view-single-application')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcapp.listlev')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcapp.listlev')
                ->with('error', 'failed to load');
        }
    }
    function apprpveingleapplication(Request $request, $id)
    {

        try {
            $applicationid = Crypt::decrypt($id);
            if ($request->has('approve')) {

                DB::table('hcleaveapplication')->where('id', $applicationid)
                    ->update([
                        'status' => 'C',
                        'approvedby' => session('alluser'),
                        'approvedon' => now(),
                        'firstapprovalcomments' => $request->commentshighlights
                    ]);
                return  redirect()->route('hcapp.listlev')
                    ->with('success', 'record approved');
            } elseif ($request->has('decline')) {
                DB::table('hcleaveapplication')->where('id', $applicationid)
                    ->update([
                        'status' => 'D',
                        'firstapprovalcomments' => $request->commentshighlights,
                        'approvedby' => session('alluser'),
                        'approvedon' => now()
                    ]);
                return redirect()->route('hcapp.listlev')
                    ->with('success', 'record declined');
            }
        } catch (\Throwable $th) {
            return redirect()->route('hcapp.listlev')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcapp.listlev')
                ->with('error', 'failed to load');
        }
    }
    function listpendingconfirmation()
    {
        try {
            $myuser = $this->userdetail();
            $myrole = DB::table('systroles')->where('id', $myuser->roleid)->select('id')->first();
            $arr['application']   = DB::table('hcleaveapplication')->join('systusers', 'hcleaveapplication.staffid', '=', 'systusers.id')
                ->select(
                    'systusers.firstname',
                    'systusers.lastname',
                    'hcleaveapplication.id',
                    'hcleaveapplication.datefrom',
                    'hcleaveapplication.dateto',
                    'hcleaveapplication.daysapplied'
                )->where('hcleaveapplication.status', 'C')->get();

            return view('hc.approval.list-leave-confirmation')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.hc');
        }
    }
    function viewsingleapplicationconfirm($id)
    {
        try {
            $applicationid = Crypt::decrypt($id);
            $arr['application']   = DB::table('hcleaveapplication')->where('id', $applicationid)->first();
            $arr['days']   = DB::table('hcstaffdays')->where('typegroupid', $arr['application']->hctypegroupid)
                ->where('staffid', $arr['application']->staffid)->first();
            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.id', $arr['application']->hctypegroupid)->select('hcleavetype.description')->first();
            $arr['staff']   = DB::table('systusers')->where('id', $arr['application']->staffid)->first();
            $arr['reportto']   = DB::table('systusers')->where('username', $arr['application']->approvedby)->first();
            if (!$arr['typegroup']) {
                return redirect()->route('hcapp.listlevcon')
                    ->with('error', 'leave group no longer exist');
            }
            return view('hc.approval.view-single-application-confirm')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('hcapp.listlevcon')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcapp.listlevcon')
                ->with('error', 'failed to load');
        }
    }
    function confirmsingleapplication(Request $request, $id)
    {
        try {
            $applicationid = Crypt::decrypt($id);
            $arr['myuser'] = $this->userdetail();
            $arr['application']   = DB::table('hcleaveapplication')->where('id', $applicationid)->first();
            $arr['days']   = DB::table('hcstaffdays')->where('typegroupid', $arr['application']->hctypegroupid)
                ->where('staffid', $arr['application']->staffid)->first();
            $arr['typegroup'] = DB::table('hctypegroup')->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')
                ->where('hctypegroup.id', $arr['application']->hctypegroupid)->first();
            $arr['staff']   = DB::table('systusers')->where('id', $arr['application']->staffid)->first();
            if ($request->has('decline')) {
                return 'decline';
            }
            return $request;
            //return 'here';
        } catch (\Throwable $th) {
            return redirect()->route('hcapp.viwsingappcon', $id)
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('hcapp.viwsingappcon', $id)
                ->with('error', 'failed to load');
        }
    }
}
function downloadattachments($path)
{
    try {
        $filename = Crypt::decrypt($path);
        //check the existance of receipt first
        if (!Storage::disk('public')->exists("documents/hc/leave/{$filename}")) {
            return abort(404);
        }
        return response()->download(storage_path("app/public/documents/hc/leave/{$filename}"));
    } catch (DecryptException $th) {
        return redirect()->route('dash.hc');
    }
}
