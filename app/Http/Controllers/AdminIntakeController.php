<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminIntakeController extends Controller
{
    function paymentrequest()
    {
        try {
            $currencycode = $this->getcurrencycode();
            $arr['staff']   = DB::table('systusers')->where('isavailable', 'Y')->where('username', '!=', 'admin')
                ->select('*')->get();
            $arr['currency'] = $currencycode;
            return view('admin.intake.payment-request')->with($arr);
        } catch (\Throwable $th) {
            return  redirect()->route('dash.admin');
        }
    }
    function createrequisition(Request $request)
    {
        try {
            $approver = json_decode($request->approversorder, true);
            $productrate = (!empty($request->productrate)) ? $request->productrate : [0];
            $servicerate = (!empty($request->servicerate)) ? $request->servicerate : [0];
            $a  = 0;
            $requisitionnumber =  DB::table('adminrequisition')->insertGetId([
                'requisitiontype' => $request->requisitiontype,
                'approvalsequency' => $request->approvalmode,
                'currencycode' => $request->currencycode,
                'description' => $request->description,
                'justification' => $request->justification,
                'operatorid' => session('alluser')
            ]);
            if ($request->requisitiontype === 'product') {
                $arraytotal =       count($productrate);
                $tablearray = [
                    'requisitionnumber' => $requisitionnumber,
                    'item' => $request->productitem[$a],
                    'quantity' => $request->productqty[$a],
                    'vat' => $request->productvat[$a],
                    'totalprice' => $request->producttotal[$a],
                    'rate' => $request->productrate[$a]
                ];
                $tablename = 'adminrequisitiondetails';
            } elseif ($request->requisitiontype === 'service') {
                $arraytotal =       count($servicerate);
                $tablearray = [
                    'requisitionnumber' => $requisitionnumber,
                    'item' => $request->serviceitem[$a],
                    'vat' => $request->servicevat[$a],
                    'totalprice' => $request->servicetotal[$a],
                    'rate' => $request->servicerate[$a]
                ];
                $tablename = 'adminrequisitiondetails';
            }
            foreach ($approver as $abc) {
                DB::table('adminrequisitionapproval')->insert([
                    'requisitionnumber' => $requisitionnumber,
                    'approverid' => $abc['id']
                ]);
            }
            while ($a   <   $arraytotal) {
                DB::table($tablename)->insert($tablearray);
                $a++;
            }
            if ($request->hasFile('quotations')) {
                foreach ($request->file('quotations') as $abc) {
                    $otherattachment = $request->file('quotations');
                    $otherattachment->storeAs('public/documents/admin/requisition/quotes', $otherattachment);
                    DB::table('adminrequisitionapproval')->insert([
                        'requisitionnumber' => $requisitionnumber,
                        'attachment' => $abc->getClientOriginalName()
                    ]);
                }
            }

            return  redirect()->route('admin.request')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            return redirect()->route('admin.request')
                ->with('error', 'failed to load' . $th);
        }
    }
    public function form()
    {
        return view('admin.intake.requisition-form');
    }
}
