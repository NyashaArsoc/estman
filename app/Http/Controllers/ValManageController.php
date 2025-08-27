<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ValManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['loginauth']);
    }
    public function listallclient()
    {
        try {
            $arr['client'] = DB::table('valclientdetail')
                ->join('setupclienttype', 'setupclienttype.id', '=', 'valclientdetail.clienttypeid')
                ->select('setupclienttype.description', 'valclientdetail.*')->get();
            return view('valuation.manage.list-client')->with($arr);
        } catch (\Throwable $th) {
            return $th;
            return  redirect()->route('dash.val')
                ->with('error', 'failed to load');
        }
    }
    public function editsingleclient($id)
    {
        try {
            $clientid = Crypt::decrypt($id);
            try {
                $arr['client'] = DB::table('valclientdetail')->where('valclientdetail.id', $clientid)
                    ->join('setupclienttype', 'setupclienttype.id', '=', 'valclientdetail.clienttypeid')
                    ->select('setupclienttype.description', 'valclientdetail.*')->first();
                $arr['contact'] = DB::table('valclientcontactperson')->where('clientid', $clientid)
                    ->select('*')->get();
                return view('valuation.manage.edit-single-client')->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('valman.listclient')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('valman.listclient')
                ->with('error', 'failed to load');
        }
    }
    public function viewsingleclient($id)
    {
        try {
            $clientid = Crypt::decrypt($id);
            try {
                $arr['client'] = DB::table('valclientdetail')->where('valclientdetail.id', $clientid)
                    ->join('setupclienttype', 'setupclienttype.id', '=', 'valclientdetail.clienttypeid')
                    ->select('setupclienttype.description', 'valclientdetail.*')->first();
                $arr['contact'] = DB::table('valclientcontactperson')->where('clientid', $clientid)
                    ->select('*')->get();
                return view('valuation.manage.view-single-client')->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('valman.listclient')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('valman.listclient')
                ->with('error', 'failed to load');
        }
    }
    function editsingleclientcontact($id, $cid)
    {
        try {
            $clientid = Crypt::decrypt($id);
            $contactid = Crypt::decrypt($cid);
            try {
                $arr['client'] = DB::table('valclientdetail')->where('valclientdetail.id', $clientid)
                    ->join('setupclienttype', 'setupclienttype.id', '=', 'valclientdetail.clienttypeid')
                    ->select('setupclienttype.description', 'valclientdetail.*')->first();
                $arr['contact'] = DB::table('valclientcontactperson')->where('id', $contactid)
                    ->select('*')->first();
                return view('valuation.manage.edit-single-client-contact')->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('valman.editclient', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('valman.editclient', $id)
                ->with('error', 'failed to load');
        }
    }
    function updateclientdetails($id, Request $request)
    {
        try {
            $clientid = Crypt::decrypt($id);
            try {
                DB::table('valclientdetail')->where('id', $clientid)
                    ->update([
                        'companyname' => $request->companyname,
                        'cell' => $request->cell,
                        'tel' => $request->tel,
                        'email' => $request->email,
                        'contactaddress' => $request->billingaddress,
                        'lastname' =>
                        $request->lastname,
                        'firstname' => $request->firstname
                    ]);
                return  redirect()->route('valman.listclient')
                    ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return redirect()->route('valman.editclient', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valman.editclient', $id)
                ->with('error', 'failed to load');
        }
    }
    function updatesingleclientcontact($id, $cid, Request $request)
    {
        try {
            $contactid = Crypt::decrypt($cid);
            try {
                DB::table('valclientcontactperson')->where('id', $contactid)
                    ->update([
                        'firstname' => $request->contactfirstname,
                        'cell' => $request->contactcell,
                        'email' => $request->contactemail,
                        'lastname' => $request->contactlastname
                    ]);
                return  redirect()->route('valman.editclient', $id)
                    ->with('success', 'record updated');
            } catch (\Throwable $th) {
                return redirect()->route('valman.editclient', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valman.editclient', $id)
                ->with('error', 'failed to load');
        }
    }
    /*-----------list all instructions ------------- */
    function listallinstructions()
    {
        try {
            $arr['stage']    = DB::select('EXEC spGetValInstructionStages');
            return view('valuation.manage.list-instructions')->with($arr);
        } catch (\Throwable $th) {
            return $th;
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleinstructionstage($id)
    {
        try {
            $instructionid = Crypt::decrypt($id);
            $arr['instruction'] = DB::select('EXEC spGetValSingleInstructionStage ?', [$instructionid]);
            $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                ->select('*')->first();
            $arr['client'] = $this->getvaluationclient(
                $arr['instr']->isportfolio,
                $arr['instr']->contactid,
                $instructionid,
                $arr['instr']->portfolioid
            );
            $arr['upload']   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                ->select('*')->first();
            return view('valuation.manage.view-instruction-stage')->with($arr);
        } catch (DecryptException $th) {
            return  redirect()->route('valman.listinstr')
                ->with('error', 'failed to load');
        }
    }
}
