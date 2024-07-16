<?php

use App\Http\Controllers\DashController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ValIntakeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/main-menu', function () {
//     return view('layout.main-layout');
// });
//Route::resource('landlord', LandlordController::class);
Route::controller(LandlordController::class)->group(function () {
    Route::get('/create/landlord', 'createnew')->name('landlord.newlandlord');
    Route::post('/new/create/landlord', 'addnewlandlord')->name('landlord.addlandlord');
    Route::get('/edit/landlord/{id}/view', 'vieweditlandlord')->name('landlord.editview');
    Route::get('/landlord-banking-details', 'addbanking')->name('landlord.addbanking');
    Route::post('/create/landlord/bank', 'capturebankingdetails')->name('landlord.addbank');
    Route::any('/landlord-approval', 'pendingapproval')->name('landlord.pending');
    Route::any('/landlord-rejected', 'rejected')->name('landlord.rejected');
    Route::any('/single-landlord/{id}', 'getlandlord')->name('landlord.getlandlord');
    Route::any('/approve-landlord/{id}', 'approvelandlord')->name('landlord.approve');
    Route::any('/disable/{id}/landlord', 'disablelandlord')->name('landlord.disable');
    Route::any('/view-pending-landlord/{id}', 'viewpending')->name('landlord.viewpending');
    Route::any('/reject-landlord/{id}', 'rejectlandlord')->name('landlord.reject');
    Route::any('/edit-update-landlord/{id}', 'updatelandlord')->name('landlord.editupdate');
    Route::any('/delete-rejected-landlord/{id}', 'deleterejected')->name('landlord.deleterejected');
    Route::any('/landlord/{id}/view', 'viewindividual')->name('landlord.view');
    Route::get('/landlord/{id}/view-ledgers', 'viewledgers')->name('landlord.ledgers');
    Route::post('/landlord/{id}/sub-ledgers/{product}', 'createsubledgers')->name('landlord.createsub');
    Route::any('/manage-landlord', 'listlandlords')->name('landlord.list');
});
//Route::resource('tenant', TenantController::class);
Route::controller(TenantController::class)->group(function () {
    Route::get('/create/tenant', 'createnew')->name('tenant.newtenant');
    Route::post('/new/create/tenant', 'addnewtenant')->name('tenant.addtenant');
    Route::get('/edit/tenant/{id}/view', 'viewedittenant')->name('tenant.editview');
    Route::any('/tenant-approval', 'pendingapproval')->name('tenant.pending');
    Route::any('/view-pending-tenant/{id}', 'viewpending')->name('tenant.viewpending');
    Route::any('/approve-tenant/{id}', 'approvetenant')->name('tenant.approve');
    Route::any('/reject-tenant/{id}', 'rejecttenant')->name('tenant.reject');
    Route::any('/tenant-rejected', 'rejected')->name('tenant.rejected');
    Route::any('/single-tenant/{id}', 'gettenant')->name('tenant.gettenant');
    Route::any('/manage-tenant', 'listtenants')->name('tenant.list');
    Route::get('/single-tenant/details/{id}', 'gettenantdetails')->name('tenant.tenantdetails');
    Route::get('/update/{id}/edit-tenant', 'updatetenant')->name('tenant.updating');
    Route::get('/tenant/{id}/view', 'viewindividual')->name('tenant.view');
    Route::get('/tenant/{id}/view-leases', 'viewtenantlease')->name('tenant.viewlease');
    Route::any('/disable/{id}/tenant', 'disabletenant')->name('tenant.disable');
});
//Route::resource('property', PropertyController::class);
Route::controller(PropertyController::class)->group(function () {
    Route::get('/new/property', 'createnew')->name('property.newproperty');
    Route::post('/new/property/create', 'addnewproperty')->name('property.addproperty');
    Route::get('/edit/{id}/property', 'vieweditproperty')->name('property.editview');
    Route::any('/property-approval', 'pendingapproval')->name('property.pending');
    Route::any('/view-pending-property/{id}', 'viewpending')->name('property.viewpending');
    Route::any('/approve-property/{id}', 'approveproperty')->name('property.approve');
    Route::any('/reject-property/{id}', 'rejectproperty')->name('property.reject');
    Route::any('/property-rejected', 'rejected')->name('property.rejected');
    Route::any('/delete-rejected-property/{id}', 'deleterejected')->name('property.deleterejected');
    Route::any('/edit-update-tenant/{id}', 'updateproperty')->name('property.editupdate');
    Route::any('/single-property/{id}', 'getpropertyaddress')->name('property.getproperty');
    Route::any('/property-areataken/{id}', 'getpropertyareataken')->name('property.areataken');
    Route::any('/property-areaavailable/{id}', 'getpropertyareaavailable')->name('property.areaavailable');
    Route::any('/property/{id}/view', 'viewindividual')->name('property.view');
    Route::get('/property/{id}/view-ledgers', 'viewledgers')->name('property.ledgers');
    Route::post('/property/{id}/sub-ledgers/{product}', 'createsubledgers')->name('property.createsub');
    Route::get('/property-remittance', 'remitlist')->name('property.remit');
    Route::any('/property-list', 'listproperties')->name('property.list');
    Route::any('/genarate-preremit', 'compilepreremitlist');
    Route::get('/property/{id}/remit/{currency}/{period}', 'prepareremittance')->name('property.remitprepare');
    Route::any('/remit/{id}/property/{currency}', 'addpreremit')->name('property.preremit');
    Route::any('/property/{id}/disable', 'disableproperty')->name('property.disable');
});
//Route::resource('lease', LeaseController::class);
Route::controller(LeaseController::class)->group(function () {
    Route::any('/lease-approval', 'pendingapproval')->name('lease.pending');
    Route::any('/view-pending-lease/{id}', 'viewpending')->name('lease.viewpending');
    Route::any('/approve-lease/{id}/{pid}/{product}', 'approvelease')->name('lease.approve');
    Route::any('/reject-lease/{id}', 'rejectlease')->name('lease.reject');
    Route::any('/edit-update-lease/{id}', 'updatelease')->name('lease.editupdate');
    Route::get('/lease/{id}/edit', 'vieweditlease')->name('lease.editview');
    Route::any('/lease-rejected', 'rejected')->name('lease.rejected');
    Route::any('/lease-create', 'addcreate')->name('lease.addcreate');
    Route::any('/lease-create-store', 'addstore')->name('lease.addstore');
    Route::any('/lease/{id}/view', 'viewindividual')->name('lease.view');
    Route::get('/lease/{id}/view-ledgers', 'viewledgers')->name('lease.ledgers');
    Route::post('/lease/{id}/sub-ledgers/{product}', 'createsubledgers')->name('lease.createsub');
    Route::get('/lease-list', 'listleases')->name('lease.list');
    Route::any('/lease/{id}/disable', 'disablelease')->name('lease.disable');
    Route::get('/lease/{id}/view/renew', 'viewrenewal')->name('lease.viewrenew');
    Route::post('/renew/lease/{id}', 'singlerenewal')->name('lease.singlerenew');
});

