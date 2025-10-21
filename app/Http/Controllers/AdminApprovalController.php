<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminApprovalController extends Controller
{
    function listallrequisitionpending()
    {
        try {
            $user = $this->userdetail();
            $arr['order']    = DB::select('EXEC sp_GetAdminPendingOrderRequisitions ?', [$user->id]);
            return view('admin.approval.list-requisition-pending')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('dash.admin')
                ->with('error', 'failed to load');
        }
    }
    function viewsignlerequisitionpending($id)
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
            return view('admin.approval.requisition-view')->with($arr);
        } catch (\Throwable $th) {
            return redirect()->route('admapp.lstreqapp')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('admapp.lstreqapp')
                ->with('error', 'failed to load');
        }
    }
    function downloadattachments($path)
    {
        try {
            $filename = Crypt::decrypt($path);
            //check the existance of receipt first
            if (!Storage::disk('public')->exists("documents/admin/requisition/quotes/{$filename}")) {
                return abort(404);
            }
            return response()->download(storage_path("app/public/documents/admin/requisition/quotes/{$filename}"));
        } catch (DecryptException $th) {
            return redirect()->route('dash.admin');
        }
    }
}
