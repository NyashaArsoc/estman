<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // Show requisition list
    public function showManagePage()
    {
        $requisitions = DB::table('adminrequisition')->get();

        // Layout compatibility variables
        $adminintake = [];
        $adminapprove = [];
        $admindecline = [];
        $adminmanage = [];
        $user = (object)['firstname' => 'Shania', 'lastname' => 'Nyaude'];

        return view('admin.manage.manage-requisition', compact(
            'requisitions',
            'adminintake',
            'adminapprove',
            'admindecline',
            'adminmanage',
            'user'
        ));
    }

    // View requisition details
    public function viewRequisition($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $order = DB::table('adminrequisition')->where('id', $decryptedId)->first();
        $orderdetails = DB::table('adminrequisitiondetails')->where('requisitionnumber', $decryptedId)->get();
        $orderapproval = DB::table('adminrequisitionapproval')->where('requisitionnumber', $decryptedId)->get();
        $orderattachment = DB::table('adminrequisitionattachment')->where('requisitionnumber', $decryptedId)->get();

        // Layout compatibility variables
        $adminintake = [];
        $adminapprove = [];
        $admindecline = [];
        $adminmanage = [];
        $user = (object)['firstname' => 'Shania', 'lastname' => 'Nyaude'];

        return view('admin.manage.manage-requisition-view', compact(
            'order',
            'orderdetails',
            'orderapproval',
            'orderattachment',
            'adminintake',
            'adminapprove',
            'admindecline',
            'adminmanage',
            'user'
        ));
    }

    // Download requisition as PDF
    public function downloadRequisition($id)
    {
        $decryptedId = Crypt::decrypt($id);

        $order = DB::table('adminrequisition')->where('id', $decryptedId)->first();
        $orderdetails = DB::table('adminrequisitiondetails')->where('requisitionnumber', $decryptedId)->get();
        $orderapproval = DB::table('adminrequisitionapproval')->where('requisitionnumber', $decryptedId)->get();
        $orderattachment = DB::table('adminrequisitionattachment')->where('requisitionnumber', $decryptedId)->get();

        // Corrected view path for PDF generation
        $pdf = Pdf::loadView('admin.approval.pdf.order-pdf', compact(
            'order',
            'orderdetails',
            'orderapproval',
            'orderattachment'
        ));

        return $pdf->download('ORD-' . $decryptedId . '.pdf');
    }
}