Route::controller(InvoiceController::class)->group(function (){
    Route::any('/genaratepre-preinvoice', 'compilepreinvoice')->name('invoice.compilepre');
    Route::get('/pre-invoice', 'listpreinvoice')->name('invoice.listpre');
    Route::any('/view-pro-foma/{id}', 'viewprofoma')->name('invoice.viewpro');
    Route::any('/edit-pro-foma/{id}', 'vieweditprofomamount')->name('invoice.editviewpro');
    Route::any('/update-view-pro-foma/{id}', 'updateprofoma')->name('invoice.updateviewpro');
    Route::get('/edited-pro-foma', 'listeditedprofoma')->name('invoice.listeditedprofoma');
    Route::get('/view-edited-pro-foma/{id}', 'vieweditedprofoma')->name('invoice.editedviewpro');
    Route::any('/approve-edited-pro-foma/{id}', 'approveeditedprofoma')->name('invoice.approveeditedprofoma');
    Route::any('/approve/{id}/pro-foma/{lease}', 'approveprofoma')->name('invoice.approveprofoma');
    Route::get('/invoice/generated', 'listinvoice')->name('invoice.listinv');
    Route::get('/invoice/view/{id}/generated', 'viewgeneratedinvoice')->name('invoice.viewgen');
    Route::get('/invoice/{id}/print{lease}', 'printgeneratedinvoice')->name('invoice.print');
    Route::get('/profoma/generated/failed', 'listfailedprofoma')->name('invoice.listfailed');
    Route::get('/failed/view/{id}/profoma', 'viewfailedgeneratedprofoma')->name('invoice.viewfailed');
});

