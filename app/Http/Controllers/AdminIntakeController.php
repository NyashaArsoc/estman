<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        DB::beginTransaction();
        try {
            $approver = json_decode($request->approversorder, true);
            $tablename = 'adminrequisitiondetails';

            $requisitionnumber =  DB::table('adminrequisition')->insertGetId([
                'requisitiontype' => $request->requisitiontype,
                'approvalsequency' => $request->approvalmode,
                'currencycode' => $request->currencycode,
                'description' => $request->description,
                'justification' => $request->justification,
                'operatorid' => session('alluser')
            ]);
            if ($request->requisitiontype === 'product') {
                $item       = $request->productitem ?? [];
                $quantity   = $request->productqty ?? [];
                $vat        = $request->productvat ?? [];
                $totalprice = $request->producttotal ?? [];
                $rate       = $request->productrate ?? [];
            } elseif ($request->requisitiontype === 'service') {
                $item       = $request->serviceitem ?? [];
                $quantity   = [];
                $vat        = $request->servicevat ?? [];
                $totalprice = $request->servicetotal ?? [];
                $rate       = $request->servicerate ?? [];
            }
            foreach ($rate as $abc => $rate) {
                $tablearray = [
                    'requisitionnumber' => $requisitionnumber,
                    'item' => $item[$abc] ?? null,
                    'quantity' => $quantity[$abc] ?? null,
                    'vat' => $vat[$abc] ?? 0,
                    'totalprice' => $totalprice[$abc] ?? 0,
                    'rate' => $rate ?? 0,
                ];

                DB::table($tablename)->insert($tablearray);
            }
            foreach ($approver as $abc) {
                $usermail  = DB::table('systusers')->where('id', $abc['id'])->select('*')->first();
                DB::table('adminrequisitionapproval')->insert([
                    'requisitionnumber' => $requisitionnumber,
                    'approverid' => $abc['id']
                ]);
                $mymessage = 'Requisition for: ' . $request->description . ' is pending for approval';
                Mail::html("<p>$mymessage</p>", function ($message) use ($usermail, $requisitionnumber) {
                    $message->to($usermail->email)
                        ->subject('Request For Approval Order No: ORD-' . $requisitionnumber);
                });
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
            DB::commit();
            return  redirect()->route('admin.request')
                ->with('success', 'record added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.request')
                ->with('error', 'failed to load');
        }
    }
}
