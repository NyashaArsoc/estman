<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;


class ValDeclinedController extends Controller
{

    function listalldeclinedacknowledgement()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValAcknowledgeNormalDeclined ');
            $port['portfolio'] = DB::select('EXEC spGetValInstAcknowledgePortfolioDeclined ');
            $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.declined.list-instruct-acknowledge')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleinstructionacknowledge($id, $instrid)
    {
        try {
            $acknowledgeid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();
                $arr['valuer'] = DB::select('EXEC spGetValValuers');
                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['acknow']   = DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
                    ->select('*')->first();
                $arr['properties']   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$arr['instr']->propertyid]
                ))->first();

                $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                    'N' => DB::table('valinstructions')->where('id', $instructionid)
                        ->select('*')->first(),
                    default => DB::table('valinstrportfolio')
                        ->where('id', $arr['instr']->portfolioid)
                        ->select('*')->first(),
                };
                $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                    'N' => DB::table('valclientcontactperson')->join(
                        'valclientdetail',
                        'valclientcontactperson.clientid',
                        '=',
                        'valclientdetail.id'
                    )
                        ->where('valclientcontactperson.id', $arr['instr']->contactid)
                        ->select(
                            'valclientdetail.companyname',
                            'valclientdetail.lastname',
                            'valclientdetail.firstname',
                            'valclientcontactperson.firstname As contactfirstname',
                            'valclientcontactperson.lastname As contactlastname',
                            'valclientcontactperson.cell',
                            'valclientcontactperson.email',
                            'valclientdetail.contactaddress'
                        )->first(),
                    default => DB::table('valclientcontactperson')->join(
                        'valclientdetail',
                        'valclientcontactperson.clientid',
                        '=',
                        'valclientdetail.id'
                    )
                        ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                        ->select(
                            'valclientdetail.companyname',
                            'valclientdetail.lastname',
                            'valclientdetail.firstname',
                            'valclientcontactperson.firstname As contactfirstname',
                            'valclientcontactperson.lastname As contactlastname',
                            'valclientcontactperson.cell',
                            'valclientcontactperson.email',
                            'valclientdetail.contactaddress'
                        )->first(),
                };
                return view('valuation.declined.view-single-instruct-acknowledge')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listacknw')
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('valdec.listackn')
                ->with('error', 'failed to load');
        }
    }
    function allocateinstructionacknowledge($id, $instrid, Request $request)
    {
        try {
            $acknowledgeid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $accessdatetime = Carbon::parse($request->accessdatetime);
                $valuer   = DB::table('systusers')->where('id', $request->valuername)->select('*')->first();
                DB::table('valinstructions')->where('id', $instructionid)
                    ->update(['operatorid' => session('alluser'), 'datedueaccessdate' => $accessdatetime, 'allocatedto' => $valuer
                        ->username, 'status' => 'P', 'datestamp' => now()]);
                DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
                    ->update(['operatorid' => session('alluser'), 'allocatedto' => $request
                        ->valuername, 'status' => 'P', 'datestamp' => now()]);
                return redirect()->route('valdec.listackn')
                    ->with('success', 'record confirmed');
            } catch (\Throwable $th) {
                return redirect()->route('valdec.listackn')
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('valdec.listackn')
                ->with('error', 'failed to load');
        }
    }
    /*

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
}*/
}
