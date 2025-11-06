<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LandlordApprovalExport;

class DiaryReportController extends Controller
{
    private function sharedLayoutData()
    {
        return [
            'user' => Auth::user() ?? (object)[
                'firstname' => '',
                'lastname' => '',
            ],
            'propmanintake' => DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanintake']),
            'propmanapprove' => DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanapprove']),
            'propmandecline' => DB::select("EXEC spGetMenuList ?, ?", [1, 'propmandecline']),
            'propmanmanage' => DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanmanage']),
        ];
    }

    // Dashboard view showing all diary categories
    public function dashboard()
    {
        return view('propman.reporting.diary.index', $this->sharedLayoutData());
    }

    // LANDLORD DIARY
    public function landlordIndex()
    {
        return view('propman.reporting.diary.landlord.index', $this->sharedLayoutData());
    }

    public function landlordApproval(Request $request)
    {
        return view('propman.reporting.diary.landlord.approval-history', $this->sharedLayoutData());
    }

    public function landlordOnboarding(Request $request)
    {
        return view('propman.reporting.diary.landlord.onboarding-timeline', $this->sharedLayoutData());
    }

    public function landlordStatus(Request $request)
    {
        return view('propman.reporting.diary.landlord.status-changes', $this->sharedLayoutData());
    }

    public function landlordSummary(Request $request)
    {
        return view('propman.reporting.diary.landlord.summary-by-date', $this->sharedLayoutData());
    }

    public function landlordAcquisition(Request $request)
    {
        return view('propman.reporting.diary.landlord.property-acquisition', $this->sharedLayoutData());
    }

    public function landlordTenants(Request $request)
    {
        return view('propman.reporting.diary.landlord.linked-tenants', $this->sharedLayoutData());
    }

    public function landlordRemittance(Request $request)
    {
        return view('propman.reporting.diary.landlord.remittance-log', $this->sharedLayoutData());
    }

    public function exportLandlordApproval(Request $request)
  {
    $from = $request->input('date_from');
    $to = $request->input('date_to');
    $format = $request->input('format');

    $user = Auth::user() ?? (object)[
        'firstname' => '',
        'lastname' => '',
    ];

    // Dummy landlord data for testing
    $landlords = collect([
        (object)[
            'clienttypeid' => 'individual',
            'firstname' => 'John',
            'lastname' => 'Doe',
            'companyname' => null,
            'companynumber' => 'TIN123456',
            'cell' => '0771234567',
            'email' => 'john@example.com',
            'tel' => '0242123456',
            'property_count' => 3,
            'isactive' => 'Y',
        ],
        (object)[
            'clienttypeid' => 'corporate',
            'firstname' => null,
            'lastname' => null,
            'companyname' => 'Acme Holdings',
            'companynumber' => 'TIN789012',
            'cell' => '0789876543',
            'email' => 'info@acme.com',
            'tel' => '0242987654',
            'property_count' => 12,
            'isactive' => 'N',
        ],
    ]);

    if ($format === 'pdf') {
        return Pdf::loadView('propman.reporting.diary.landlord.exports.approval-history', [
            'user' => $user,
            'from' => $from,
            'to' => $to,
            'landlords' => $landlords,
        ])->download('landlord-approval-history.pdf');
    }

    if ($format === 'excel') {
        return Excel::download(new LandlordApprovalExport($landlords, $user, $from, $to), 'landlord-approval-history.xlsx');
    }

    return back()->with('error', 'Invalid export format selected.');
    }



    // TENANT DIARY
    public function tenantIndex()
    {
        return view('propman.reporting.diary.tenant.index', $this->sharedLayoutData());
    }

    public function tenantRegistration()
    {
        return view('propman.reporting.diary.tenant.registration-timeline', $this->sharedLayoutData());
    }

    public function tenantLinkage()
    {
        return view('propman.reporting.diary.tenant.lease-linkage', $this->sharedLayoutData());
    }

    public function tenantNextOfKin()
    {
        return view('propman.reporting.diary.tenant.next-of-kin', $this->sharedLayoutData());
    }

    public function tenantContact()
    {
        return view('propman.reporting.diary.tenant.contact-changes', $this->sharedLayoutData());
    }

    public function tenantPayment()
    {
        return view('propman.reporting.diary.tenant.payment-log', $this->sharedLayoutData());
    }

    public function tenantStatus()
    {
        return view('propman.reporting.diary.tenant.status-changes', $this->sharedLayoutData());
    }

    // PROPERTY DIARY
    public function propertyIndex()
    {
        return view('propman.reporting.diary.property.index', $this->sharedLayoutData());
    }

    public function propertyRegistration()
    {
        return view('propman.reporting.diary.property.registration-timeline', $this->sharedLayoutData());
    }

    public function propertyTransfers()
    {
        return view('propman.reporting.diary.property.ownership-transfers', $this->sharedLayoutData());
    }

    public function propertyOccupancy()
    {
        return view('propman.reporting.diary.property.occupancy-changes', $this->sharedLayoutData());
    }

    public function propertyMaintenance()
    {
        return view('propman.reporting.diary.property.maintenance-logs', $this->sharedLayoutData());
    }

    public function propertyCommission()
    {
        return view('propman.reporting.diary.property.commission-adjustments', $this->sharedLayoutData());
    }

    public function propertyLocation()
    {
        return view('propman.reporting.diary.property.location-updates', $this->sharedLayoutData());
    }

    // LEASE DIARY
    public function leaseIndex()
    {
        return view('propman.reporting.diary.lease.index', $this->sharedLayoutData());
    }

    public function leaseCreation()
    {
        return view('propman.reporting.diary.lease.creation-log', $this->sharedLayoutData());
    }

    public function leaseValidity()
    {
        return view('propman.reporting.diary.lease.validity-changes', $this->sharedLayoutData());
    }

    public function leaseRenewal()
    {
        return view('propman.reporting.diary.lease.renewal-history', $this->sharedLayoutData());
    }

    public function leaseUploads()
    {
        return view('propman.reporting.diary.lease.signed-uploads', $this->sharedLayoutData());
    }

    public function leaseFinancial()
    {
        return view('propman.reporting.diary.lease.financial-events', $this->sharedLayoutData());
    }
}
