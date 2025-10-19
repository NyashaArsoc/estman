<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

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

            return view('admin.approval.requisition-view');
        } catch (\Throwable $th) {
            return redirect()->route('admapp.lstreqapp')
                ->with('error', 'failed to load');
        } catch (DecryptException $th) {
            return redirect()->route('admapp.lstreqapp')
                ->with('error', 'failed to load');
        }
    }
    public function requisitionView()
    {
        return view('admin.approval.requisition-view');
    }
}
