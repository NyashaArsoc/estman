<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;


class SetupManageController extends Controller
{
    public function setbasecurrency()
    {
        $currencycode = $this->getcurrencycode();
        switch ($currencycode) {
            case 'failed':
                return  redirect()->route('setin.addcurr')
                    ->with('error', 'failed to load');
            default:
                $arr['currency'] = $currencycode;
                return view('setup.manage.set-base-currency')->with($arr);
        }
    }
    public function addnewbasecurrency(Request $request)
    {
        try {
            $codeexists = DB::table('setupcurrencybase')->where(
                'active',
                '=',
                'Y'
            )->select('code')->latest('id')->first();
            if ($codeexists && trim($codeexists->code) == $request->currencycode) {
                return redirect()->route('setman.addbasecurr')->with('error', 'Currency already exists');
            } else {
                DB::table('setupcurrencybase')->insert([
                    'code' => $request->currencycode,
                    'operatorid' => session('alluser')
                ]);

                return redirect()->route('setman.addbasecurr')->with('success', 'record added');
            }
        } catch (\Throwable $th) {
            return  redirect()->route('setman.addbasecurr')
                ->with('error', 'failed to load');
        }
    }
    function listleavegroups()
    {
        try {
            $arr['group'] = DB::table('hcleavegroups')->select('*')->get();
            return view('setup.manage.list-leave-group')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('dash.val');
        }
    }
    function disableleavegroup($id)
    {
        try {
            $entryid = Crypt::decrypt($id);
            try {
                DB::table('hcleavegroups')->where('id', $entryid)->update(['isactive' => 'N']);
                return  redirect()->route('setman.listlevgrp')
                    ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return  redirect()->route('setman.listlevgrp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('setman.listlevgrp')
                ->with('error', 'failed to load');
        }
    }
    function activateleavegroup($id)
    {
        try {
            $entryid = Crypt::decrypt($id);
            try {
                DB::table('hcleavegroups')->where('id', $entryid)->update(['isactive' => 'Y']);
                return  redirect()->route('setman.listlevgrp')
                    ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return  redirect()->route('setman.listlevgrp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('setman.listlevgrp')
                ->with('error', 'failed to load');
        }
    }
    function viewassignleavegrouptype($id)
    {
        try {
            $entryid = Crypt::decrypt($id);
            try {
                $arr['group'] = DB::table('hcleavegroups')->where('id', $entryid)->first();
                $arr['type'] = DB::table('hcleavetype')->select('*')->orderBy('description', 'asc')->get();
                $arr['typegroup'] = DB::table('hctypegroup')->where('groupid', $entryid)
                    ->select('typeid')->get();
                return view('setup.manage.assign-lev-type-group')
                    ->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('dash.setup')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('setman.listlevgrp')
                ->with('error', 'failed to load');
        }
    }
    function assigntypeleavegroup($id, Request $request)
    {
        try {
            $entryid = Crypt::decrypt($id);
            try {
                if (empty($request->ChangeRoleGroup)) {
                    // remove all 
                    DB::table('hctypegroup')->where('groupid', $entryid)
                        ->delete();
                    return  redirect()->route('setman.listlevgrp')
                        ->with('success', 'record added');
                } else {
                    // insert and remove if not in array
                    $numbers = count($request->ChangeRoleGroup);
                    $a       =       0;
                    while ($a < $numbers) {
                        $updaterolegroup = array(
                            'typeid' => $request->ChangeRoleGroup[$a],
                            'groupid'       => $entryid,
                            'operatorid' => session('alluser')
                        );
                        DB::table('hctypegroup')
                            ->updateOrInsert($updaterolegroup);
                        $a++;
                    }
                    DB::table('hctypegroup')->where('groupid', $entryid)
                        ->whereNotIn('typeid', $request->ChangeRoleGroup)->delete();
                    return  redirect()->route('setman.listlevgrp')
                        ->with('success', 'record added');
                }
            } catch (\Throwable $th) {
                return  redirect()->route('setman.viewassignlevtyp', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('setman.listlevgrp')
                ->with('error', 'failed to load');
        }
    }
    function listtypeperleavegroups($id)
    {
        try {
            $entryid = Crypt::decrypt($id);
            $arr['group'] = DB::table('hcleavegroups')->where('id', $entryid)->first();
            $arr['list'] = DB::table('hctypegroup')->select('hctypegroup.typeid', 'hctypegroup.groupid', 'hcleavetype.description')
                ->join('hcleavetype', 'hctypegroup.typeid', '=', 'hcleavetype.id')->where('hctypegroup.groupid', $entryid)->get();
            $arr['days'] = DB::table('hcleavegroupworkday')->where('groupid', $entryid)
                ->select('day')->get();
            // return $arr;
            return view('setup.manage.view-single-leave-group-type')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('dash.val');
        } catch (DecryptException $th) {
            return  redirect()->route('setman.listlevgrp')
                ->with('error', 'failed to load');
        }
    }
    function viewleavetypegroupconfig($tid, $gid)
    {
        try {
            $typeid = Crypt::decrypt($tid);
            $groupid = Crypt::decrypt($gid);
            $arr['typegroup'] = DB::table('hctypegroup')->where('groupid', $groupid)->where('typeid', $typeid)->first();
            $arr['group'] = DB::table('hcleavegroups')->where('id', $groupid)->first();
            $arr['type'] = DB::table('hcleavetype')->where('id', $typeid)->first();
            $arr['config'] = DB::table('hcgrouptypeconfig')->where('typegroupid', $arr['typegroup']->id)->first();

            return view('setup.manage.view-single-config-group-type')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('setman.typperlevgrp', $gid);
        } catch (DecryptException $th) {
            return  redirect()->route('setman.typperlevgrp', $gid)
                ->with('error', 'failed to load');
        }
    }
    function assignworkdayleavegroup($id, Request $request)
    {
        try {
            $entryid = Crypt::decrypt($id);
            if (empty($request->days)) {
                // remove all 
                DB::table('hcleavegroupworkday')->where('groupid', $entryid)
                    ->delete();
                return  redirect()->route('setman.typperlevgrp', $id)
                    ->with('success', 'record added');
            } else {
                // insert and remove if not in array
                $numbers = count($request->days);
                $a       =       0;
                while ($a < $numbers) {
                    $updategroup = array(
                        'day' => $request->days[$a],
                        'groupid'       => $entryid,
                        'operatorid' => session('alluser')
                    );
                    DB::table('hcleavegroupworkday')
                        ->updateOrInsert($updategroup);
                    $a++;
                }
                DB::table('hcleavegroupworkday')->where('groupid', $entryid)
                    ->whereNotIn('day', $request->days)->delete();
                return  redirect()->route('setman.typperlevgrp', $id)
                    ->with('success', 'record added');
            }
        } catch (\Throwable $th) {
            return redirect()->route('setman.typperlevgrp', $id)
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return  redirect()->route('setman.typperlevgrp', $id)
                ->with('error', 'failed to load');
        }
    }
    function createaccruedayleavegroup($id, $gid, Request $request)
    {
        try {
            $entryid = Crypt::decrypt($id);
            $request->validate(['daystoaccrue' => 'required', 'onmaxdays' => 'required',]);
            DB::table('hcgrouptypeconfig')->updateOrInsert(
                ['typegroupid' => $entryid],
                [
                    'days' => $request->daystoaccrue,
                    'operatorid' => session('alluser'),
                    'maxdays' => $request->maximundays,
                    'onmax' => $request->onmaxdays
                ]
            );

            return  redirect()->route('setman.typperlevgrp', $gid)
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('setman.typperlevgrp', $gid)
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return  redirect()->route('setman.typperlevgrp', $gid)
                ->with('error', 'failed to load');
        }
    }
}