Route::controller(TransactionController::class)->group(function (){
    Route::get('/new-lease/unposted-balances', 'viewnewbalances')->name('transact.newbal');
    Route::any('/transact-lease/{id}/post/{code}/{name}', 'postnewleasebalances')->name('transact.postnewbal');
    Route::get('/customer/receipt', 'receipting')->name('transact.payment');
    Route::any('/receipt/tenant', 'processreceipt')->name('transact.addreceipt');
    Route::get('/remit/property', 'viewremit')->name('transact.remit');
    Route::get('/remit/{id}/property', 'addscheduleremit')->name('transact.scheduleremit');
    Route::any('/process/{id}/remit/{pid}/prop/{currency}/details/{lid}', 'processremit')->name('transact.payremit');
    Route::get('/creditor/payment', 'creditorview')->name('transact.viewpay');
    Route::get('/single-landlord/remit/{id}', 'getlandlorddetails');
    Route::get('/single-creditor/bal/{column}/{id}', 'getcreditorbal');
    Route::any('/creditor-payment', 'creditorpayment')->name('transact.paycreditor');
});

Route::controller(LoginAuthController::class)->group(function(){
    Route::get('/login', 'signin')->name('login.signin');
    Route::get('/', 'defaultport');
    Route::post('/user/login', 'userlogin')->name('login.login');
    Route::any('/logout', 'userlogout')->name('login.signout');
    Route::any('/licensecheck', 'licensecheck');
    Route::get('/user/profile', 'profileview')->name('login.profile');
    Route::post('/profile/edit', 'profilepassword')->name('login.editprofile');
});
Route::controller(DashController::class)->group(function(){
    Route::get('/dashboard/property', 'propertyview')->name('dash.property');
    Route::get('/welcome', 'maindashboard')->name('dash.main');
    Route::get('/valuation/dashboard', 'valuationdashboard')->name('dash.val');
});
Route::controller(ReportController::class)->group(function(){
    Route::get('/report/landlord', 'viewlandlord')->name('report.viewland');
    Route::get('/report/property', 'viewproperty')->name('report.viewprop');
    Route::get('/report/property/occupancy', 'viewpropertyoccupancy')->name('report.propoccu');
    Route::get('/print/property/occupancy', 'printpropertyoccupancy')->name('report.printoccu');
    Route::get('/report/rent-roll/property', 'viewrentrollist')->name('report.proprol');
    Route::get('/report/property/roll', 'printpropertyrentroll')->name('report.printrol');
    Route::get('/report/tenant', 'viewtenant')->name('report.viewtenant');
    Route::get('/report/lease', 'viewlease')->name('report.viewlease');
    Route::get('/report/landlord/status', 'printlandlordstatus')->name('report.printlandstatus');
    Route::get('/report/property/status', 'printpropertystatus')->name('report.printpropstatus');
    Route::get('/report/tenant/status', 'printtenantstatus')->name('report.printtenstatus');
    Route::get('/report/lease/status', 'printleasestatus')->name('report.printleasestatus');
    Route::get('/report/lease/statament', 'viewleasestatement')->name('report.leastatement');
    Route::get('/print/lease/statement', 'printleasestatement')->name('report.printstatement');
});
Route::controller(ValIntakeController::class)->group(function(){
    Route::get('/add/client', 'addclientdetails')->name('valin.addclient');
});
