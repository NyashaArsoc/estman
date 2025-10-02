<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    public function requisitionApproval()
{
    return view('admin.approval.requisition-approval');
}

public function requisitionView()
{
    return view('admin.approval.requisition-view');
}

}
