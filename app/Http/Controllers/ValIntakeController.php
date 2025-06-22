<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Svg\Tag\Rect;

class ValIntakeController extends Controller
{
    /*------------ new valuation client ---------*/
    function addnewclientdetails()
    {
        try {
            $arr['type']   = DB::table('setupclienttype')->select('*')->get();
            return view('valuation.intake.add-client-details')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function createnewclientdetails(Request $request)
    {
        try {
            if (!is_null($request->email)) {
                if (DB::table('valclientdetail')->select('id')->where('email', $request->email)->exists()) {
                    return  redirect()->route('valin.newclient')
                        ->with('error', 'client exists');
                }
            } elseif (!is_null($request->contactemail)) {
                if (DB::table('valclientcontactperson')->select('id')->where('email', $request->contactemail)->exists()) {
                    return  redirect()->route('valin.newclient')
                        ->with('error', 'contact exists');
                }
            }
            if ($request->clienttype == 1) {
                $contactemail       =   $request->email;
                $contactcell        =   $request->cell;
                $contactlastname    =   $request->lastname;
                $contactfirstname   =   $request->firstname;
            } else {
                $contactemail       =   $request->contactemail;
                $contactcell        =   $request->contactcell;
                $contactlastname    =   $request->contactlastname;
                $contactfirstname   =   $request->contactfirstname;
            }
            $clientid = DB::table('valclientdetail')->insertGetId(
                [
                    'clienttypeid' => $request->clienttype,
                    'firstname' => $request->firstname,
                    'cell' => $request->cell,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'operatorid' => session('alluser'),
                    'lastname' => $request->lastname,
                    'contactaddress' => $request->contactaddress,
                    'companyname' => $request->companyname
                ]
            );

            DB::table('valclientcontactperson')->insert([
                'email' => $contactemail,
                'cell' => $contactcell,
                'lastname' => $contactlastname,
                'firstname' => $contactfirstname,
                'operatorid' => session('alluser'),
                'clientid' => $clientid
            ]);


            return  redirect()->route('valin.newclient')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('valin.newclient')
                ->with('error', 'failed to load');
        }
    }
    /*------------ new valuation property ---------*/
    function addnewpropertydetails()
    {
        try {
            $arr['type']   = DB::table('setupclienttype')->select('*')->get();
            $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
            $arr['town']   = DB::table('vallocations')->select('*')->get();
            return view('valuation.intake.add-new-property')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function createnewpropertydetails(Request $request)
    {
        try {
            $numbersinarray         =       count($request->propertyaddress);
            $a = 0;
            while ($a   <   $numbersinarray) {
                $propertytypeid = strstr($request->propertytype[$a], "-", true);
                $suburbid = strstr($request->propertysurbub[$a], "-", true);
                DB::table('valclientproperty')
                    ->insert([
                        'clientid' => $request->propertyclientname,
                        'propertytypeid' => $propertytypeid,
                        'suburbid' => $suburbid,
                        'streetaddress' => $request->propertyaddress[$a],
                        'operatorid' => session('alluser')
                    ]);
                $a++;
            }
            return  redirect()->route('valin.newprop')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('valin.newprop')
                ->with('error', 'failed to load');
        }
    }
    /*------------ get client by type(individual/corporate) ---------*/
    function getsingleclientbytype($id)
    {
        $arr['client']   = DB::table('valclientdetail')->where('clienttypeid', $id)
            ->select('*')->get();
        return view('valuation.intake.get-clients-bytype')->with($arr);
    }
    /*------------ create valuation portfolio ---------*/
    function createportfolio()
    {
        try {
            $arr['type']   = DB::table('setupclienttype')->select('*')->get();
            $arr['purpose']   = DB::table('valpurpose')->select('id', 'description')->get();
            $arr['valtype']   = DB::table('valtype')->select('id', 'description')->get();
            $arr['payment']   = DB::table('valpaymentagreement')->select('id', 'description')->get();
            return view('valuation.intake.create-new-portfolio')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function createnewportfolio(Request $request)
    {
        try {
            $invoicedatedue = Carbon::parse(now())->addMinutes(60);
            $id = DB::table('valinstrportfolio')->insertGetId([
                'datedue' => $request->portfolioduedate,
                'totalproperties' => $request->totalnumberpropertyportfolio,
                'operatorid' => session('alluser'),
                'purpose' => $request->valuationpurpose,
                'type' => $request->valuationtype,
                'paymentterms' => $request->valuationpaymentagreement,
                'clientcontactid' => $request->clientcontactname,
                'clientid' => $request->propertyclientname
            ]);

            DB::table('valinstrinvoicingportfolio')->insert(['portfolioid' => $id, 'operatorid' =>
            session('alluser'), 'datedue' => $invoicedatedue]);

            return  redirect()->route('valin.newportfoli')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('valin.newportfoli')
                ->with('error', 'failed to load');
        }
    }
    /*------------ get valuation client contact person---------*/
    function getsingleclientcontact($id)
    {
        $arr['client']   = DB::table('valclientcontactperson')->where('clientid', $id)
            ->where('isavailable', '=', 'Y')->select('*')->get();
        return view('valuation.intake.get-all-client-contacts')->with($arr);
    }
    /*------------ create valuation instruction as portfolio ---------*/
    function addnewinstructionportfolio()
    {
        try {
            $arr['valuer'] = DB::select('EXEC spGetValValuers');
            $arr['port'] = DB::table('valinstrlistportfolio')->where('totalproperties', '>', DB::raw(
                'ISNULL(CAST(propertiescaptured AS INT),0)'
            ))->select('*')->get();
            return view('valuation.intake.new-instruction-portfolio-page-1')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function addportfoliosubmitpage(Request $request)
    {
        try {
            $id = Crypt::encrypt($request->portfolioname);
            $vid = Crypt::encrypt($request->valuername);
            return  redirect()->route('valin.portpage2', [$id, $vid]);
        } catch (DecryptException $th) {
            return  redirect()->route('valin.addinstport')
                ->with('error', 'failed to load');
        }
    }
    function addinstructionportsteptwo($id, $vid)
    {
        try {
            $portfolioid = Crypt::decrypt($id);
            $valuerid = Crypt::decrypt($vid);
            try {
                $arr['valuer']   = DB::table('systusers')->where('id', $valuerid)
                    ->select('*')->first();
                $arr['port']   = DB::table('valinstrlistportfolio')->where('id', $portfolioid)
                    ->select('*')->first();
                $arr['property'] = DB::select('EXEC spGetValInstrPropertyToCapture ?', [$arr['port']->clientid]);
                return view('valuation.intake.new-instruction-portfolio-page-2')->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('valin.addinstport')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('valin.addinstport')
                ->with('error', 'failed to load');
        }
    }
    /*------------ allocate valuation portfolio instruction ---------*/
    function allocateinstructionport(Request $request)
    {
        try {
            $port   = DB::table('valinstrlistportfolio')->where('id', $request->portfolio)
                ->select('*')->first();

            $selectedids = $request->input('selectedids');
            $NumbersInArray         =       count($selectedids);
            $a  = 0;
            $capturedproperties = $port->propertiescaptured + $NumbersInArray;
            $allproperties = $port->totalproperties -  $capturedproperties;
            if ($allproperties >= 0) {
                while ($a   <   $NumbersInArray) {
                    $id = DB::table('valinstructions')->insertGetId([
                        'allocatedto' => $request
                            ->allocateto,
                        'propertyid' => $selectedids[$a],
                        'operatorid' => session('alluser'),
                        'portfolioid' => $request->portfolio,
                        'isportfolio' => 'Y'
                    ]);

                    DB::table('valinstracknowledgement')
                        ->insert([
                            'instructionid' => $id,
                            'operatorid' => session('alluser'),
                            'allocatedto' => $request->user,
                        ]);
                    DB::table('valinstrportfolio')->where('id', $request->portfolio)
                        ->update(['propertiescaptured' => $capturedproperties]);
                    $a++;
                }
                return  redirect()->route('valin.addinstport')
                    ->with('success', 'record added');
            } else {
                return  redirect()->route('valin.addinstport')
                    ->with('error', 'more properties than expected');
            }
        } catch (\Throwable $th) {
            return  redirect()->route('valin.addinstport')
                ->with('error', 'failed to load');
        }
    }
    /*------------ allocate valuation normal instruction ---------*/
    function addnewinstructionnormal()
    {
        try {
            $arr['type']   = DB::table('setupclienttype')->select('*')->get();
            $arr['purpose']   = DB::table('valpurpose')->select('id', 'description')->get();
            $arr['valtype']   = DB::table('valtype')->select('id', 'description')->get();
            $arr['payment']   = DB::table('valpaymentagreement')->select('id', 'description')->get();
            $arr['valuer'] = DB::select('EXEC spGetValValuers');
            return view('valuation.intake.new-instruction-normal-page-1')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.val');
        }
    }
    function addnormalsubmitpage(Request $request)
    {
        try {
            $id = Crypt::encrypt($request->propertyclientname);
            $vid = Crypt::encrypt($request->valuername);
            $cid = Crypt::encrypt($request->clientcontactname);
            $pid = Crypt::encrypt($request->valuationpurpose);
            $tid = Crypt::encrypt($request->valuationtype);
            $payid = Crypt::encrypt($request->valuationpaymentagreement);
            $accessdate = Crypt::encrypt($request->accessdatetime);
            return  redirect()->route('valin.normpage2', [$id, $vid, $cid, $pid, $tid, $payid, $accessdate]);
        } catch (DecryptException $th) {
            return  redirect()->route('valin.addinstnorm')
                ->with('error', 'failed to load');
        }
    }
    function addinstructionnormalsteptwo($id, $vid, $cid, $pid, $tid, $payid, $accessdate)
    {
        try {
            $clientid = Crypt::decrypt($id);
            $valuerid = Crypt::decrypt($vid);
            $contactid = Crypt::decrypt($cid);
            $purposeid = Crypt::decrypt($pid);
            $typeid = Crypt::decrypt($tid);
            $paymentid = Crypt::decrypt($payid);
            $accessdatetime = Crypt::decrypt($accessdate);
            try {
                $arr['valuer']   = DB::table('systusers')->where('id', $valuerid)
                    ->select('*')->first();
                $arr['contact']   = DB::table('valclientcontactperson')->where('id', $contactid)
                    ->select('*')->first();
                $arr['purpose']   = DB::table('valpurpose')->where('id', $purposeid)
                    ->select('*')->first();
                $arr['valtype']   = DB::table('valtype')->where('id', $typeid)
                    ->select('*')->first();
                $arr['payment']   = DB::table('valpaymentagreement')->where('id', $paymentid)
                    ->select('*')->first();
                $arr['access'] = $accessdatetime;
                $arr['property'] = DB::select('EXEC spGetValInstrPropertyToCapture ?', [$clientid]);
                return view('valuation.intake.new-instruction-normal-page-2')->with($arr);
            } catch (\Throwable $th) {
                return  redirect()->route('valin.addinstnorm')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return  redirect()->route('valin.addinstnorm')
                ->with('error', 'failed to load');
        }
    }
    function allocateinstructionnorm(Request $request)
    {
        try {
            $selectedids = $request->input('selectedids');
            $NumbersInArray         =       count($selectedids);
            $accessdatetime = Carbon::parse($request->accessdatetime);
            $a  = 0;
            while ($a   <   $NumbersInArray) {
                $id = DB::table('valinstructions')->insertGetId([
                    'allocatedto' => $request
                        ->allocateto,
                    'propertyid' => $selectedids[$a],
                    'operatorid' => session('alluser'),
                    'purpose' => $request->purpose,
                    'type' => $request->valtype,
                    'paymentterms' => $request->payment,
                    'contactid' => $request->contact,
                    'datedueaccessdate' => $accessdatetime
                ]);

                DB::table('valinstracknowledgement')
                    ->insert([
                        'instructionid' => $id,
                        'operatorid' => session('alluser'),
                        'allocatedto' => $request->user,
                    ]);
                $a++;
            }
            return  redirect()->route('valin.addinstnorm')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('valin.addinstnorm')
                ->with('error', 'failed to load' . $th);
        }
    }
}
