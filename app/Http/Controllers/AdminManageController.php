<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Encryption\DecryptException;

class AdminManageController extends Controller
{
    function listallorders()
    {
        try {
            $arr['order']    = DB::table('adminallorder')->get();
            return view('admin.manage.manage-requisition')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('dash.admin');
        }
    }
    function singleorderrequisition($id)
    {
        try {
            $orderno = Crypt::decrypt($id);
            $arr['order']   = DB::table('adminrequisition')->where('id', $orderno)->first();
            $arr['orderdetails']   = DB::table('adminrequisitiondetails')->where('requisitionnumber', $orderno)->get();
            $arr['orderattachment']   = DB::table('adminrequisitionattachment')->where('requisitionnumber', $orderno)->get();
            $arr['orderapproval'] = DB::table('adminrequisitionapproval')->join('systusers', 'adminrequisitionapproval.approverid', '=', 'systusers.id')
                ->where('adminrequisitionapproval.requisitionnumber', $orderno)->select(
                    'adminrequisitionapproval.action',
                    'adminrequisitionapproval.actiondate',
                    'adminrequisitionapproval.status',
                    'systusers.firstname',
                    'systusers.lastname'
                )->get();
            return view('admin.manage.manage-requisition-view')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('admin.allorder')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('admin.allorder')
                ->with('error', 'failed to load');
        }
    }
    function downloadorderrequisition($id)
    {
        try {
            $orderno = Crypt::decrypt($id);
            $arr['order']   = DB::table('adminrequisition')->where('id', $orderno)->first();
            $arr['orderdetails']   = DB::table('adminrequisitiondetails')->where('requisitionnumber', $orderno)->get();
            $arr['usermail']  = DB::table('systusers')->where('username', $arr['order']->operatorid)->select('*')->first();

            $arr['orderapproval'] = DB::table('adminrequisitionapproval')->join('systusers', 'adminrequisitionapproval.approverid', '=', 'systusers.id')
                ->where('adminrequisitionapproval.requisitionnumber', $orderno)->select(
                    'adminrequisitionapproval.action',
                    'adminrequisitionapproval.actiondate',
                    'adminrequisitionapproval.status',
                    'systusers.firstname',
                    'systusers.lastname'
                )->get();
            // return $arr;
            $orderpdf =   PDF::loadView('admin/approval/pdf/order-pdf', $arr);
            return $orderpdf->download('ORD-' . $orderno . '.pdf');
        } catch (\Throwable $th) {
            return redirect()->route('admin.allorder')
                ->with('error', 'failed to download');
        } catch (DecryptException $th) {
            return redirect()->route('admin.allorder')
                ->with('error', 'failed to download');
        }
    }
}
