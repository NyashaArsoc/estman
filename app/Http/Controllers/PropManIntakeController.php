<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Carbon\Carbon;
use App\PDFReporting\pdfreport;

class PropManIntakeController extends Controller
{
    private $monthlyvalue;
    private $quarterlyvalue;
    private $halfyearlyvalue;
    private $yearlyvalue;
    public function __construct()
    {
        $todayvalue = date("Y-m-d H:i:s");
        $timeinseconds = strtotime($todayvalue);
        $addmonthlyvalue  = $timeinseconds + (3600 * 24) * 30;
        $addquarterlyvalue = $timeinseconds + (3600 * 24) * 90;
        $addhalfyearlyvalue = $timeinseconds + (3600 * 24) * 180;
        $addyearlyvalue = $timeinseconds + (3600 * 24) * 360;
        $this->monthlyvalue  = date("Y-m-d", $addmonthlyvalue);
        $this->quarterlyvalue  = date("Y-m-d", $addquarterlyvalue);
        $this->halfyearlyvalue  = date("Y-m-d", $addhalfyearlyvalue);
        $this->yearlyvalue  = date("Y-m-d", $addyearlyvalue);
    }
    /*---------------creating new landlord-----------------*/
    public function addlandlorddetails()
    {
        try {
            $currencycode = $this->getcurrencycode();
            $clienttype = $this->getclienttype();
            switch ($currencycode) {
                case 'failed':
                    return  redirect()->route('setin.property')->with('error', 'failed to load');
                default:
                    $arr['currency'] = $currencycode;
            }

            switch ($clienttype) {
                case 'failed':
                    return  redirect()->route('setin.property')->with('error', 'failed to load');
                default:
                    $arr['type'] = $clienttype;
            }
            return view('propman.intake.add-landlord')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function addnewlandlorddetails(Request $request)
    {
        try {
            $accountnumber = (!empty($request->accountnumber)) ? $request->accountnumber : 0;
            $currencycode = (!empty($request->currencycode)) ? $request->currencycode : 0;
            $accountname = (!empty($request->accountname)) ? $request->accountname : 0;
            $bankname = (!empty($request->bankname)) ? $request->bankname : 0;
            $branch = (!empty($request->branch)) ? $request->branch : 0;
            $arraytotal         =       count($accountnumber);
            $a  = 0;
            if (!is_null($request->nationalid)) {
                if (DB::table('propmanlandlord')->select('id')->where('nationalid', $request->nationalid)->exists()) {
                    return  redirect()->route('propin.addlandlord')
                        ->with('error', 'client exists');
                }
            } elseif (!is_null($request->companynumber)) {
                if (DB::table('propmanlandlord')->select('id')->where('companynumber', $request->companynumber)->exists()) {
                    return  redirect()->route('propin.addlandlord')
                        ->with('error', 'client exists');
                }
            }
            $landlordid = DB::table('propmanlandlord')->insertGetId(
                [
                    'nationalid' => $request->nationalid,
                    'clienttypeid' => $request->clienttype,
                    'firstname' => $request->firstname,
                    'cell' => $request->cell,
                    'email' => $request->email,
                    'tel' => $request->tel,
                    'operatorid' => session('alluser'),
                    'lastname' => $request->lastname,
                    'contactaddress' => $request->billingaddress,
                    'companynumber' => $request->companynumber,
                    'tinnumber' => $request->tinumber,
                    'vatnumber' => $request->vatnumber,
                    'companyname' => $request->companyname
                ]
            );
            DB::table('propmanlandlordcontact')->insert([
                'email' => $request->contactemail,
                'cell' => $request->contactcell,
                'lastname' => $request->contactlastname,
                'firstname' => $request->contactfirstname,
                'operatorid' => session('alluser'),
                'landlordid' => $landlordid
            ]);
            while ($a   <   $arraytotal) {
                DB::table('propmanlandlordbank')
                    ->Insert([
                        'accountnumber' => $accountnumber[$a],
                        'branch' => $branch[$a],
                        'bankname' => $bankname[$a],
                        'accountname' => $accountname[$a],
                        'operatorid' => session('alluser'),
                        'currencycode' => $currencycode[$a],
                        'landlordid' => $landlordid
                    ]);
                $a++;
            }
            return  redirect()->route('propin.addlandlord')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('propin.addlandlord')
                ->with('error', 'failed to load');
        }
    }
    public function addlandlordcontact($id)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                $arr['landlord']   = DB::table('propmanalllandlord')
                    ->where('id', $landlordid)->select('*')->first();
                return view('propman.intake.add-single-landlord-contact')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.editland', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.editland', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addlandlordnewcontact(Request $request, $id)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                DB::table('propmanlandlordcontact')->insert([
                    'email' => $request->contactemail,
                    'cell' => $request->contactcell,
                    'lastname' => $request->contactlastname,
                    'firstname' => $request->contactfirstname,
                    'operatorid' => session('alluser'),
                    'landlordid' => $landlordid
                ]);
                return  redirect()->route('propma.editland', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propma.editland', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.editland', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addlandlordbank($id)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                $arr['landlord']   = DB::table('propmanalllandlord')
                    ->where('id', $landlordid)->select('*')->first();
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode;
                return view('propman.intake.add-single-landlord-bank')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.editland', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.editland', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addlandlordnewbank($id, Request $request)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                DB::table('propmanlandlordbank')->insert([
                    'operatorid' => session('alluser'),
                    'landlordid' => $landlordid,
                    'currencycode' => $request->currencycode,
                    'accountname' => $request->accountname,
                    'accountnumber' => $request->accountnumber,
                    'branch' => $request->branch,
                    'bankname' => $request->bankname
                ]);
                return  redirect()->route('propma.editland', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propma.editland', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.editland', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end creating new landlord-----------------*/
    /*---------------creating new property-----------------*/
    public function addpropertydetails()
    {
        try {
            $currencycode = $this->getcurrencycode();
            $clienttype = $this->getclienttype();
            $arr['province']   = DB::table('setupprovince')->select('*')->get();
            $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
            $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
            $arr['currency'] = $currencycode;
            $arr['type'] = $clienttype;
            return view('propman.intake.add-property')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function addnewpropertydetails(Request $request)
    {
        try {
            $request->validate([
                'mandate' => 'required',
            ]);
            //checking if the attachment is there 
            if ($request->hasFile('mandate')) {
                $reportdoc = $request->file('mandate');
                $reportdocname = $request->billingaddress . '.' . $reportdoc->getClientOriginalExtension();
                $reportdoc->storeAs('public/documents/prop/mandate', $reportdocname);
            }
            //checking if the attachment is there 
            if ($request->hasFile('otherattachment')) {
                $otherattachment = $request->file('otherattachment');
                $otherattachmentname = $request->billingaddress . '.' . $otherattachment->getClientOriginalExtension();
                $otherattachment->storeAs('public/documents/prop/other', $otherattachmentname);
            }
            $otherattachmentname = null;

            $propertyid = DB::table('propmanproperty')
                ->insertGetId([
                    'currencycode' => $request->currencycode,
                    'landlordid' => $request->landlordname,
                    'operatorid' =>
                    session('alluser'),
                    'propertytypeid' => $request->propertytype,
                    'city' => ucfirst($request->city),
                    'location' => ucfirst($request->locationsurburb),
                    'streetaddress' => $request->billingaddress,
                    'standnumber'
                    => $request->standnumber,
                    'comments' => $request->commentshighlights,
                    'rooms' =>  $request->rooms,
                    'bedrooms' => $request->bedrooms,
                    'bathrooms' => $request->bathrooms,
                    'stories' => $request->stories,
                    'totalarea' => $request->totalarea,
                    'lettablearea' => $request->lettablearea,
                    'ratesqm' =>
                    $request->expectedrate,
                    'expectedrental' => $request->expectedrental,
                    'mandate' => $reportdocname,
                    'otherattachement' => $otherattachmentname,
                    'provinceid' => $request->province
                ]);
            DB::table('propmancommissionpercent')
                ->Insert([
                    'propertyid' => $propertyid,
                    'setupcommissionoptionid' => $request->commissiontype,
                    'percentage' => $request->commissionpercentage
                ]);
            return  redirect()->route('propin.addproperty')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('propin.addproperty')
                ->with('error', 'failed to load');
        }
    }
    /*---------------end creating new property-----------------*/
    /*---------------creating new tenant-----------------*/
    public function addtenantdetails()
    {
        try {
            $clienttype = $this->getclienttype();
            $arr['type'] = $clienttype;
            return view('propman.intake.add-tenant')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function addnewtenantdetails(Request $request)
    {
        try {
            if (!is_null($request->nationalid)) {
                if (DB::table('propmantenant')->select('id')->where('nationalid', $request->nationalid)->exists()) {
                    return  redirect()->route('propin.addtenant')
                        ->with('error', 'record exists');
                }
                /*----------values to insert in table keen ---------*/
                $tablearray = [
                    'email' => $request->keenemail,
                    'lastname' => $request->keenlastname,
                    'firstname' => $request->keenfirstname,
                    'operatorid' => session('alluser'),
                    'cell' => $request->keencell
                ];
                $tablename = 'propmantenantkeen';
            } elseif (!is_null($request->companynumber)) {
                if (DB::table('propmantenant')->select('id')->where('companynumber', $request->companynumber)->exists()) {
                    return  redirect()->route('propin.addtenant')
                        ->with('error', 'record exists');
                }
                $tablearray = [
                    'email' => $request->contactemail,
                    'lastname' => $request->contactlastname,
                    'firstname' => $request->contactfirstname,
                    'operatorid' => session('alluser'),
                    'cell'
                    => $request->contactcell
                ];
                $tablename = 'propmantenantcontact';
            }
            //-------------------table insert tenant----------------
            $tenantid = DB::table('propmantenant')->insertGetId([
                'nationalid' =>
                $request->nationalid,
                'clienttypeid' => $request->clienttype,
                'firstname' => $request->firstname,
                'cell' => $request->cell,
                'email' => $request->email,
                'tel' => $request->tel,
                'operatorid'
                => session('alluser'),
                'lastname' => $request->lastname,
                'contactaddress' => $request->billingaddress,
                'companynumber' => $request->companynumber,
                'tinnumber' => $request->tinnumber,
                'vatnumber' =>
                $request->vatnumber,
                'companyname' => $request->companyname
            ]);
            $idarray  = ['tenantid' => $tenantid]; //define the tenantId
            $combinedarray = array_merge($idarray, $tablearray);
            DB::table($tablename)->insert($combinedarray);

            return  redirect()->route('propin.addtenant')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('propin.addtenant')
                ->with('error', 'failed to load');
        }
    }
    public function addtenantkeen($id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                $arr['tenant']   = DB::table('propmanalltenant')
                    ->where('id', $tenantid)->select('*')->first();
                return view('propman.intake.add-single-tenant-keen')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addtenantnewkeen(Request $request, $id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                DB::table('propmantenantkeen')->insert([
                    'email' => $request->contactemail,
                    'cell' => $request->contactcell,
                    'lastname' => $request->contactlastname,
                    'firstname' => $request->contactfirstname,
                    'operatorid' => session('alluser'),
                    'tenantid' => $tenantid
                ]);
                return  redirect()->route('propma.edittena', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addtenantcontact($id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                $arr['tenant']   = DB::table('propmanalltenant')
                    ->where('id', $tenantid)->select('*')->first();
                return view('propman.intake.add-single-tenant-contact')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addtenantnewcontact(Request $request, $id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                DB::table('propmantenantcontact')->insert([
                    'email' => $request->contactemail,
                    'cell' => $request->contactcell,
                    'lastname' => $request->contactlastname,
                    'firstname' => $request->contactfirstname,
                    'operatorid' => session('alluser'),
                    'tenantid' => $tenantid
                ]);
                return  redirect()->route('propma.edittena', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end creating new tenant-----------------*/
    /*---------------creating new lease-----------------*/
    public function addleasedetails()
    {
        try {
            $currencycode = $this->getcurrencycode();
            $clienttype = $this->getclienttype();
            $arr['province']   = DB::table('setupprovince')->select('*')->get();
            $arr['proptype']   = DB::table('setuppropertytype')->select('*')->get();
            $arr['commtype']   = DB::table('setupcommissionoptions')->select('*')->get();
            $arr['currency'] = $currencycode;
            $arr['type'] = $clienttype;
            return view('propman.intake.add-lease')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function addnewleasedetails(Request $request)
    {
        try {
            $request->validate([
                'mandate' => 'leaseagreement',
            ]);
            //checking if the attachment is there 
            if ($request->hasFile('leaseagreement')) {
                $reportdoc = $request->file('leaseagreement');
                $reportdocname = $request->propertydescription . '.' . $reportdoc->getClientOriginalExtension();
                $reportdoc->storeAs('public/documents/prop/lease', $reportdocname);
            }
            switch ($request->rentreviewperiod) {
                case 'monthly':
                    $nextrentreview = $this->monthlyvalue;
                case 'quarterly':
                    $nextrentreview = $this->quarterlyvalue;
                case 'halfyearly':
                    $nextrentreview = $this->halfyearlyvalue;
                case 'yearly':
                    $nextrentreview = $this->yearlyvalue;
            }

            switch ($request->inspectionperiod) {
                case 'monthly':
                    $nextinspection = $this->monthlyvalue;
                case 'quarterly':
                    $nextinspection = $this->quarterlyvalue;
                case 'halfyearly':
                    $nextinspection = $this->halfyearlyvalue;
                case 'yearly':
                    $nextinspection = $this->yearlyvalue;
            }

            $currencycode = (!empty($request->leaseitemcurrencycode)) ? $request->leaseitemcurrencycode : [0];
            $leasebalancebd = (!empty($request->leasebalancebd)) ? $request->leasebalancebd : [0];
            $leaseratescost = (!empty($request->leaseratescost)) ? $request->leaseratescost : [0];
            $leaseoperationalcost = (!empty($request->leaseoperationalcost)) ? $request->leaseoperationalcost : [0];
            $leasedepositpaid = (!empty($request->leasedepositpaid)) ? $request->leasedepositpaid : [0];
            $leaseadminpaid = (!empty($request->leaseadminpaid)) ? $request->leaseadminpaid : [0];
            $arraytotal         =       count($currencycode);
            //check on the availability of array first 
            $a  = 0;
            $rental = ($request->propertytype == 1) ? $request->expectedrental
                : $request->expectedrate * $request->areataken;

            $leaseid    = DB::table('propmanlease')->insertGetId([
                'tenantid' => $request->tenantname,
                'propertyid' => $request->propertyaddress,
                'operatorid' => session('alluser'),
                'validfrom' => $request->leasevalidfrom,
                'validto' => $request->leasevalidto,
                'areataken' =>
                $request->areataken,
                'rental' => $rental,
                'currencycode' => $request->currencycode,
                'ratesqm' =>
                $request->expectedrate,
                'propertydescription' => $request->propertydescription,
                'landlordcontactid'
                => $request->landlordname,
                'rentreview' => $request->rentreviewperiod,
                'inspectionreview' =>
                $request->inspectionperiod,
                'agreement' => $reportdocname
            ]);

            DB::table('propmanleaseschedules')->insert([
                'leaseid' => $leaseid,
                'nextinspection' => $nextinspection,
                'nextrentreview' => $nextrentreview
            ]);
            while ($a   <   $arraytotal) {
                if ($leasebalancebd[$a] > 0) {
                    $tablearray = [
                        'leaseid' => $leaseid,
                        'currencycode' => $currencycode[$a],
                        'leasebalancebd' => $leasebalancebd[$a],
                        'operatorid' => session('alluser'),
                        'baldays' => 10
                    ];
                    $tablename = 'propmanleasearrearsdetails';
                } else {
                    $tablearray = [
                        'leaseid' => $leaseid,
                        'currencycode' => $currencycode[$a],
                        'balance' => $leasebalancebd[$a] * -1
                    ];
                    $tablename = 'propmanleaseprepayments';
                }
                if ($currencycode[$a] <> 0) {
                    DB::table($tablename)->insert($tablearray);
                    DB::table('propmanleasecurrentbillrates')
                        ->Insert([
                            'deposit' => $leasedepositpaid[$a],
                            'ratescosts' => $leaseratescost[$a],
                            'operationalcosts' => $leaseoperationalcost[$a],
                            'adminstrationfee' => $leaseadminpaid[$a],
                            'currencycode' => $currencycode[$a],
                            'leaseid' => $leaseid
                        ]);
                }
                $a++;
            }
            return  redirect()->route('propin.addlease')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return  redirect()->route('propin.addlease')
                ->with('error', 'failed to load');
        }
    }
    public function addleaserate($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $arr['lease']   = DB::table('propmanalllease')->where('id', $leaseid)
                    ->select('*')->first();
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode;
                return view('propman.intake.add-single-lease-rate')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addnewleaserate(Request $request, $id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                DB::table('propmanleasecurrentbillrates')->insert([
                    'currencycode' => $request->currencycode,
                    'operationalcosts' => $request->leaseoperationalcost,
                    'ratescosts' => $request->leaseratescost,
                    'leaseid' => $leaseid
                ]);
                return  redirect()->route('propma.editlea', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propma.editlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.editlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addleaseprepay($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode;
                $arr['lease']   = DB::table('propmanalllease')
                    ->where('id', $leaseid)->select('*')->first();
                return view('propman.intake.add-single-lease-prepay')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propdec.editviewlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addnewleaseprepay(Request $request, $id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                DB::table('propmantempleaseprepayments')->insert([
                    'currencycode' => $request->currencycode,
                    'balance' => $request->amount,
                    'leaseid' => $leaseid
                ]);
                return  redirect()->route('propdec.editviewlea', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propdec.editviewlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addleasearrear($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode;
                $arr['lease']   = DB::table('propmanalllease')
                    ->where('id', $leaseid)->select('*')->first();
                return view('propman.intake.add-single-lease-arrear')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propdec.editviewlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addnewleasearrear(Request $request, $id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                DB::table('propmantempleasearrearsdetails')->insert([
                    'currencycode' => $request->currencycode,
                    'operatorid' => session('alluser'),
                    'balrent' => $request->amount,
                    'leaseid' => $leaseid
                ]);
                return  redirect()->route('propdec.editviewlea', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propdec.editviewlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addnewleaseratedeclined(Request $request, $id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                DB::table('propmantempleasecurrentbillrates')->insert([
                    'currencycode' => $request->currencycode,
                    'operationalcosts' => $request->leaseoperationalcost,
                    'ratescosts' => $request->leaseratescost,
                    'leaseid' => $leaseid
                ]);
                return  redirect()->route('propdec.editviewlea', $id)
                    ->with('success', 'record added');
            } catch (\Throwable $th) {
                return redirect()->route('propdec.editviewlea', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propdec.editviewlea', $id)
                ->with('error', 'failed to load');
        }
    }
    public function addleaseratedeclined($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $arr['lease']   = DB::table('propmanalllease')->where('id', $leaseid)
                    ->select('*')->first();
                $currencycode = $this->getcurrencycode();
                $arr['currency'] = $currencycode;
                return view('propman.intake.add-single-lease-rate-declined')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propma.edittena', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propma.edittena', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end creating new lease-----------------*/
    /*---------------payments -----------------*/
    public function createreceipting()
    {
        try {
            $currencycode = $this->getcurrencycode();
            $arr['currency'] = $currencycode;
            $arr['lease']   = DB::table('propmanalllease')->where('available', '=', 'Y')
                ->select('*')->get();
            return view('propman.intake.lease-recepting')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function processleasepayment(Request $request)
    {
        try {
            $currentperioddate      =       Carbon::now()->format('Y-m-d');
            $trxid                  =       $this->gettransationid();
            $basecurrency           =       $this->getbasecurrency();
            switch (true) {
                case ($basecurrency == 'failed'):
                    return  redirect()->route('dash.main');
                default:
                    $basecurrency == $basecurrency;
            }
            // get payment period 
            $periodrun =  DB::table('setupperiodrun')->where('isremitlistrun', '=', 0)->select('*')->latest('id')->first();
            $receiptperiod   = DB::table('setuppropertypaymentperiod')
                ->where('openclose', '=', 'O')->select('*')->latest('id')->first();
            $currentperiod = ($periodrun === null) ? $currentperioddate : $periodrun->period;
            $periodreceipt = ($receiptperiod === null) ? $currentperiod :  $receiptperiod->period;
            //get exchange rate 
            $exchangerate = DB::table('setupcurrencyrate')->where(
                'currencycode',
                $request->receiptcurrency
            )->select('meanrate')->orderby('id', 'DESC')->first();

            /*---------check if multicurrency is enables------------------ */
            $ismulticurrency = $request->has('multicurrency');
            if ($ismulticurrency) {
                /*--------yes multi currency--------- */

                /*-------------get the arrears of the lease */
                $arrears   = DB::table('propmanleasearrearsdetails')->where(
                    'leaseid',
                    $request->lease
                )->select('*')->get();

                $remainingamount = $request->receiptamount;
                //loop through the arrears to clear the balances
                foreach ($arrears as $abc) {
                    if ($remainingamount <= 0) {
                        break;
                    } //stop if there is no balance left
                    $meanrate = (trim($abc->currencycode) == $request->receiptcurrency) ? 1 : $exchangerate->meanrate;
                    //convert the arrears balance 
                    $currentarrearbalance = $abc->balrent * $meanrate;
                    //check the amount to clear
                    $amountcleared = min($currentarrearbalance, $remainingamount);
                    // Clear the arrear
                    $currentarrearbalance -= $amountcleared;
                    $remainingamount -= $amountcleared; //reduce from input amount
                    $trxamount      = $amountcleared / $meanrate;
                    // Save the updated arrear
                    if ($currentarrearbalance <= 0) {
                        // Delete the row if cleared to zero
                        DB::table('propmanleasearrearsdetails')->where('id', $abc->id)->delete();
                    } else {
                        $currentarrearbalance /= $meanrate;
                        DB::table('propmanleasearrearsdetails')->where('id', $abc->id)
                            ->update(['balrent' => $currentarrearbalance]);
                    }
                    /*------recording all transactions---------------- */
                    DB::table('propmanleasetranscations')->insert([
                        'trxleaseid' => $request->lease,
                        'trxcurrencycode' => $abc->currencycode,
                        'trxdescription' => 'Payment',
                        'trxtype' => 'TD',
                        'trxamount' => $trxamount,
                        'trxratedamount' => $amountcleared,
                        'trxexchangerate'
                        => $meanrate,
                        'trxcreatedby' => session('alluser'),
                        'trxrefence' => $trxid
                    ]);
                    /*i Think we need to convert the remaining amount back to origin currency 
                    so we devide by meanrate
                    $remainingamount /= $meanrate; */
                } //end loop

                // Check if there's remaining amount after clearing arrears
                if ($remainingamount > 0) {
                    // Store as prepayment
                    $prepaymentamount = abs($remainingamount);
                    $existingprepayment = DB::table('propmanleaseprepayments')->where(
                        'currencycode',
                        $request->receiptcurrency
                    )->where('leaseid', $request->lease)->first();

                    $meanrate = (trim($basecurrency) === $request->receiptcurrency) ? 1 : $exchangerate->meanrate;
                    $trxratedamount      = $prepaymentamount * $meanrate;
                    if ($existingprepayment) {
                        DB::table('propmanleaseprepayments') // Replace with your actual table name
                            ->where('id', $existingprepayment->id) // Assuming `id` is the primary key
                            ->update(['balance' => $existingprepayment->balance + $prepaymentamount]);
                    } else {
                        DB::table('propmanleaseprepayments') // Replace with your actual table name
                            ->insert([
                                'leaseid' => $request->lease,
                                'balance' => $prepaymentamount,
                                'currencycode' => $request->receiptcurrency
                            ]);
                    }
                    /*------recording all transactions---------------- */
                    DB::table('propmanleasetranscations')->insert([
                        'trxleaseid' => $request->lease,
                        'trxcurrencycode' => $request->receiptcurrency,
                        'trxdescription' => 'Payment',
                        'trxtype' => 'TD',
                        'trxamount' => $prepaymentamount,
                        'trxratedamount' => $trxratedamount,
                        'trxexchangerate'
                        => $meanrate,
                        'trxcreatedby' => session('alluser'),
                        'trxrefence' => $trxid
                    ]);
                }
            } else {
                /*--------no multicurrency-------------------- */
                /*-------------get the arrears of the lease */
                $arrears   = DB::table('propmanleasearrearsdetails')->where(
                    'leaseid',
                    $request->lease
                )->where('currencycode', $request->receiptcurrency)
                    ->select('*')->get();
                $meanrate = (trim($basecurrency) === $request->receiptcurrency) ? 1 : $exchangerate->meanrate;

                $remainingamount = $request->receiptamount;
                //loop through the arrears to clear the balances
                foreach ($arrears as $abc) {
                    if ($remainingamount <= 0) {
                        break;
                    } //stop if there is no balance left
                    //check the amount to clear
                    $amountcleared = min($abc->balrent, $remainingamount);
                    // Clear the arrear
                    $abc->balrent -= $amountcleared;
                    $remainingamount -= $amountcleared; //reduce from input amount
                    $trxratedamount      = $amountcleared / $meanrate;
                    // Save the updated arrear
                    if ($abc->balrent <= 0) {
                        // Delete the row if cleared to zero
                        DB::table('propmanleasearrearsdetails')->where('id', $abc->id)->delete();
                    } else {
                        DB::table('propmanleasearrearsdetails')->where('id', $abc->id)
                            ->update(['balrent' => $abc->balrent]);
                    }
                    /*------recording all transactions---------------- */
                    DB::table('propmanleasetranscations')->insert([
                        'trxleaseid' => $request->lease,
                        'trxcurrencycode' => $request->receiptcurrency,
                        'trxdescription' => 'Payment',
                        'trxtype' => 'TD',
                        'trxamount' => $amountcleared,
                        'trxratedamount' => $trxratedamount,
                        'trxexchangerate'
                        => $meanrate,
                        'trxcreatedby' => session('alluser'),
                        'trxrefence' => $trxid
                    ]);
                } //end loop
                // Check if there's remaining amount after clearing arrears
                if ($remainingamount > 0) {
                    // Store as prepayment

                    $prepaymentamountremain = abs($remainingamount);
                    $existingprepayment = DB::table('propmanleaseprepayments')->where(
                        'currencycode',
                        $request->receiptcurrency
                    )->where('leaseid', $request->lease)->first();

                    $trxratedamount      = $prepaymentamountremain * $meanrate;

                    if ($existingprepayment) {
                        $prepaymentamount = $existingprepayment->balance + $prepaymentamountremain;
                        DB::table('propmanleaseprepayments')
                            ->where('id', $existingprepayment->id)
                            ->update(['balance' => $prepaymentamount]);
                    } else {
                        DB::table('propmanleaseprepayments')
                            ->insert([
                                'leaseid' => $request->lease,
                                'balance' => $prepaymentamountremain,
                                'currencycode' => $request->receiptcurrency
                            ]);
                    }
                    /*------recording all transactions---------------- */
                    DB::table('propmanleasetranscations')->insert([
                        'trxleaseid' => $request->lease,
                        'trxcurrencycode' => $request->receiptcurrency,
                        'trxdescription' => 'Payment',
                        'trxtype' => 'TD',
                        'trxamount' => $prepaymentamountremain,
                        'trxratedamount' => $trxratedamount,
                        'trxexchangerate'
                        => $meanrate,
                        'trxcreatedby' => session('alluser'),
                        'trxrefence' => $trxid
                    ]);
                }
            }
            /*--------post the payment as is */
            DB::table('propmanleasereceipts')->insert([
                'receiptnumber' => $trxid,
                'leaseid' => $request->lease,
                'currencycode' => $request->receiptcurrency,
                'amountpaid' => $request->receiptamount,
                'receiptdate' => $request->receiptdate,
                'operatorid' => session('alluser'),
                'period' => $periodreceipt,
                'receiptreference' => $request->receiptreference,
                'multicurrency' => $ismulticurrency
            ]);
            /*---------end check if multicurrency is enables------------------ */
            return  redirect()->route('propin.payment')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('propin.payment')
                ->with('error', 'failed to load');
        }
    }
    /*---------------end payments -----------------*/
    public function createrentroll()
    {
        try {
            $arr['remit']   = DB::table('propmanremitpre')->select('*')->where('status', 'N')->get();
            return view('propman.intake.list-preremittance')
                ->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewpropertypreroll($id)
    {
        try {
            $remitid = Crypt::decrypt($id);
            try {
                $arr['roll'] = DB::table('propmanremitpre')->where('id', $remitid)->select('*')->first();
                $arr['property'] = DB::table('propmanallproperty')->where(
                    'id',
                    $arr['roll']->propertyid
                )->select('*')->first();
                $leaseids = DB::table('propmanalllease')->where('propertyid', $arr['roll']->propertyid)->pluck('id');
                $arr['bank'] = DB::table('propmanlandlordbank')->where([[
                    'landlordid',
                    $arr['roll']->landlordid
                ], ['available', 'Y'], ['currencycode', $arr['roll']->currencycode]])->select('*')->get();
                $arr['invoice'] = DB::table('propmaninvoicegenerated')->whereIn('leaseid', $leaseids)
                    ->where([['period', $arr['roll']->period], ['currencycode', $arr['roll']->currencycode]])
                    ->select('*')->get();
                $arr['receipt']   = DB::table('propmanleasereceipts')
                    ->select('propmanalllease.tenantcompanyname', 'propmanalllease.tenantfullname', 'propmanleasereceipts.*')
                    ->join('propmanalllease', 'propmanalllease.id', '=', 'propmanleasereceipts.leaseid')
                    ->where('propmanalllease.propertyid', $arr['roll']->propertyid)
                    ->where([['propmanleasereceipts.period', $arr['roll']->period], ['propmanleasereceipts.currencycode', $arr['roll']->currencycode]])->get();

                return view('propman.intake.prepare-rent-roll')
                    ->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propin.preremit')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propin.preremit')
                ->with('error', 'failed to load');
        }
    }
    public function addnewrentrol($id, Request $request)
    {
        try {
            $remitid = Crypt::decrypt($id);
            try {
                $totaldeduction = $request->interest + $request->commission +
                    $request->rates + $request->operationalcost + $request->vat + $request->securitycharge +
                    $request->caretakercharge + $request->otherexpensecharge;

                $update = ['deductsecurity' => $request->securitycharge, 'deductcaretaker' =>
                $request->caretakercharge, 'deductother' => $request->otherexpensecharge, 'deductcommission' =>
                $request->commission, 'operatorid' => session('alluser'), 'completedon' => now(), 'status' => 'Y'];
                DB::table('propmanremitpre')->where('id', $remitid)->update($update);
                return redirect()->route('propin.preremit')
                    ->with('success', 'record created');
            } catch (\Throwable $th) {
                return redirect()->route('propin.preremit')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propin.preremit')
                ->with('error', 'failed to load');
        }
    }
    function preremitpdf($remitid)
    {
        $id = Crypt::decrypt($remitid);
        try {
            $property = DB::table('propmanremitpre')->where('id', $id)->select('*')->first();
            $lease = DB::select('EXEC  spGetPropManPropertyPreRollSummary ?,?,?', [$property->propertyid, $property->currencycode, $property->period]);
        } catch (\Throwable $th) {
            return  redirect()->route('propin.preremit')
                ->with('error', 'failed to report' . $th);
        }

        // Create new PDF document
        $pdf = new pdfreport(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //header title
        $pdf->setHeaderTitle('remittance-summary');
        //document information 
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetHeaderData(PDF_HEADER_LOGO, 19);
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // Enable auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $rows = '';
        $count = 1; // Initialize count
        $totalbilled = number_format($property->totalbilled, 2, '.', ',');
        $totalreceipts = number_format($property->totalreceipts, 2, '.', ',');
        foreach ($lease as $abc) {
            $totalamountbilled = number_format($abc->totalamountbilled, 2, '.', ',');
            $totalreceipts = number_format($abc->totalreceipts, 2, '.', ',');
            $rows .= '<tr>';
            $rows .= '<td>' . ($count++) . '</td>';
            $rows .= "<td>{$abc->propertydescription}</td>";
            $rows .= "<td>{$abc->tenantcompanyname} {$abc->tenantfullname}</td>";
            $rows .= "<td>{$abc->validfrom}</td>";
            $rows .= "<td>{$abc->validto}</td>";
            $rows .= "<td class=\"right-align\">{$totalamountbilled} </td>";
            $rows .= "<td class=\"right-align\">{$totalreceipts} </td>";
            $rows .= '</tr>';
        }
        // Add a page
        $pdf->AddPage();
        $tbl =  <<<EOD
        <style>
            body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 0.5px solid #ccc;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #e2e2e2;
        }
        h2 {
            color: #333;
        }
        #summary {
            font-weight: bold;
            margin-top: 10px;
        }.right-align {text-align: right; }
        </style>
        <body>
        <h3>Rent Summary</h3>
            <h5>{$property->propertyaddress} ({$property->currencycode})</h5>
            <table>
             <tr>
                <th style="width:5%"><strong>No</strong></th>
                <th style="width:23%"><strong>Unit</strong></th>
                <th style="width:16%"><strong>Tenant</strong></th>
                <th style="width:14%"><strong>From</strong></th>
                <th style="width:14%"><strong> Til</strong></th>
                <th style="width:14%"><strong>Billed</strong></th>
                <th style="width:14%"><strong>Receipts</strong></th>
            </tr>
            $rows
            <tr>
                <td colspan="5" id="summary"><strong>Total</strong></td>
                <td id="summary" class="right-align"><strong> {$totalbilled}</strong></td>
                <td id="summary" class="right-align"><strong> {$totalreceipts}</strong></td>
            </tr>
            </table></body>
        EOD;
        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->Output($property->propertyaddress . '_remittance.pdf', 'D');
    }
    /*---------------end pre-remittance -----------------*/
}
