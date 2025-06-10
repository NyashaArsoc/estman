<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ValApprovalController extends Controller
{
    function listallinstructionacknowledge()
    {
        try {
            $user = $this->userdetail();
            $nom['normal'] = DB::select('EXEC spGetValInstAcknowledgeNormal ?', [$user->id]);
            $port['portfolio'] = DB::select('EXEC spGetValInstAcknowledgePortfolio ?', [$user->id]);
            $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruction-acknowledge')->with($arr);
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
                return view('valuation.approval.view-single-instruct-acknowledge')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listacknw')
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listacknw')
                ->with('error', 'failed to load');
        }
    }
    function confirmacknowledgement($id, $instr_id, $to_id)
    {
        try {
            $acknowledgeid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            $allocatedid = Crypt::decrypt($to_id);
            try {
                $user = $this->userdetail();
                $typeid =  DB::table('valinstructions')->join(
                    'valclientproperty',
                    'valinstructions.propertyid',
                    '=',
                    'valclientproperty.id'
                )
                    ->where('valinstructions.id', $instructionid)
                    ->select('valclientproperty.propertytypeid')->first();
                $minsexpected =  DB::table('valinstrexpectedmins')->where('propertytypeid', $typeid->propertytypeid)
                    ->select('*')->first();
                $datestamp =     DB::table('valinstrcompile')->where('allocatedto', $user->id)
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();
                $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
                //check if due date is current or old
                $currentdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
                $datedue = Carbon::parse($currentdatedue)->addMinutes((int)$minsexpected->minsexpectedtocompile);
                DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
                    ->update(['completedby' => session('alluser'), 'status' => 'C', 'completedon' => now()]);
                DB::table('valinstrcompile')->insert(['instructionid' => $instructionid, 'operatorid' =>
                session('alluser'), 'allocatedto' => $allocatedid, 'datedue' => $datedue]);
                return redirect()->route('valapp.listacknw')
                    ->with('success', 'record confirmed');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listacknw')
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listacknw')
                ->with('error', 'failed to load');
        }
    }
    function declineacknowledgement($id, $instr_id, Request $request)
    {
        try {
            $acknowledgeid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            try {
                DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
                    ->update(['comments' => $request->reasonsfordecline, 'status' => 'D', 'completedon' => now(), 'completedby' => session('alluser')]);
                DB::table('valinstructions')->where('id', $instructionid)
                    ->update(['status' => 'declined', 'completedon' => now()]);
                return redirect()->route('valapp.listacknw')
                    ->with('success', 'instruction declined');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listacknw')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listacknw')
                ->with('error', 'failed to load');
        }
    }
    /*--------------------------------report compilation -------------------------*/
    function listallinstructioncompile()
    {
        try {
            $user = $this->userdetail();
            $nom['normal'] = DB::select('EXEC spGetValInstCompileNormal ?', [$user->id]);
            $port['portfolio'] = DB::select('EXEC spGetValInstCompilePortfolio ?', [$user->id]);
            $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-compile')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleinstructioncompile($id, $instrid)
    {
        try {
            $compileid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();
                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['acknow']   = DB::table('valinstrcompile')->where('id', $compileid)
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
                return view('valuation.approval.view-single-instruct-compilation')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listcomp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listcomp')
                ->with('error', 'failed to load');
        }
    }
    function submitcompilation(Request $request, $id, $instr_id, $propid)
    {
        try {
            $compileid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            $propertyid = Crypt::decrypt($propid);
            try {
                $request->validate([
                    'reportdocument' => 'required',
                    'reportschedule' => 'required',
                ]);
                $properties   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$propertyid]
                ))->first();
                //checking if the attachment is there 
                if ($request->hasFile('reportdocument')) {
                    $reportdoc = $request->file('reportdocument');
                    $reportdocname = $properties->streetaddress . '.' . $reportdoc->getClientOriginalExtension();
                    $reportdoc->storeAs('public/documents/valuation/doc', $reportdocname);
                } else {
                    $reportdocname = '';
                }

                if ($request->hasFile('reportschedule')) {
                    $reportexcel = $request->file('reportschedule');
                    $reportexcelname = $properties->streetaddress . '.' . $reportexcel->getClientOriginalExtension();
                    $reportexcel->storeAs('public/documents/valuation/excel', $reportexcelname);
                } else {
                    $reportexcelname = '';
                }

                $datestamp =     DB::table('valinstrqualitycheck')
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();
                $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
                //check if due date is current or old
                $currentdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
                $datedue = Carbon::parse($currentdatedue)->addMinutes(60);
                DB::table('valinstrcompile')->where('id', $compileid)
                    ->update([
                        'completedby' => session('alluser'),
                        'status' => 'C',
                        'completedon' => now(),
                        'marketvalue' => $request->marketvalue,
                        'grc' => $request->grc,
                        'forcedsale' => $request->forcedsalestimate,
                        'depreciation' => $request->depreciationvalue,
                        'rentalvalue' => $request->rentalvalue,
                        'landvalue'
                        => $request->landvalue,
                        'drc' => $request->drc,
                        'fairvalue' => $request->fairvalue,
                        'comments' =>
                        $request->commentshighlights
                    ]);
                DB::table('valclientproperty')->where('id', $propertyid)
                    ->update(['standnumber' => $request->standnumber]);

                DB::table('valinstrqualitycheck')->insert(['instructionid' => $instructionid, 'operatorid' =>
                session('alluser'), 'datedue' => $datedue]);
                DB::table('valinstruploads')->insert(['instructionid' => $instructionid, 'reportdoc' =>
                $reportdocname, 'reportexcel' => $reportexcelname]);
                return redirect()->route('valapp.listcomp')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listcomp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listcomp')
                ->with('error', 'failed to load');
        }
    }
    function listallinstructionqualitycheck()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValInstQualityNormal');
            $port['portfolio'] = DB::select('EXEC spGetValInstQualityPortfolio');
            $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-quality-check')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsinglequalitycheck($id, $instrid)
    {
        try {
            $qualityid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();

                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid', $instructionid)
                    ->select('*')->orderBy('id', 'desc')->first();;
                $arr['currstage']   = DB::table('valinstrqualitycheck')->where('id', $qualityid)
                    ->select('*')->first();
                $arr['properties']   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$arr['instr']->propertyid]
                ))->first();
                $arr['upload']   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();

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
                return view('valuation.approval.view-single-instruct-quality-check')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listquality')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listquality')
                ->with('error', 'failed to load');
        }
    }
    function downloadreportword($instr_id)
    {
        try {
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $upload   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();
            } catch (\Throwable $th) {
                return redirect()->route('dash.val');
            }
            if ($upload->reportdoc == '' || is_null($upload->reportdoc)) {
                return abort(400);
            }
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/valuation/doc/{$upload->reportdoc}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/valuation/doc/{$upload->reportdoc}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.val');
        }
    }
    function downloadreportexcel($instr_id)
    {
        try {
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $upload   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();
            } catch (\Throwable $th) {
                return redirect()->route('dash.val');
            }
            if ($upload->reportexcel == '' || is_null($upload->reportexcel)) {
                return abort(400);
            }
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/valuation/excel/{$upload->reportexcel}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/valuation/excel/{$upload->reportexcel}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.val');
        }
    }
    function submitqualitycheck(Request $request, $id, $instr_id)
    {
        try {
            $qualityid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $request->validate([
                    'reportdocument' => 'required',
                ]);
                $instructiontype = DB::table('valinstructions')->where('id', $instructionid)->select('*')->first();
                $filename   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('reportdoc')->first();
                if (!is_null($filename)) {
                    $this->deletereportdoc($filename->reportdoc);
                }
                if ($request->hasFile('reportdocument')) {
                    $reportdoc = $request->file('reportdocument');
                    $reportdocname = $request->propertyaddress . '.' . $reportdoc->getClientOriginalExtension();
                    $reportdoc->storeAs('public/documents/valuation/doc', $reportdocname);
                } else {
                    $reportdocname = null;
                }

                $isprint = (is_null($request->isprintreport)) ? 'N' : 'Y';

                $approvaldatestamp =     DB::table('valinstrfinalapproval')
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();
                $invoicedatestamp =     DB::table('valinstrinvoicing')
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();

                $newapprovaldatestamp = is_null($approvaldatestamp) ? now() : $approvaldatestamp->datedue;
                $newinvoicedatestamp  = is_null($invoicedatestamp) ? now() : $invoicedatestamp->datedue;

                $newapprovalcurrentdatedue = $newapprovaldatestamp <= now() ? now() : $newapprovaldatestamp;
                $approvaldatedue = Carbon::parse($newapprovalcurrentdatedue)->addMinutes(60);
                $newinvoicedapprovalcurrentdatedue = $newinvoicedatestamp <= now() ? now() : $newinvoicedatestamp;
                $invoicedatedue = Carbon::parse($newinvoicedapprovalcurrentdatedue)->addMinutes(60);

                DB::table('valinstrqualitycheck')->where('id', $qualityid)
                    ->update([
                        'completedby' => session('alluser'),
                        'status' => 'C',
                        'completedon' => now(),
                        'comments' => $request->commentshighlights
                    ]);
                /*-------------------check if portfolio dont put to invoice-------------------- */

                if (trim($instructiontype->isportfolio) == 'N') {
                    DB::table('valinstrinvoicing')->insert(['instructionid' => $instructionid, 'operatorid' =>
                    session('alluser'), 'datedue' => $invoicedatedue]);
                }

                DB::table('valinstrfinalapproval')->insert(['instructionid' => $instructionid, 'operatorid' =>
                session('alluser'), 'datedue' => $approvaldatedue, 'isprint' => $isprint]);

                DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->update(['reportdoc' => $reportdocname]);

                return redirect()->route('valapp.listquality')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listquality')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listquality')
                ->with('error', 'failed to load');
        }
    }
    function deletereportdoc($filename)
    {
        //check the existance of receipt first
        if (Storage::disk('public')->exists("documents/valuation/doc/{$filename}")) {
            Storage::disk('public')->delete("documents/valuation/doc/{$filename}");
            return 'success';
        } else {
            return 'notfound';
        }
    }
    /*----------------------report approval----------------------------------*/
    function listallinstructionfinalapproval()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValInstFinalApprovalNormal');
            $port['portfolio'] = DB::select('EXEC spGetValInstFinalApprovalPortfolio');
            $arr['stage'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-final-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleinstructionapproval($id, $instr_id)
    {
        try {
            $approvalid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();
                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid', $instructionid)
                    ->select('*')->orderBy('id', 'desc')->first();
                $arr['currstage']   = DB::table('valinstrfinalapproval')->where('id', $approvalid)
                    ->select('*')->first();
                $arr['properties']   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$arr['instr']->propertyid]
                ))->first();
                $arr['upload']   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();

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
                return view('valuation.approval.view-single-instruct-final-approval')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listreportapp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listreportapp')
                ->with('error', 'failed to load');
        }
    }
    function submitreportapproval(Request $request, $id, $instr_id)
    {
        try {
            $approvalid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $request->validate([
                    'reportdocument' => 'required',
                ]);
                $filename   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('reportdoc')->first();
                if (!is_null($filename)) {
                    $this->deletereportdoc($filename->reportdoc);
                }
                if ($request->hasFile('reportdocument')) {
                    $reportdoc = $request->file('reportdocument');
                    $reportdocname = $request->propertyaddress . '.' . $reportdoc->getClientOriginalExtension();
                    $reportdoc->storeAs('public/documents/valuation/doc', $reportdocname);
                } else {
                    $reportdocname = null;
                }

                $datestamp =     DB::table('valinstrprinting')
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();
                $compileid =     DB::table('valinstrcompile')
                    ->where('instructionid', $instructionid)->select('id')->orderBy('id', 'desc')->first();
                $isprint     =     DB::table('valinstrfinalapproval')->where('id', $approvalid)
                    ->select('*')->first();
                $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
                $newdatestampdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
                $datedue = Carbon::parse($newdatestampdatedue)->addMinutes(60);


                if (trim($isprint->isprint) == 'Y') {
                    DB::table('valinstrprinting')->insert(['instructionid' => $instructionid, 'operatorid' =>
                    session('alluser'), 'datedue' => $datedue]);
                }
                DB::table('valinstrsendingreport')->insert(['instructionid' => $instructionid, 'operatorid' =>
                session('alluser'), 'datedue' => $datedue]);

                DB::table('valinstrcompile')->where('id', $compileid->id)
                    ->update(['marketvalue' => $request->marketvalue, 'grc' => $request->grc, 'forcedsale' =>
                    $request->forcedsalestimate, 'depreciation' => $request->depreciationvalue, 'rentalvalue' =>
                    $request->rentalvalue, 'landvalue' => $request->landvalue, 'drc' => $request->drc, 'fairvalue' =>
                    $request->fairvalue]);

                DB::table('valinstrfinalapproval')->where('id', $approvalid)
                    ->update([
                        'completedby' => session('alluser'),
                        'status' => 'C',
                        'completedon' => now()
                    ]);
                DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->update(['reportdoc' => $reportdocname]);
                DB::table('valinstructions')->where('id', $instructionid)
                    ->update(['status' => 'C']);

                return redirect()->route('valapp.listreportapp')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listreportapp')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listreportapp')
                ->with('error', 'failed to load');
        }
    }
    /*------------printing reports-----------------------------*/
    function listallinstructionprinting()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValInstPrintNormal');
            $port['portfolio'] = DB::select('EXEC spGetValInstPrintPortfolio');
            $arr['stage'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-printing')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleintructionprint($id, $instrid)
    {
        try {
            $printid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();
                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid', $instructionid)
                    ->select('*')->orderBy('id', 'desc')->first();
                $arr['currstage']   = DB::table('valinstrprinting')->where('id', $printid)
                    ->select('*')->first();
                $arr['properties']   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$arr['instr']->propertyid]
                ))->first();
                $arr['upload']   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();

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
                return view('valuation.approval.view-single-printing')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listallprint')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listallprint')
                ->with('error', 'failed to load');
        }
    }
    function submitprinting(Request $request, $id, $instr_id)
    {
        try {
            $printid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instr_id);
            try {
                $datestamp =     DB::table('valinstrdispatch')
                    ->where('status', '=', 'P')->select('*')->orderBy('id', 'desc')->first();
                $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
                $newdatestampdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
                $datedue = Carbon::parse($newdatestampdatedue)->addMinutes(60);
                DB::table('valinstrprinting')->where('id', $printid)
                    ->update([
                        'completedby' => session('alluser'),
                        'status' => 'C',
                        'completedon' => now()
                    ]);
                DB::table('valinstrdispatch')->insert(['instructionid' => $instructionid, 'operatorid' =>
                session('alluser'), 'datedue' => $datedue]);
                return redirect()->route('valapp.listallprint')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listallprint')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listallprint')
                ->with('error', 'failed to load');
        }
    }
    /*------------- report invoicing ----------------- */
    function listallinstructioninvoicing()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValInstInvoicingNormal');
            $port['portfolio'] = DB::select('EXEC spGetValInstInvoicingPortfolio');
            $arr['stage'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-invoicing')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function viewsingleinvoicingportfolio($id)
    {
        try {
            $portfolio = Crypt::decrypt($id);
            try {
                $arr['currency']   = DB::table('setupcurrency')->select('id', 'code')->get();
                $arr['instr']   = DB::table('valinstrlistportfolio')->where('id', $portfolio)
                    ->select('*')->first();
                return view('valuation.approval.view-single-invoicing-portfolio')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listinvoices')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listinvoices')
                ->with('error', 'failed to load');
        }
    }
    function submitinvoicingportfolio(Request $request, $id)
    {
        try {
            $portfolioid = Crypt::decrypt($id);
            try {
                DB::table('valinstrinvoicingportfolio')->where('portfolioid', $portfolioid)
                    ->update(['completedby' => session('alluser'), 'status' => 'C', 'completedon'
                    => now(), 'currencycode' => $request->currencycode, 'amountinvoiced' => $request->invoicedamount]);

                return redirect()->route('valapp.listinvoices')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listinvoices')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listinvoices')
                ->with('error', 'failed to load');
        }
    }
    function viewsinglenormalinvoicing($id, $instrid)
    {
        try {
            $printid = Crypt::decrypt($id);
            $instructionid = Crypt::decrypt($instrid);
            try {
                $arr['type']   = DB::table('setupclienttype')->select('*')->get();
                $arr['instr']   = DB::table('valinstructions')->where('id', $instructionid)
                    ->select('*')->first();
                $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid', $instructionid)
                    ->select('*')->orderBy('id', 'desc')->first();
                $arr['currstage']   = DB::table('valinstrinvoicing')->where('id', $printid)
                    ->select('*')->first();
                $arr['properties']   = collect(DB::select(
                    'EXEC spGetValInstrSingleProperty ?',
                    [$arr['instr']->propertyid]
                ))->first();
                $arr['upload']   = DB::table('valinstruploads')->where('instructionid', $instructionid)
                    ->select('*')->first();

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
                $arr['currency']   = DB::table('setupcurrency')
                    ->select('id', 'code')->get();
                return view('valuation.approval.view-single-invoicing')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listinvoices')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listinvoices')
                ->with('error', 'failed to load');
        }
    }
    function submitinvoicingnormal(Request $request, $id)
    {
        try {
            $invoiceid = Crypt::decrypt($id);
            try {
                DB::table('valinstrinvoicing')->where('id', $invoiceid)
                    ->update(['completedby' => session('alluser'), 'status' => 'C', 'completedon'
                    => now(), 'currencycode' => $request->currencycode, 'amountinvoiced' => $request->invoicedamount]);

                return redirect()->route('valapp.listinvoices')
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('valapp.listinvoices')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('valapp.listinvoices')
                ->with('error', 'failed to load');
        }
    }
    /*--------------------dispatch ----------------*/
    function listallinstructionpendingdispatch()
    {
        try {
            $nom['normal'] = DB::select('EXEC spGetValInstDispatchNormal');
            $port['portfolio'] = DB::select('EXEC spValGetInstDispatchPortfolio');
            $arr['stage'] = array_merge($nom['normal'], $port['portfolio']);
            return view('valuation.approval.list-instruct-dispatch')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    /*
public function __construct(){
     $this->middleware(['loginauth']);
}

public function listallinstructionacknowledgement(){
    try {
        $user = $this->userdetail();
        $nom['normal'] = DB::select('EXEC spValGetInstAcknowledgeNormal ?',[$user->id]);
        $port['portfolio'] = DB::select('EXEC spValGetInstAcknowledgePortfolio ?',[$user->id]);
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);  
        return view('val.approval.list-instruct-acknowledge')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
    
}
public function viewsingleacknowledge($id,$instrid){
    try {
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['acknow']   = DB::table('valinstracknowledgement')->where('id',$acknowledgeid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
             return view('val.approval.view-single-instruct-acknowledge-port')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
    
}
public function declineacknowledgement(Request $request,$id,$instr_id){
    try{
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
            DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
            ->update(['comments' => $request->reasonsfordecline,'status' => 'D']);
            DB::table('valinstructions')->where('id', $instructionid)
            ->update(['status' => 'declined','completedon' => now()]);
            return redirect()->route('valapp.listackn')
            ->with('success', 'instruction declined');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
}
public function acceptacknowledgement($id,$instr_id,$to_id){
    try{
        $acknowledgeid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        $allocatedid = Crypt::decrypt($to_id);
        try{
            $user = $this->userdetail();
            $typeid =  DB::table('valinstructions')->join('valclientproperty', 
            'valinstructions.propertyid','=', 'valclientproperty.id')
            ->where('valinstructions.id', $instructionid)
                ->select('valclientproperty.propertytypeid') ->first();
            $minsexpected =  DB::table('valinstrexpectedmins')->where('propertytypeid', $typeid->propertytypeid)
            ->select('*') ->first();
        $datestamp =     DB::table('valinstrcompile')->where('allocatedto', $user->id)
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
        //check if due date is current or old
        $currentdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
        $datedue = Carbon::parse($currentdatedue)->addMinutes($minsexpected->minsexpectedtocompile);
        DB::table('valinstracknowledgement')->where('id', $acknowledgeid)
        ->update(['completedby' => session('alluser'),'status' => 'C','completedon' => now()]);
        DB::table('valinstrcompile') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'allocatedto'=>$allocatedid,'datedue'=>$datedue]);
            return redirect()->route('valapp.listackn')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listackn')
        ->with('error', 'failed to load');
    }
}
/*-----------instruction compilation--------------*/
    /*
public function listallinstructioncompile(){
    try {
        $user = $this->userdetail();
        $nom['normal'] = DB::select('EXEC spValGetInstCompileNormal ?',[$user->id]);
        $port['portfolio'] = DB::select('EXEC spValGetInstCompilePortfolio ?',[$user->id]);
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']);  
        return view('val.approval.list-instruct-compile')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglecompile($id,$instrid){
    try {
        $compileid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['acknow']   = DB::table('valinstrcompile')->where('id',$compileid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
            return view('val.approval.view-single-instruct-compilation')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
    }
}
public function submitcompilation(Request $request,$id,$instr_id,$propid){
    try{
        $compileid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        $propertyid = Crypt::decrypt($propid);
        try{
            $request->validate([
                'reportdocument' => 'required',
                'reportschedule' => 'required',
            ]);
            $properties   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$propertyid]))->first();
            //checking if the attachment is there 
            if ($request->hasFile('reportdocument')) {
                $reportdoc = $request->file('reportdocument');
                $reportdocname = $properties->streetaddress . '.' . $reportdoc->getClientOriginalExtension();
                $reportdoc->storeAs('public/documents/val/doc', $reportdocname);
            }else{$reportdocname = '';}

            if ($request->hasFile('reportschedule')) {
                $reportexcel = $request->file('reportschedule');
                $reportexcelname = $properties->streetaddress . '.' . $reportexcel->getClientOriginalExtension();
                $reportexcel->storeAs('public/documents/val/excel', $reportexcelname);
            }else{$reportexcelname = '';}

        $datestamp =     DB::table('valinstrqualitycheck')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
        //check if due date is current or old
        $currentdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
        $datedue = Carbon::parse($currentdatedue)->addMinutes(60);
        DB::table('valinstrcompile')->where('id', $compileid)
        ->update(['completedby' => session('alluser'),'status' => 'C','completedon' => now(),
        'marketvalue'=>$request->marketvalue,'grc'=>$request->grc,'forcedsale'=>$request->forcedsalestimate,
        'depreciation' =>$request->depreciationvalue,'rentalvalue'=>$request->rentalvalue,'landvalue'
        =>$request->landvalue,'drc'=>$request->drc,'fairvalue'=>$request->fairvalue,'comments'=>
        $request->commentshighlights]);
        DB::table('valclientproperty')->where('id', $propertyid)
        ->update(['standnumber'=>$request->standnumber]);
       
        DB::table('valinstrqualitycheck') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$datedue]);
        DB::table('valinstruploads') ->insert(['instructionid'=>$instructionid,'reportdoc'=>
        $reportdocname,'reportexcel'=>$reportexcelname]);
            return redirect()->route('valapp.listcomp')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listcomp')
        ->with('error', 'failed to load');
    }
}
/*quality check */
    /*
public function listallinstructionqualitycheck(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstQualityNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstQualityPortfolio');
        $arr['acknow'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-quality-check')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglequalitycheck($id,$instrid){
try {
    $qualityid = Crypt::decrypt($id);
    $instructionid = Crypt::decrypt($instrid);
    try {
        $arr['type']   = DB::table('clienttype')
            ->select('id','description')->get();
        $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
            ->select('*')->first();
        $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
            ->select('*')->orderBy('id', 'desc')->first();;
        $arr['currstage']   = DB::table('valinstrqualitycheck')->where('id',$qualityid)
            ->select('*')->first();
        $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
        ,[$arr['instr']->propertyid]))->first();
        $arr['upload']   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('*')->first();
    
        $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
            'N' => DB::table('valinstructions') ->where('id', $instructionid)
                ->select('*') ->first(),
            default => DB::table('valinstrportfolio')
                ->where('id', $arr['instr']->portfolioid)
                ->select('*')->first(),
        };
        $arr['client'] = match (trim($arr['instr']->isportfolio)) {
            'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
            'valclientcontactperson.clientid','=', 'valclientdetail.id')
            ->where('valclientcontactperson.id', $arr['instr']->contactid)
                ->select('valclientdetail.companyname','valclientdetail.lastname',
                'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            default => DB::table('valclientcontactperson')->join('valclientdetail', 
            'valclientcontactperson.clientid','=', 'valclientdetail.id')
            ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                ->select('valclientdetail.companyname','valclientdetail.lastname',
                'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
        };
        return view('val.approval.view-single-instruct-quality-check')->with($arr);
    } catch (\Throwable $th) {
        return redirect()->route('valapp.listquality')
    ->with('error', 'failed to load');
    }
} catch (DecryptException $th) {
return redirect()->route('valapp.listquality')
    ->with('error', 'failed to load');
}
}
public function submitqualitycheck(Request $request,$id,$instr_id){
    try{
        $qualityid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
            $request->validate([
                'reportdocument' => 'required',
            ]);
            $instructiontype = DB::table('valinstructions') ->where('id', $instructionid)->select('*') ->first();
            $filename   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('reportdoc')->first();
            if (!is_null($filename)) {
             $this->deletereportdoc($filename->reportdoc);
            }
            if ($request->hasFile('reportdocument')) {
                $reportdoc = $request->file('reportdocument');
                $reportdocname = $request->propertyaddress . '.' . $reportdoc->getClientOriginalExtension();
                $reportdoc->storeAs('public/documents/val/doc', $reportdocname);
            }else{$reportdocname = null;}

        $isprint = (is_null($request->isprintreport)) ? 'N' : 'Y' ;
           
        $approvaldatestamp =     DB::table('valinstrfinalapproval')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $invoicedatestamp =     DB::table('valinstrinvoicing')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();

        $newapprovaldatestamp = is_null($approvaldatestamp) ? now() : $approvaldatestamp->datedue;
        $newinvoicedatestamp  = is_null($invoicedatestamp) ? now() : $invoicedatestamp->datedue;
     
        $newapprovalcurrentdatedue = $newapprovaldatestamp <= now() ? now() : $newapprovaldatestamp;
        $approvaldatedue = Carbon::parse($newapprovalcurrentdatedue)->addMinutes(60);
        $newinvoicedapprovalcurrentdatedue = $newinvoicedatestamp <= now() ? now() : $newinvoicedatestamp;
        $invoicedatedue = Carbon::parse($newinvoicedapprovalcurrentdatedue)->addMinutes(60);

        DB::table('valinstrqualitycheck')->where('id', $qualityid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now(),'comments'=>$request->commentshighlights]);
       /*-------------------check if portfolio dont put to invoice-------------------- */
    /*
        if (trim($instructiontype->isportfolio)=='N') {
            DB::table('valinstrinvoicing') ->insert(['instructionid'=>$instructionid,'operatorid'=>
            session('alluser'),'datedue'=>$invoicedatedue]);
        }
    
        DB::table('valinstrfinalapproval') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$approvaldatedue,'isprint'=>$isprint]);

        DB::table('valinstruploads')->where('instructionid',$instructionid)
        ->update(['reportdoc'=>$reportdocname]);

            return redirect()->route('valapp.listquality')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listquality')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listquality')
        ->with('error', 'failed to load');
    }
}
/*-----------report approval ----------------- */
    /*
public function listallinstructionfinalapproval(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstFinalApprovalNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstFinalApprovalPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-final-approval')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglefinalapproval($id,$instrid){
    try {
        $approvalid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
                ->select('*')->orderBy('id', 'desc')->first();
            $arr['currstage']   = DB::table('valinstrfinalapproval')->where('id',$approvalid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
            $arr['upload']   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('*')->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
            return view('val.approval.view-single-instruct-final-approval')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
    }
}
public function submitfinalapproval(Request $request,$id,$instr_id){
    try{
        $approvalid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try{
            $request->validate([
                'reportdocument' => 'required',
            ]);
            $filename   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('reportdoc')->first();
            if (!is_null($filename)) {
             $this->deletereportdoc($filename->reportdoc);
            }
            if ($request->hasFile('reportdocument')) {
                $reportdoc = $request->file('reportdocument');
                $reportdocname = $request->propertyaddress . '.' . $reportdoc->getClientOriginalExtension();
                $reportdoc->storeAs('public/documents/val/doc', $reportdocname);
            }else{$reportdocname = null;}

        $datestamp =     DB::table('valinstrprinting')
        ->where('status','=','P')->select('*')->orderBy('id', 'desc')->first();
        $compileid =     DB::table('valinstrcompile')
        ->where('instructionid',$instructionid)->select('id')->orderBy('id', 'desc')->first();
        $isprint     =     DB::table('valinstrfinalapproval')->where('id', $approvalid)
        ->select('*')->first();
        $newdatestamp = is_null($datestamp) ? now() : $datestamp->datedue;
        $newdatestampdatedue = $newdatestamp <= now() ? now() : $newdatestamp;
        $datedue = Carbon::parse($newdatestampdatedue)->addMinutes(60);


        if (trim($isprint->isprint)=='Y'){
            DB::table('valinstrprinting') ->insert(['instructionid'=>$instructionid,'operatorid'=>
            session('alluser'),'datedue'=>$datedue]);
        }
        DB::table('valinstrsendingreport') ->insert(['instructionid'=>$instructionid,'operatorid'=>
        session('alluser'),'datedue'=>$datedue]);

        DB::table('valinstrcompile')->where('id', $compileid->id)
        ->update(['marketvalue'=>$request->marketvalue,'grc'=>$request->grc,'forcedsale'=>
        $request->forcedsalestimate,'depreciation' =>$request->depreciationvalue,'rentalvalue'=>
        $request->rentalvalue,'landvalue' =>$request->landvalue,'drc'=>$request->drc,'fairvalue'=>
        $request->fairvalue]);
       
        DB::table('valinstrfinalapproval')->where('id', $approvalid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);
        DB::table('valinstruploads')->where('instructionid',$instructionid)
        ->update(['reportdoc'=>$reportdocname]);
        DB::table('valinstructions')->where('id',$instructionid)
        ->update(['status'=>'C']);

        return redirect()->route('valapp.listallappro')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
    }
}
/*------------printing reports-----------------------------*/
    /*
public function listallinstructionprint(){
  
}
public function viewsingleprint($id,$instrid){
  
}

/*------------- report invoicing ----------------- */
    /*
public function listallinstructioninvoice(){
  
}
public function viewsingleinvoicing($id,$instrid){
 
}
public function viewsingleinvoicingportfolio($id){
    try {
        $portfolio = Crypt::decrypt($id);
        try {
            $arr['currency']   = DB::table('currency')
            ->select('id','code')->get();
            $arr['instr']   = DB::table('valinstrlistportfolio')->where('id',$portfolio)
            ->select('*')->first();
           return view('val.approval.view-single-invoicing-portfolio')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
    }
}
public function submitinvoicing(Request $request,$id){
   
}
public function submitinvoicingportfolio(Request $request,$id){

}
/*--------------------dispatch ----------------*/
    /*
public function listallinstructiondispatch(){
    try{
        $nom['normal'] = DB::select('EXEC spValGetInstDispatchNormal');
        $port['portfolio'] = DB::select('EXEC spValGetInstDispatchPortfolio');
        $arr['stage'] = array_merge($nom['normal'], $port['portfolio']); 
    return view('val.approval.list-instruct-dispatch')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsingledispatch($id,$instr_id){
    try {
        $printid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instr_id);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['currstage']   = DB::table('valinstrdispatch')->where('id',$printid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
            return view('val.approval.view-single-dispatch')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listinvoice')
        ->with('error', 'failed to load');
    }
}
public function submitdispatch($id){
    try{
        $printid = Crypt::decrypt($id);
        try{
       
        DB::table('valinstrdispatch')->where('id', $printid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);
        return redirect()->route('valapp.listdispatch')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listdispatch')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listdispatch')
        ->with('error', 'failed to load');
    }
}
/*------------------start download reports------------------------ */
    /*
public function downloadreportword($instr_id) {
    try {
        $instructionid = Crypt::decrypt($instr_id);
        try {
            $upload   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('*')->first();
        } catch (\Throwable $th) {
            return redirect()->route('dash.val');
        }
            if($upload->reportdoc =='' || is_null($upload->reportdoc)){
                return abort(400);
            }
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/val/doc/{$upload->reportdoc}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/val/doc/{$upload->reportdoc}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.val');
    }
}
public function downloadreportexcel($instr_id) {
    try {
        $instructionid = Crypt::decrypt($instr_id);
        try {
            $upload   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('*')->first();
        } catch (\Throwable $th) {
            return redirect()->route('dash.val');
        }
            if($upload->reportexcel =='' || is_null($upload->reportexcel)){
                return abort(400);
            }
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/val/excel/{$upload->reportexcel}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/val/excel/{$upload->reportexcel}"));

    } catch (DecryptException $th) {
        return redirect()->route('dash.val');
    }
}
public function deletereportdoc($filename) {
    //check the existance of receipt first
      if (Storage::disk('public')->exists("documents/val/doc/{$filename}")) {
        Storage::disk('public')->delete("documents/val/doc/{$filename}");
        return 'success';
     }else{return 'notfound';}
   
}
/*------------------end download reports------------------------ */
    /* ----------------compile portfolio---------------------------------*/
    /*
public function listallportfoliocompile(){
    try {
        $arr['portfolio'] = DB::select('EXEC spValGetPortfolioCompilation');
        return view('val.approval.list-instruct-compile-port')->with($arr);
    } catch (\Throwable $th) {
        return redirect()->route('dash.val');
    }
}
public function listallinstructionportfoliocompile($id){
    try {
        $portfolioid = Crypt::decrypt($id);
        try {
            $arr['instruction']   = DB::table('valinstrlistallportfoliocompilation')
            ->where('portfolioid',$portfolioid)->select('*')->get();
            $arr['portfolio']   = DB::table('valinstrlistportfolio')
            ->where('id',$portfolioid)->select('*')->first();
            return view('val.approval.view-single-portfolio-compile')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listportcomp');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listportcomp');
    }
}
public function submitportfoliocompiledreports(Request $request){
    try { 
        $selectedids = $request->input('selected_ids');
        $NumbersInArray         =       count($selectedids);
        $a  = 0;
        while ($a   <   $NumbersInArray){
            $instructionid = Crypt::decrypt($selectedids[$a]);
            DB::table('valinstrportfoliocompiled')
            ->Insert(['instructionid'=>$instructionid,'operatiorid'=>session('alluser')]);
            $errorcode = 'instruction updated';
            $a++;
        }
        return  redirect()->route('valapp.viewsinglportfoli',$request->portfolio) 
        ->with('success', $errorcode);
    } catch (\Throwable $th) {
        return  redirect()->route('valapp.viewsinglportfoli',$request->portfolio) 
     ->with('error', 'failed to load');
    } 
}
public function closeportfolio($id){
    try {
        $portfolioid = Crypt::decrypt($id);
        try {
            $instructioncaptured   = DB::table('valinstructions')
            ->where('portfolioid',$portfolioid)->select('*')->count();
            $expected   = DB::table('valinstrportfolio')
            ->where('id',$portfolioid)->select('*')->first();
            $compiled  = DB::table('valinstructions')->join('valinstrportfoliocompiled',
            'valinstructions.id','=','valinstrportfoliocompiled.instructionid')
            ->where('valinstructions.portfolioid',$portfolioid)->select('*')->count();
            if($instructioncaptured <> $expected->totalproperties){
                return redirect()->route('valapp.viewsinglportfoli',$id)
        ->with('error', 'portfolio properties not complete');
            }
            if($compiled <> $expected->totalproperties){
                return redirect()->route('valapp.viewsinglportfoli',$id)
        ->with('error', 'some properties pending compilation');
            }
            DB::table('valinstrportfolioclosed')
            ->Insert(['portfolioid'=>$portfolioid,'operatorid'=>session('alluser')]);
            DB::table('valinstrportfolio')->where('id', $portfolioid)
            ->update(['status' => 'C']);
            return redirect()->route('valapp.listportcomp')
            ->with('success','portfolio closed');
        } catch (\Throwable $th) {
        return redirect()->route('valapp.viewsinglportfoli',$id)
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.viewsinglportfoli',$id)
        ->with('error', 'failed to load');
    }
}
/* -----------------------end compile portfolio */
    /*-----------------------------send soft copies---------------------*/
    /*
public function listallinstructionsendingsoftcopy(){
    try{
        $arr['stage'] = DB::select('EXEC spValGetInstEmailNormal');
    return view('val.approval.list-instruct-softcopy')->with($arr);
    } catch (\Throwable $th) {
        return  redirect()->route('dash.val');
    }
}
public function viewsinglesoftcopy($id,$instrid){
    try {
        $softid = Crypt::decrypt($id);
        $instructionid = Crypt::decrypt($instrid);
        try {
            $arr['type']   = DB::table('clienttype')
                ->select('id','description')->get();
            $arr['instr']   = DB::table('valinstructions')->where('id',$instructionid)
                ->select('*')->first();
            $arr['prevstage']   = DB::table('valinstrcompile')->where('instructionid',$instructionid)
                ->select('*')->orderBy('id', 'desc')->first();
            $arr['currstage']   = DB::table('valinstrsendingreport')->where('id',$softid)
                ->select('*')->first();
            $arr['properties']   = collect(DB::select('EXEC spValGetInstrSingleProperty ?'
            ,[$arr['instr']->propertyid]))->first();
            $arr['upload']   = DB::table('valinstruploads')->where('instructionid',$instructionid)
            ->select('*')->first();
        
            $arr['purpose'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valinstructions') ->where('id', $instructionid)
                    ->select('*') ->first(),
                default => DB::table('valinstrportfolio')
                    ->where('id', $arr['instr']->portfolioid)
                    ->select('*')->first(),
            };
            $arr['client'] = match (trim($arr['instr']->isportfolio)) {
                'N' => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['instr']->contactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
                default => DB::table('valclientcontactperson')->join('valclientdetail', 
                'valclientcontactperson.clientid','=', 'valclientdetail.id')
                ->where('valclientcontactperson.id', $arr['purpose']->clientcontactid)
                    ->select('valclientdetail.companyname','valclientdetail.lastname',
                    'valclientdetail.firstname','valclientcontactperson.firstname As contactfirstname'
                    ,'valclientcontactperson.lastname As contactlastname','valclientcontactperson.cell',
                    'valclientcontactperson.email','valclientdetail.contactddress') ->first(),
            };
            return view('val.approval.view-single-soft-copy')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
    return redirect()->route('valapp.listallappro')
        ->with('error', 'failed to load');
    }
}
public function submitsoftcopy($id){
    try{
        $softcopyid = Crypt::decrypt($id);
        try{
       
        DB::table('valinstrsendingreport')->where('id', $softcopyid)
        ->update(['completedby' => session('alluser'),'status' => 'C',
        'completedon' => now()]);
        return redirect()->route('valapp.listallsoft')
            ->with('success', 'instruction updated');
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listallsoft')
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listallsoft')
        ->with('error', 'failed to load');
    }
}
/*--------------------close send soft copy report------------------- */
    /*=======================review portfolio============================== */
    /*
public function listallportfolioreview(){
    try {
        $arr['portfolio'] = DB::select('EXEC spValGetPortfolioReview');
        return view('val.approval.list-instruct-review-port')->with($arr);
    } catch (\Throwable $th) {
        return redirect()->route('dash.val');
    }
}
public function listallinstructionportfolioreview($id){
    try {
        $portfolioid = Crypt::decrypt($id);
        try {
            $arr['instruction']   = DB::table('valinstrlistallportfolioreview')
            ->where('portfolioid',$portfolioid)->select('*')->get();
            $arr['portfolio']   = DB::table('valinstrlistportfolio') 
            ->where('id',$portfolioid)->select('*')->first();
            return view('val.approval.view-single-portfolio-review')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('valapp.listportcomp');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.listportcomp');
    }
}
public function submitportfolioreviewedreports(Request $request){
    try { 
        $selectedids = $request->input('selected_ids');
        $NumbersInArray         =       count($selectedids);
        $a  = 0;
        while ($a   <   $NumbersInArray){
            $instructionid = Crypt::decrypt($selectedids[$a]);
            DB::table('valinstrportfolioreviewed')
            ->Insert(['instructionid'=>$instructionid,'operatorid'=>session('alluser')]);
            $errorcode = 'instruction updated';
            $a++;
        }
        return  redirect()->route('valapp.viewsinglportrevie',$request->portfolio) 
        ->with('success', $errorcode);
    } catch (\Throwable $th) {
        return  redirect()->route('valapp.viewsinglportrevie',$request->portfolio) 
     ->with('error', 'failed to load');
    } 
}
public function closeportfolioreview($id){
    try {
        $portfolioid = Crypt::decrypt($id);
        try {
            $instructioncaptured   = DB::table('valinstructions')
            ->join('valinstrportfolioreviewed',
            'valinstructions.id','=','valinstrportfolioreviewed.instructionid')
            ->where('portfolioid',$portfolioid)->select('*')->count();
            $expected   = DB::table('valinstrportfolio')
            ->where('id',$portfolioid)->select('*')->first();
            $compiled  = DB::table('valinstructions')->join('valinstrportfoliocompiled',
            'valinstructions.id','=','valinstrportfoliocompiled.instructionid')
            ->where('valinstructions.portfolioid',$portfolioid)->select('*')->count();
            if($instructioncaptured <> $expected->totalproperties){
                return redirect()->route('valapp.viewsinglportrevie',$id)
        ->with('error', 'portfolio properties not completed in review');
            }
            if($compiled <> $expected->totalproperties){
                return redirect()->route('valapp.viewsinglportrevie',$id)
        ->with('error', 'some properties pending review');
            }
            DB::table('valinstrportfolioclosed')->where('portfolioid', $portfolioid)
            ->update(['reviewedby' => session('alluser'),'status' => 'C',
            'reviewedon' => now()]);
            return redirect()->route('valapp.listportreview')
            ->with('success','portfolio closed');
        } catch (\Throwable $th) {
        return redirect()->route('valapp.viewsinglportrevie',$id)
        ->with('error', 'failed to load');
        }
    } catch (DecryptException $th) {
        return redirect()->route('valapp.viewsinglportrevie',$id)
        ->with('error', 'failed to load');
    }
}
/*-------------------------end review portfolio---------------------------- */
}
