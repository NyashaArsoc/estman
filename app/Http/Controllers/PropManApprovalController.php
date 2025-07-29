<?php

namespace App\Http\Controllers;

use App\Traits\HandlingMail;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PropManApprovalController extends Controller
{
    use HandlingMail;
    /*---------------approval new landlord-----------------*/
    public function listlandlordapproval()
    {
        try {
            $arr['landlord']   = DB::table('propmanalllandlord')
                ->where('approval', '=', 'N')
                ->select('*')->get();
            return view('propman.approval.list-landlord-pending-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewlandlordapproval($id)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                $arr['landlord']   = DB::table('propmanalllandlord')
                    ->where('id', $landlordid)->select('*')->first();
                $arr['contact']   = DB::table('propmanlandlordcontact')
                    ->where('landlordid', $landlordid)
                    ->select('*')->latest('id')->first();
                $arr['bank']   = DB::table('propmanlandlordbank')->where('landlordid', $landlordid)
                    ->select('*')->get();
                return view('propman.approval.view-single-landlord-approval')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listland')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listland')
                ->with('error', 'failed to load');
        }
    }
    public function approvenewsinglelandlordapproval($id)
    {
        try {
            $landlordid = Crypt::decrypt($id);
            try {
                DB::table('propmanlandlord')
                    ->where('id', $landlordid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'approvedon' => now()
                    ]);
                DB::table('propmanlandlordcontact')
                    ->where('landlordid', $landlordid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'approvedon' => now()
                    ]);
                return  redirect()->route('propapp.listland')
                    ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewland', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.viewland', $id)
                ->with('error', 'failed to load');
        }
    }
    public function listlandlordcontactapproval()
    {
        try {
            $arr['contact']   = DB::table('propmanlandlordcontact')
                ->select('propmanalllandlord.fullname', 'propmanalllandlord.companyname', 'propmanlandlordcontact.*')
                ->join('propmanalllandlord', 'propmanlandlordcontact.landlordid', '=', 'propmanalllandlord.id')
                ->where('propmanlandlordcontact.approval', '=', 'N')->get();
            return view('propman.approval.list-landlord-contact-pending-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function approvenewlandlordcontact($id)
    {
        try {
            $contactid = Crypt::decrypt($id);
            try {
                DB::table('propmanlandlordcontact')->where('id', $contactid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'approvedon' => now()
                    ]);
                return  redirect()->route('propapp.listlandcont')
                    ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.landcont', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.landcont', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end approval new landlord-----------------*/
    /*---------------approval new property-----------------*/
    public function listpropertyapproval()
    {
        try {
            $arr['property']   = DB::table('propmanallproperty')
                ->where('approval', '=', 'N')
                ->select('*')->get();
            return view('propman.approval.list-property-pending-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewpropertyapproval($id)
    {
        try {
            $propertyid = Crypt::decrypt($id);
            try {
                $arr['property']   = DB::table('propmanallproperty')
                    ->where('id', $propertyid)->select('*')->first();
                return view('propman.approval.view-single-property-approval')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listprop')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listprop')
                ->with('error', 'failed to load');
        }
    }
    public function downloadmandatepdf($path)
    {
        try {
            $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/mandate/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/prop/mandate/{$filename}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.property');
        }
    }
    public function downloadotherpdf($path)
    {
        try {
            $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/other/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("public/documents/prop/other/{$filename}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.property');
        }
    }
    public function downloadleaseagreementpdf($path)
    {
        try {
            $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/prop/lease/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/prop/lease/{$filename}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.property');
        }
    }
    public function approvenewproperty($id)
    {
        try {
            $propertyid = Crypt::decrypt($id);
            try {
                DB::table('propmanproperty')
                    ->where('id', $propertyid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'dateapproved' => now()
                    ]);
                return  redirect()->route('propapp.listprop')
                    ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewprop', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.viewprop', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end approval new property-----------------*/
    /*---------------approval new tenant-----------------*/
    public function listtenantapproval()
    {
        try {
            $arr['tenant']   = DB::table('propmanalltenant')
                ->where('approval', '=', 'N')
                ->select('*')->get();
            return view('propman.approval.list-tenent-pending-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewtenantapproval($id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                $arr['tenant']   = DB::table('propmanalltenant')
                    ->where('id', $tenantid)->select('*')->first();
                $arr['contact']   = DB::table('propmantenantcontact')
                    ->where('tenantid', $tenantid)
                    ->select('*')->latest('id')->first();
                $arr['keen']   = DB::table('propmantenantkeen')
                    ->where('tenantid', $tenantid)
                    ->select('*')->latest('id')->first();
                return view('propman.approval.view-single-tenant-approval')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listten')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listten')
                ->with('error', 'failed to load');
        }
    }
    public function approvenewtenant($id)
    {
        try {
            $tenantid = Crypt::decrypt($id);
            try {
                DB::table('propmantenant')
                    ->where('id', $tenantid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'dateapproved' => now()
                    ]);
                return  redirect()->route('propapp.listten')
                    ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewten', $id)
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.viewten', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end approval new tenant-----------------*/
    /*---------------approval new lease-----------------*/
    public function listleaseapproval()
    {
        try {
            $arr['lease']   = DB::table('propmanalllease')
                ->where('approval', '=', 'N')
                ->select('*')->get();
            return view('propman.approval.list-lease-pending-approval')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewleaseapproval($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $arr['lease']   = DB::table('propmanalllease')
                    ->where('id', $leaseid)->select('*')->first();
                $arr['prepay']   = DB::table('propmantempleaseprepayments')->where('leaseid', $leaseid)
                    ->select('*')->get();
                $arr['balance']   = DB::table('propmantempleasearrearsdetails')->where('leaseid', $leaseid)
                    ->select('*')->get();
                $arr['rates']   = DB::table('propmantempleasecurrentbillrates')->where('leaseid', $leaseid)
                    ->select('*')->get();

                return view('propman.approval.view-single-lease-approval')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listlea')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listlea')
                ->with('error', 'failed to load');
        }
    }
    public function approvenewlease($id)
    {
        try {
            $leaseid = Crypt::decrypt($id);
            try {
                $arr['prepay']   = DB::table('propmantempleaseprepayments')->where('leaseid', $leaseid)
                    ->select('*')->get();
                $arr['balance']   = DB::table('propmantempleasearrearsdetails')->where('leaseid', $leaseid)
                    ->select('*')->get();
                $lease   = DB::table('propmanalllease')->where('id', $leaseid)
                    ->select('*')->first();
                $property   = DB::table('propmanproperty')->where('id', $lease->propertyid)
                    ->select('*')->first();
                $areatolet = collect(DB::select(
                    'EXEC  spGetPropManLeaseAreaToLet ?',
                    [$lease->propertyid]
                ))->first();

                $prepay = count($arr['prepay']);
                $balance = count($arr['balance']);
                //check if the property is fully occupied 
                if (trim($property->occupation) == 'F') {
                    return redirect()->route('propapp.viewlease', $id)
                        ->with('error', 'property fully occupied');
                }
                //check if there is a +ve and -ve balance at the sametime
                if ($prepay > 0 and $balance > 0) {
                    return redirect()->route('propapp.viewlease', $id)
                        ->with('error', 'clear arrear/prepay to continue');
                }
                if ($areatolet !== null) {
                    //check if the area to be allocated is enough with space remaining for commercial
                    if ($areatolet->areatolet - $lease->areataken  < 0) {
                        return redirect()->route('propapp.viewlease', $id)
                            ->with('error', 'space not enough to allocate');
                    }
                }
                DB::select('EXEC spPostPropManLeaseRatesArrearPrepay ?', [$leaseid]);

                DB::table('propmanlease')->where('id', $leaseid)
                    ->update([
                        'approval' => 'Y',
                        'available' => 'Y',
                        'approvedby' => session('alluser'),
                        'dateapproved' => now()
                    ]);
                //update occupation status on the property
                switch (trim($lease->propertytypeid)) {
                    case 1:
                        DB::table('propmanproperty')->where('id', $lease->propertyid)
                            ->update(['occupation' => 'F']);
                    default:
                        if ($areatolet !== null) {
                            if ($areatolet->areatolet - $lease->areataken  = 0) {
                                DB::table('propmanproperty')->where('id', $lease->propertyid)
                                    ->update(['occupation' => 'F']);
                            }
                        }
                        DB::table('propmanproperty')->where('id', $lease->propertyid)
                            ->update(['occupation' => 'P']);
                }
                return  redirect()->route('propapp.listlea')
                    ->with('success', 'record approved');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.viewlease', $id)
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.viewlease', $id)
                ->with('error', 'failed to load');
        }
    }
    /*---------------end approval new lease-----------------*/
    /*----------------------invoicing */
    public function listallpreinvoice()
    {
        try {
            $arr['invoice']   = DB::table('propmaninvoicepre')
                ->where('isedited', '=', 'N')
                ->select('*')->get();
            return view('propman.approval.list-pre-invoice')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    public function viewinvoicebilled($id)
    {
        try {
            $invoiceid = Crypt::decrypt($id);
            try {
                $arr['invoice']   = DB::table('propmaninvoicepre')
                    ->where('id', $invoiceid)->select('*')->first();
                $arr['lease']   = DB::table('propmanalllease')->where('id', $arr['invoice']->leaseid)
                    ->select('*')->first();
                return view('propman.approval.view-single-invoice-billed')->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listpre')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listpre')
                ->with('error', 'failed to load');
        }
    }
    public function approvalpreinvoice($id)
    {
        try {
            $invoiceid = Crypt::decrypt($id);
            try {
                $systmail = $this->getmails('prop', 'to');
                if ($systmail == 'failed') {
                    return redirect()->route('propapp.listpre')
                        ->with('error', 'system email not set');
                }
                //get the invoice details
                $invoice   = DB::table('propmaninvoicepre')
                    ->where('id', $invoiceid)->select('*')->first();
                $tenant = DB::table('propmanalllease')->join(
                    'propmanalltenant',
                    'propmanalllease.tenantid',
                    '=',
                    'propmanalltenant.id'
                )->select(
                    'propmanalltenant.email',
                    'propmanalltenant.vatnumber',
                    'propmanalltenant.tinnumber',
                    'propmanalllease.propertyid'
                )->where(
                    'propmanalllease.id',
                    $invoice->leaseid
                )->first();
                $vatpercent   = DB::table('setupvatconfig')
                    ->where('propertytypeid', $tenant->propertyid)->select('*')->first();
                //tenant name 
                $tenantname     = "{$invoice->companyname} {$invoice->fullname}";
                //totals
                $rentbeforevat     = $invoice->rental - $invoice->vat;
                $totalbilledexc = $rentbeforevat + $invoice->rates + $invoice->operationalcost
                    + $invoice->interest;
                $totalvatincl = $rentbeforevat + $invoice->rates + $invoice->operationalcost +
                    $invoice->interest + $invoice->vat;
                $invoicetotal = $rentbeforevat + $invoice->rates + $invoice->operationalcost +
                    $invoice->interest + $invoice->vat + $invoice->balancebd;


                //invoice data
                $arr["email"]               = $systmail;
                $arr["ccemail"]             = $tenant->email;
                $arr["title"]               = "Invoice for $tenantname";
                $arr["invoicetitle"]        = "Invoice";
                $arr["tenantname"]          = $tenantname;
                $arr["propdesc"]            = $invoice->propertydescription;
                $arr["period"]              = $invoice->period;
                $arr["tenantvatnumber"]     = $tenant->vatnumber;
                $arr["tenanttinnumber"]     = $tenant->tinnumber;
                $arr["invoicenumber"]       = $invoice->id;
                $arr["currencycode"]        = $invoice->currencycode;
                $arr["balancebd"]           = number_format($invoice->balancebd, 2);
                $arr["rent"]                = number_format($invoice->rental, 2);
                $arr["rateswater"]          = number_format($invoice->rates, 2);
                $arr["interestcharged"]     = number_format($invoice->interest, 2);
                $arr["operational"]         = number_format($invoice->operationalcost, 2);
                $arr["rentvat"]             = number_format($invoice->vat, 2);
                $arr["rentbeforevat"]       = number_format($rentbeforevat, 2);
                $arr["totalbilledexc"]      = number_format($totalbilledexc, 2);
                $arr["totalvatincl"]        = number_format($totalvatincl, 2);
                $arr["invoicetotal"]        = number_format($invoicetotal, 2);
                $arr['today']               = date('d-M-Y');
                $arr["deposit"]             = number_format($invoice->deposit, 2);


                //convert to pdf
                $invoicepdf =   PDF::loadView('tomail/invoice', $arr);
                //mail the invoice
                Mail::raw('Monthly Invoice.', function ($message) use ($arr, $invoicepdf) {
                    $message->to('systemreports@arsoc.co.zw')
                        ->subject($arr["period"] . ' Invoice')
                        ->attachData($invoicepdf->output(), '' . $arr["title"] . '.pdf');
                });
                //post data into invoices & arrear details and clear preinvoice 
                DB::select(
                    'EXEC spPostPropManInvoiceAndArrears ?,?',
                    [$invoiceid, session('alluser')]
                );

                return redirect()->route('propapp.listpre')
                    ->with('success', 'invoice send');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.listpre')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.listpre')
                ->with('error', 'failed to load');
        }
    }
    /*--------------------end invoicing */
    function createrentroll()
    {
        try {
            $arr['roll']   = DB::table('propmanremitpre')->select('*')->where('status', 'Y')->get();
            return view('propman.approval.list-rent-roll')
                ->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.property');
        }
    }
    function addscheduleremit($id)
    {
        try {
            $remitid = Crypt::decrypt($id);
            try {
                $arr['roll'] = DB::table('propmanremitpre')->where('id', $remitid)->select('*')->first();
                $arr['property'] = DB::table('propmanallproperty')->where('id', $arr['roll']->propertyid)->select('*')->first();
                $arr['arrears'] = DB::table('propmanremitarrearsdetails')->where('propertyid', $arr['roll']->propertyid)->where('currencycode', $arr['roll']->currencycode)
                    ->select('*')->first();
                $arr['arrear'] = $arr['arrears'] ? $arr['arrears']->balremit : 0;
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

                return view('propman.approval.prepare-rent-roll')
                    ->with($arr);
            } catch (\Throwable $th) {
                return redirect()->route('propapp.preroll')
                    ->with('error', 'failed to load');
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.preroll')
                ->with('error', 'failed to load');
        }
    }
    function processremittance($id, Request $request)
    {
        try {
            $remitid = Crypt::decrypt($id);
            try {
                $roll = DB::table('propmanremitpre')->where('id', $remitid)->select('*')->first();
                /*-------------get the arrears of the lease */
                $arrears   = DB::table('propmanremitarrearsdetails')->where(
                    'propertyid',
                    $roll->propertyid
                )->where('currencycode', $roll->currencycode)->select('*')->first();
                $toremit = $request->remitbd + $request->toremit;
                if ($toremit < 0 && $request->amountremit <> 0) {
                    return redirect()->route('propapp.addremit', $id)
                        ->with('error', 'overpayment denied');
                }
                $remitbalance = $toremit - $request->amountremit;
                $trxid                  =       $this->gettransationid();
                $basecurrency           =       $this->getbasecurrency();
                if ($remitbalance < 0 && $request->amountremit <> 0) {
                    return redirect()->route('propapp.addremit', $id)
                        ->with('error', 'overpayment denied');
                }
                switch (true) {
                    case ($basecurrency == 'failed'):
                        return redirect()->route('dash.main');

                    case (trim($basecurrency) === trim($roll->currencycode)):
                        $meanrate = 1;
                        break;

                    default:
                        $exchangerate = DB::table('setupcurrencyrate')->where('currencycode', $roll->currencycode)->where('ratedate', $request->datestamp)
                            ->select('meanrate')->orderBy('id', 'DESC')->first();

                        if ($exchangerate) {
                            $meanrate = $exchangerate->meanrate;
                        } else {
                            return redirect()->route('propapp.addremit', $id)
                                ->with('error', 'Exchange rate not found');
                        }
                        break;
                }

                //check the amount to clear
                if ($toremit < 0) {
                    $amountcleared = min($toremit, $request->amountremit);
                    $toremit = $toremit;
                } else {
                    $amountcleared = min($toremit, $request->amountremit);
                    $toremit -= $amountcleared;
                }
                $trxdescription = 'Remittance for ' . $roll->propertyaddress;
                $trxratedamount      = ($amountcleared / $meanrate) * -1;

                if ($toremit == 0) {
                    DB::table('propmanremitarrearsdetails')->where('id', $arrears->id)->delete();
                }
                DB::table('propmanremitarrearsdetails')->updateOrInsert(
                    ['propertyid' => $roll->propertyid, 'currencycode' => $roll->currencycode],
                    ['balremit' => $toremit, 'operatorid' => session('alluser')]
                );

                DB::table('propmanremittranscations')
                    ->insert([
                        'trxrefence' => $trxid,
                        'trxpropertyid' => $roll->propertyid,
                        'trxtype' => 'TC',
                        'trxcurrencycode' => $roll->currencycode,
                        'trxdescription' => $trxdescription,
                        'trxamount' => $amountcleared,
                        'trxratedamount' => $trxratedamount,
                        'trxexchangerate' => $meanrate,
                        'trxcreatedby' => session('alluser')
                    ]);
                if ($roll) {
                    $data = [
                        'propertyid' => $roll->propertyid,
                        'landlordid' => $roll->landlordid,
                        'period' => $roll->period,
                        'propertyaddress' => $roll->propertyaddress,
                        'fullname' => $roll->fullname,
                        'companyname' => $roll->companyname,
                        'currencycode' => $roll->currencycode,
                        'rental' => $roll->rental,
                        'rates' => $roll->rates,
                        'operationalcost' => $roll->operationalcost,
                        'vat' => $roll->vat,
                        'interest' => $roll->interest,
                        'billed' => $roll->totalbilled,
                        'receipts' => $roll->totalreceipts,
                        'security' => $roll->deductsecurity,
                        'caretaker' => $roll->deductcaretaker,
                        'other' => $roll->deductother,
                        'commission' => $roll->deductcommission,
                        'toremit' => $toremit,
                        'operatorid' => session('alluser'),
                        'completedon' => $roll->completedon,
                        'balancebd' => $roll->balancebd,
                        'deductions' => $roll->totaldeductions,
                        'trxrefence' => $trxid,
                        'completedby' => $roll->operatorid
                    ];
                    DB::table('propmanremittance')->insert($data);
                    DB::table('propmanremitpre')->where('id', $remitid)->delete();
                }

                return redirect()->route('propapp.preroll')
                    ->with('success', 'record processed');
            } catch (\Throwable $th) {
                return redirect()->route('propapp.addremit', $id)
                    ->with('error', 'failed to load' . $th);
            }
        } catch (DecryptException $th) {
            return redirect()->route('propapp.addremit', $id)
                ->with('error', 'failed to load');
        }
    }
    /*-------------end rent roll */
}
