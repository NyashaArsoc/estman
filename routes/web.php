<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TenantController;
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
Route::get('/main-menu', function () {
    return view('layout.main-layout');
});
Route::resource('landlord', LandlordController::class);
Route::controller(LandlordController::class)->group(function () {
    Route::any('/landlord-banking-details', 'addbanking')->name('landlord.addbanking');
    Route::any('/landlord-approval', 'pendingapproval')->name('landlord.pending');
    Route::any('/landlord-rejected', 'rejected')->name('landlord.rejected');
    Route::any('/manage-landlord', 'listlandlords')->name('landlord.list');
    Route::any('/single-landlord/{id}', 'getlandlord')->name('landlord.getlandlord');
    Route::any('/approve-landlord/{id}', 'approvelandlord')->name('landlord.approve');
    Route::any('/view-pending-landlord/{id}', 'viewpending')->name('landlord.viewpending');
    Route::any('/reject-landlord/{id}', 'rejectlandlord')->name('landlord.reject');
    Route::any('/edit-update-landlord/{id}', 'updatelandlord')->name('landlord.editupdate');
    Route::any('/delete-rejected-landlord/{id}', 'deleterejected')->name('landlord.deleterejected');
});
Route::resource('tenant', TenantController::class);
Route::controller(TenantController::class)->group(function () {
    Route::any('/tenant-approval', 'pendingapproval')->name('tenant.pending');
    Route::any('/view-pending-tenant/{id}', 'viewpending')->name('tenant.viewpending');
    Route::any('/approve-tenant/{id}', 'approvetenant')->name('tenant.approve');
    Route::any('/reject-tenant/{id}', 'rejecttenant')->name('tenant.reject');
    Route::any('/tenant-rejected', 'rejected')->name('tenant.rejected');
    Route::any('/edit-update-tenant/{id}', 'updatetenant')->name('tenant.editupdate');
    Route::any('/single-tenant/{id}', 'gettenant')->name('tenant.gettenant');
    Route::any('/manage-tenant', 'listtenants')->name('tenant.list');
});
Route::resource('property', PropertyController::class);
Route::controller(PropertyController::class)->group(function () {
    Route::any('/property-approval', 'pendingapproval')->name('property.pending');
    Route::any('/view-pending-property/{id}', 'viewpending')->name('property.viewpending');
    Route::any('/approve-property/{id}', 'approveproperty')->name('property.approve');
    Route::any('/reject-property/{id}', 'rejectproperty')->name('property.reject');
    Route::any('/property-rejected', 'rejected')->name('property.rejected');
    Route::any('/delete-rejected-property/{id}', 'deleterejected')->name('property.deleterejected');
    Route::any('/edit-update-tenant/{id}', 'updateproperty')->name('property.editupdate');
    Route::any('/single-property/{id}', 'getpropertyaddress')->name('property.getproperty');
    Route::any('/property-list', 'listproperties')->name('property.list');
    Route::any('/property-areataken/{id}', 'getpropertyareataken')->name('property.areataken');
    Route::any('/property-areaavailable/{id}', 'getpropertyareaavailable')->name('property.areaavailable');
    
});
//Route::resource('lease', LeaseController::class);
Route::controller(LeaseController::class)->group(function () {
    Route::any('/lease-approval', 'pendingapproval')->name('lease.pending');
    Route::any('/view-pending-lease/{id}', 'viewpending')->name('lease.viewpending');
    Route::any('/approve-lease/{id}/{pid}', 'approvelease')->name('lease.approve');
    Route::any('/reject-lease/{id}', 'rejectlease')->name('lease.reject');
    Route::any('/edit-update-lease/{id}', 'updatelease')->name('lease.editupdate');
    Route::any('/lease-rejected', 'rejected')->name('lease.rejected');
    Route::any('/lease-landlord', 'listlandlords')->name('lease.list');

    Route::any('/lease-create', 'addcreate')->name('lease.addcreate');
    Route::any('/lease-create-store', 'addstore')->name('lease.addstore');
});
Route::resource('invoice', InvoiceController::class);
Route::controller(InvoiceController::class)->group(function (){
    Route::any('/genaratepre-preinvoice', 'compilepreinvoice')->name('invoice.compilepre');
    Route::any('/pre-invoice', 'listpreinvoice')->name('invoice.listpre');
    Route::any('/view-pro-foma/{id}', 'viewprofoma')->name('invoice.viewpro');
    Route::any('/edit-pro-foma/{id}', 'vieweditprofomamount')->name('invoice.editviewpro');
    Route::any('/update-view-pro-foma/{id}', 'updateprofoma')->name('invoice.updateviewpro');
});
