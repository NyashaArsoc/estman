<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DiaryReportController extends Controller
{
    // Dashboard view showing all diary categories
    public function dashboard()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Graceful fallback without redirect
        $propmanintake = DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanintake']);
        $propmanapprove = DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanapprove']);
        $propmandecline = DB::select("EXEC spGetMenuList ?, ?", [1, 'propmandecline']);
        $propmanmanage = DB::select("EXEC spGetMenuList ?, ?", [1, 'propmanmanage']);

        return view('propman.reporting.diary.index', compact(
            'user',
            'propmanintake',
            'propmanapprove',
            'propmandecline',
            'propmanmanage'
        ));
    }

    // LANDLORD DIARY
    public function landlordIndex() { return view('propman.reporting.diary.landlord.index'); }
    public function landlordApproval(Request $request) { return view('propman.reporting.diary.landlord.approval-history'); }
    public function landlordOnboarding(Request $request) { return view('propman.reporting.diary.landlord.onboarding-timeline'); }
    public function landlordStatus(Request $request) { return view('propman.reporting.diary.landlord.status-changes'); }
    public function landlordSummary(Request $request) { return view('propman.reporting.diary.landlord.summary-by-date'); }
    public function landlordAcquisition(Request $request) { return view('propman.reporting.diary.landlord.property-acquisition'); }
    public function landlordTenants(Request $request) { return view('propman.reporting.diary.landlord.linked-tenants'); }
    public function landlordRemittance(Request $request) { return view('propman.reporting.diary.landlord.remittance-log'); }

    // TENANT DIARY
    public function tenantIndex() { return view('propman.reporting.diary.tenant.index'); }
    public function tenantRegistration() { return view('propman.reporting.diary.tenant.registration-timeline'); }
    public function tenantLinkage() { return view('propman.reporting.diary.tenant.lease-linkage'); }
    public function tenantNextOfKin() { return view('propman.reporting.diary.tenant.next-of-kin'); }
    public function tenantContact() { return view('propman.reporting.diary.tenant.contact-changes'); }
    public function tenantPayment() { return view('propman.reporting.diary.tenant.payment-log'); }
    public function tenantStatus() { return view('propman.reporting.diary.tenant.status-changes'); }

    // PROPERTY DIARY
    public function propertyIndex() { return view('propman.reporting.diary.property.index'); }
    public function propertyRegistration() { return view('propman.reporting.diary.property.registration-timeline'); }
    public function propertyTransfers() { return view('propman.reporting.diary.property.ownership-transfers'); }
    public function propertyOccupancy() { return view('propman.reporting.diary.property.occupancy-changes'); }
    public function propertyMaintenance() { return view('propman.reporting.diary.property.maintenance-logs'); }
    public function propertyCommission() { return view('propman.reporting.diary.property.commission-adjustments'); }
    public function propertyLocation() { return view('propman.reporting.diary.property.location-updates'); }

    // LEASE DIARY
    public function leaseIndex() { return view('propman.reporting.diary.lease.index'); }
    public function leaseCreation() { return view('propman.reporting.diary.lease.creation-log'); }
    public function leaseValidity() { return view('propman.reporting.diary.lease.validity-changes'); }
    public function leaseRenewal() { return view('propman.reporting.diary.lease.renewal-history'); }
    public function leaseUploads() { return view('propman.reporting.diary.lease.signed-uploads'); }
    public function leaseFinancial() { return view('propman.reporting.diary.lease.financial-events'); }
}
