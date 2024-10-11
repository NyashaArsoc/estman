<?php

use App\Http\Controllers\DashController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LandlordController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropManApprovalController;
use App\Http\Controllers\PropManDeclineController;
use App\Http\Controllers\PropManIntakeController;
use App\Http\Controllers\PropManManageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SetupIntakeController;
use App\Http\Controllers\SetupManageController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ValApprovalController;
use App\Http\Controllers\ValDeclinedController;
use App\Http\Controllers\ValIntakeController;
use App\Http\Controllers\ValManageController;
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
/*
Route::controller(LandlordController::class)->group(function () {
    Route::get('/landlord/{id}/view-ledgers', 'viewledgers')->name('landlord.ledgers');
    Route::post('/landlord/{id}/sub-ledgers/{product}', 'createsubledgers')->name('landlord.createsub');
});
//Route::resource('tenant', TenantController::class);
Route::controller(TenantController::class)->group(function () {
    Route::get('/edit/tenant/{id}/view', 'viewedittenant')->name('tenant.editview');
    Route::any('/reject-tenant/{id}', 'rejecttenant')->name('tenant.reject');
    Route::any('/tenant-rejected', 'rejected')->name('tenant.rejected');
    Route::any('/manage-tenant', 'listtenants')->name('tenant.list');
    Route::get('/single-tenant/details/{id}', 'gettenantdetails')->name('tenant.tenantdetails');
    Route::get('/update/{id}/edit-tenant', 'updatetenant')->name('tenant.updating');
    Route::get('/tenant/{id}/view', 'viewindividual')->name('tenant.view');
    Route::get('/tenant/{id}/view-leases', 'viewtenantlease')->name('tenant.viewlease');
    Route::any('/disable/{id}/tenant', 'disabletenant')->name('tenant.disable');
});
//Route::resource('property', PropertyController::class);
Route::controller(PropertyController::class)->group(function () {
    Route::get('/edit/{id}/property', 'vieweditproperty')->name('property.editview');
    Route::any('/reject-property/{id}', 'rejectproperty')->name('property.reject');
    Route::any('/property-rejected', 'rejected')->name('property.rejected');
    Route::any('/delete-rejected-property/{id}', 'deleterejected')->name('property.deleterejected');
    Route::any('/edit-update-tenant/{id}', 'updateproperty')->name('property.editupdate');
    Route::any('/property-areaavailable/{id}', 'getpropertyareaavailable')->name('property.areaavailable');
    Route::get('/property/{id}/view-ledgers', 'viewledgers')->name('property.ledgers');
    Route::post('/property/{id}/sub-ledgers/{product}', 'createsubledgers')->name('property.createsub');
    Route::get('/property-remittance', 'remitlist')->name('property.remit');
    Route::any('/genarate-preremit', 'compilepreremitlist');
    Route::get('/property/{id}/remit/{currency}/{period}', 'prepareremittance')->name('property.remitprepare');
    Route::any('/remit/{id}/property/{currency}', 'addpreremit')->name('property.preremit');
    --Route::any('/property/{id}/disable', 'disableproperty')->name('property.disable');
});
Route::controller(LeaseController::class)->group(function () {
    Route::any('/reject-lease/{id}', 'rejectlease')->name('lease.reject');
    Route::any('/edit-update-lease/{id}', 'updatelease')->name('lease.editupdate');
    Route::get('/lease/{id}/edit', 'vieweditlease')->name('lease.editview');
    Route::any('/lease-rejected', 'rejected')->name('lease.rejected');
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
*/
Route::controller(LoginAuthController::class)->group(function(){
    Route::get('/login', 'signin')->name('login.signin');
    Route::get('/', 'defaultport');
    Route::post('/user/login', 'userlogin')->name('login.login');
    Route::any('/logout', 'userlogout')->name('login.signout');
    Route::any('/licensecheck', 'licensecheck');
    Route::get('/user/profile', 'profileview')->name('login.profile');
    Route::post('/profile/edit', 'profilepassword')->name('login.editprofile');
});
Route::middleware('loginauth')->controller(DashController::class)->group(function(){
    Route::get('/dashboard/property', 'propertyview')->name('dash.property');
    Route::get('/welcome', 'maindashboard')->name('dash.main');
    Route::get('/valuation/dashboard', 'valuationdashboard')->name('dash.val');
    Route::get('/set-up/dashboard', 'setupdashboard')->name('dash.setup');
});
/*
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
}); */
Route::controller(ValIntakeController::class)->group(function(){
    Route::get('/val/add/client', 'addclientdetails')->name('valin.addclient'); /*done*/
    Route::any('/val/add/new/client', 'addnewclientdetails')->name('valin.addnewclient');/*done*/
    Route::get('/val/{id}/client/type', 'getsingleclient');/*done*/
    Route::get('/val/{id}/client/contact', 'getsingleclientcontact');/*done*/
    Route::any('/val/add/property', 'addpropertydetails')->name('valin.addprop');/*done*/
    Route::any('/val/add/new/property', 'addnewpropertydetails')->name('valin.addnewprop');/*done*/
    Route::get('/val/add/new/portfolio', 'createportfolio')->name('valin.crtportfoli');/*done*/
    Route::post('/val/create/new/portfolio', 'createnewportfolio')->name('valin.crtmewport');/*done*/
    Route::get('/val/new/instruction/portfolio', 'addinstructionportfolio')->name('valin.addinstport');/*done*/
    Route::any('/val/submit/page/port-instr', 'addinstructionportsubmit')->name('valin.subport');/*done*/
    Route::get('/val/{id}/port/{vid}/inst', 'addinstructionportsteptwo')->name('valin.portlstpropallo');/*done*/
    Route::any('/val/add/new/port-instr', 'addnewinstructionport')->name('valin.addnewport');/*done*/
    Route::get('/val/new/instruction/normal', 'addinstructionnormal')->name('valin.addinstnom');/*done*/
    Route::any('/val/submit/page/normal-instr', 'addinstructionnormalsubmit')->name('valin.subnom');/*done*/
    Route::get('/val/{id}/nom/{vid}/inst/{cid}/pur/{pid}/typ/{tid}/pay/{payid}/{accessdate}', 'addinstructionnormalsteptwo')->name('valin.lstpropallo');
    Route::any('/val/add/new/normal-instr', 'addnewinstructionnormal')->name('valin.addnewnom');/*done*/
       
});
Route::controller(ValManageController::class)->group(function(){
    Route::get('/val/list/client', 'listallclient')->name('valman.listclient');/*done*/
    Route::get('/val/{id}/client/edit', 'editsingleclient')->name('valman.editclient');
    Route::get('/val/{id}/client/view', 'viewsingleclient')->name('valman.viewclient');/*done*/
});
Route::controller(ValApprovalController::class)->group(function(){
    Route::get('/val/list/acknowledgement', 'listallinstructionacknowledgement')->name('valapp.listackn');/*done*/
    Route::get('/val/{id}/view-single/{instr_id}/acknowledgement', 'viewsingleacknowledge')->name('valapp.viewsinglackn');
    Route::any('/val/{id}/acknow/{instr_id}/decline', 'declineacknowledgement')->name('valapp.declacknow');/*done*/
    Route::any('/val/{id}/acknow/{instr_id}/accept/{to_id}', 'acceptacknowledgement')->name('valapp.accptacknow');/*done*/
    Route::get('/val/list/compilation', 'listallinstructioncompile')->name('valapp.listcomp');
    Route::get('/val/{id}/view-single/{instr_id}/compile', 'viewsinglecompile')->name('valapp.viewsinglacomp');
    Route::any('/val/{id}/compile/{instr_id}/{propid}', 'submitcompilation')->name('valapp.sbtcomp');/*done*/
    Route::get('/val/list/quality-check', 'listallinstructionqualitycheck')->name('valapp.listquality');
    Route::get('/val/{id}/view-single/{instr_id}/quality/check', 'viewsinglequalitycheck')->name('valapp.viewsinglqlty');
    Route::any('/val/{id}/quality/{instr_id}', 'submitqualitycheck')->name('valapp.sbtqty');
    Route::get('/val/list/final-approve', 'listallinstructionfinalapproval')->name('valapp.listallappro');
    Route::get('/val/{id}/view-single/{instr_id}/final/approval', 'viewsinglefinalapproval')->name('valapp.viewsinglfinapr');
    Route::any('/val/{id}/instruction/{instr_id}/approval', 'submitfinalapproval')->name('valapp.sbtfinalap');
    Route::get('/val/list/printing', 'listallinstructionprint')->name('valapp.listprint');
    Route::get('/val/{id}/view-single/{instr_id}/printing', 'viewsingleprint')->name('valapp.viewsinglpri');
    Route::any('/val/{id}/report/{instr_id}/print', 'submitprinting')->name('valapp.sbtprint');
    Route::get('/val/list/invoicing', 'listallinstructioninvoice')->name('valapp.listinvoice');
    Route::get('/val/{id}/view-single/{instr_id}/invoice', 'viewsingleinvoicing')->name('valapp.viewsinglinvo');
    Route::get('/val-invoice/{id}/view-port', 'viewsingleinvoicingportfolio')->name('valapp.viewsinglinvoport');/*portfolio*/
    Route::any('/val/{id}/report/invoicing', 'submitinvoicing')->name('valapp.sbtinvoic');
    Route::any('/val/{id}/portfolio/invoicing', 'submitinvoicingportfolio')->name('valapp.sbtinvoicport');
    Route::get('/val/list/dispatch', 'listallinstructiondispatch')->name('valapp.listdispatch');
    Route::get('/val/{id}/view-single/{instr_id}/dispatch', 'viewsingledispatch')->name('valapp.viewsingldisp');
    Route::any('/val/{id}/report/dispatch', 'submitdispatch')->name('valapp.sbtidisp');
    Route::get('/val/list/portfolio/compilation', 'listallportfoliocompile')->name('valapp.listportcomp');
    Route::get('/val/portfolio/{id}/compilation', 'listallinstructionportfoliocompile')->name('valapp.viewsinglportfoli');
    Route::any('/val/portfolio/compile', 'submitportfoliocompiledreports')->name('valapp.sbtcompil');
    Route::any('/val/portfolio/{id}/close', 'closeportfolio')->name('valapp.portclose');
    Route::get('/val/list/email-report', 'listallinstructionsendingsoftcopy')->name('valapp.listallsoft');
    Route::get('/val/{id}/view-single/{instr_id}/softcopy', 'viewsinglesoftcopy')->name('valapp.viewsinglsofy');
    Route::any('/val/{id}/report/send/softcopy', 'submitsoftcopy')->name('valapp.sbtsoft');
    Route::get('/val/list/portfolio/review', 'listallportfolioreview')->name('valapp.listportreview');
    Route::get('/val/portfolio/{id}/review', 'listallinstructionportfolioreview')->name('valapp.viewsinglportrevie');
    Route::any('/val/portfolio/review', 'submitportfolioreviewedreports')->name('valapp.sbtreviewport');
    Route::any('/val/portfolio/{id}/review', 'closeportfolioreview')->name('valapp.portclosereview');
    /*-----------download reports-------------------- */
    Route::any('/val-report/{instr_id}/download/doc', 'downloadreportword')->name('valapp.dwndoc');
    Route::any('/val-report/{instr_id}/excel/download', 'downloadreportexcel')->name('valapp.dwnexc');
    /*-----------end download reports-------------------- */
});
Route::controller(ValDeclinedController::class)->group(function(){
    Route::get('/val/list/acknowledgement/declined', 'listalldeclinedacknowledgement')->name('valdec.listackn');
    Route::get('/declined/val/{propid}/view-single/{instr_id}/acknowledgement', 'viewdeclinedsingleacknowledge')->name('valdec.viewsinglackn');
    Route::get('/val/list/quality-check/declined', 'listalldeclinedinstructionqualitycheck')->name('valdec.listquality');
    Route::get('/declined/val/{propid}/view-single/{instr_id}/quality', 'viewdeclinedsinglequalitycheck')->name('valdec.viewsinglqlty');
});
/*-------------------property management intake------------------------ */
Route::middleware('loginauth')->controller(PropManIntakeController::class)->group(function(){
    Route::get('/prop/add/landlord', 'addlandlorddetails')->name('propin.addlandlord');
    Route::post('/prop/add/new/landlord', 'addnewlandlorddetails')->name('propin.addnewlandlord');
    Route::get('/prop/add/property', 'addpropertydetails')->name('propin.addproperty');
    Route::post('/prop/add/new/property', 'addnewpropertydetails')->name('propin.addnewproperty');
    Route::get('/prop/add/tenant', 'addtenantdetails')->name('propin.addtenant');
    Route::post('/prop/add/new/tenant', 'addnewtenantdetails')->name('propin.addnewtenant');
    Route::get('/prop/add/lease', 'addleasedetails')->name('propin.addlease');
    Route::post('/prop/add/new/lease', 'addnewleasedetails')->name('propin.addnewlease');
    Route::get('/prop/add/{id}/landlord/contact', 'addlandlordcontact')->name('propin.addlandcont');
    Route::post('/prop/add/{id}/landlord/new/contact', 'addlandlordnewcontact')->name('propin.addlandnewcont');
    Route::get('/prop/add/{id}/landlord/bank', 'addlandlordbank')->name('propin.addlandbank');
    Route::post('/prop/add/{id}/landlord/new/bank', 'addlandlordnewbank')->name('propin.addlandnewbank');

});
/*-------------------end property management intake------------------------ */

/*-------------------property management approval------------------------ */
Route::middleware('loginauth')->controller(PropManApprovalController::class)->group(function(){
   Route::get('/prop/list/approval/landlord', 'listlandlordapproval')->name('propapp.listland');
   Route::get('/prop/view/{id}/landlord/approval', 'viewlandlordapproval')->name('propapp.viewland');
   Route::get('/prop/{id}/landlord/approve', 'approvenewsinglelandlordapproval')->name('propapp.landapprove');
   Route::get('/prop/list/property/approval', 'listpropertyapproval')->name('propapp.listprop');
   Route::get('/prop/view/{id}/property/approval', 'viewpropertyapproval')->name('propapp.viewprop');
   Route::any('/prop/property/{id}/approve', 'approvenewproperty')->name('propapp.propapp');
   Route::get('/prop/list/tenant/approval', 'listtenantapproval')->name('propapp.listten');
   Route::get('/prop/view/{id}/tenant/approval', 'viewtenantapproval')->name('propapp.viewten');
   Route::any('/prop/tenant/{id}/approve', 'approvenewtenant')->name('propapp.tenappv');
   Route::get('/prop/list/lease/approval', 'listleaseapproval')->name('propapp.listlea');
   Route::get('/prop/view/{id}/lease/approval', 'viewleaseapproval')->name('propapp.viewlease');
   Route::any('/prop/lease/{id}/approve', 'approvenewlease')->name('propapp.leaappv');
   Route::get('/prop/list/approval/landlord-contact', 'listlandlordcontactapproval')->name('propapp.listlandcont');
   Route::any('/prop/landlord-contact/{id}/approve', 'approvenewlandlordcontact')->name('propapp.landcont');

   /*-----------download property documents-------------------- */
   Route::any('/prop-pdf/{path}/download/mandate', 'downloadmandatepdf')->name('propapp.dwnmandpdf');
   Route::any('/prop-pdf/{path}/other/download', 'downloadotherpdf')->name('propapp.dwnothrpdf');
   Route::any('/prop-pdf/{path}/lease-download/agreement', 'downloadleaseagreementpdf')->name('propapp.dwnagrepdf');
   /*-----------end download property documents-------------------- */
});
/*-------------------end property management approval------------------------ */
/*-------------------property management declines------------------------ */
Route::middleware('loginauth')->controller(PropManDeclineController::class)->group(function(){
    Route::any('/prop/landlord/{id}/decline', 'declinenewlandlord')->name('propdec.landdec');
    Route::get('/prop/list/landlord/declined', 'listdeclinelandlord')->name('propdec.listlanddec');
    Route::get('/prop/view/landlord/{id}/edit', 'vieweditsinglelandlord')->name('propdec.editviewland');
    Route::any('/prop/landlord/{id}/delete', 'deletesinglelandlord')->name('propdec.landdel');
    Route::any('/prop/{id}/landlord/{contactid}/update', 'updatesinglelandlord')->name('propdec.landupd'); 
    Route::any('/prop/lease/{id}/decline', 'declinenewlease')->name('propdec.leadec'); 
    Route::any('/prop/disable/{id}/landlord/contact/{cid}', 'disablelandlordcontact')->name('propdec.dislancon');
    Route::any('/prop/disable/{id}/landlord', 'disablelandlord')->name('propdec.disland');
    Route::any('/prop/disable/{id}/property', 'disableproperty')->name('propdec.disprop');

});
/*-------------------end property management declines------------------------ */
/*-------------------property management declines------------------------ */
Route::middleware('loginauth')->controller(PropManManageController::class)->group(function(){
    Route::get('/prop/list/landlord', 'listalllandlords')->name('propma.landlist');
    Route::get('/prop/landlord/single/type/{id}', 'getlandlordbytype');
    Route::get('/prop/tenant/single/type/{id}', 'gettenantbytype');
    Route::get('/prop/property/single/type/{id}', 'getpropertybytype');
    Route::get('/prop/landlord/contact/propertyaddress/{id}', 'getlandlordbyproperty');
    Route::get('/prop/landlord/{id}/view', 'viewlandlorddetails')->name('propma.viewland');
    Route::get('/prop/edit/{id}/landlord', 'vieweditlandlorddetails')->name('propma.editland');
    Route::any('/prop/update/{id}/landlord', 'updatelandlorddetails')->name('propma.updtland');
    Route::get('/prop/edit/{id}/landlord/contact/{cid}', 'vieweditlandlordcontact')->name('propma.editlandcon');
    Route::any('/prop/update/{id}/landlord/contact/{cid}', 'updatelandlordcontact')->name('propma.updatlandcon');
    Route::get('/prop/edit/{id}/landlord/bank/{bid}', 'vieweditlandlordbank')->name('propma.editlandban');
    Route::any('/prop/update/{id}/landlord/bank/{bid}', 'updatelandlordbank')->name('propma.updatlandbank');
    Route::get('/prop/list/property', 'listallproperty')->name('propma.landproplist');
    Route::get('/prop/property/{id}/view', 'viewpropertydetails')->name('propma.viewprop');
    Route::get('/prop/edit/{id}/property', 'vieweditpropertydetails')->name('propma.editprop');
    Route::any('/prop/update/{id}/property', 'updatepropertydetails')->name('propma.updatprop');

   });
/*-------------------end property management declines------------------------ */
/*-------------------setup intake------------------------ */
Route::middleware('loginauth')->controller(SetupIntakeController::class)->group(function(){
     Route::get('/set-up/add/currency', 'addcurrency')->name('setin.addcurr');
     Route::post('/set-up/add/new/currency', 'addnewcurrency')->name('setin.addnewcurr');
     Route::get('/set-up/add/client-type', 'addclienttype')->name('setin.addcltyp');
     Route::post('/set-up/add/new/client-type', 'addnewclienttype')->name('setin.addnewcltyp');
     Route::get('/set-up/add/property-type', 'addpropertytype')->name('setin.addpropty');
     Route::post('/set-up/add/new/property-type', 'addnewpropertytype')->name('setin.addnewpropty');
     Route::get('/set-up/add/province', 'addprovince')->name('setin.addprov');
     Route::post('/set-up/add/new/province', 'addnewprovince')->name('setin.addnewprov');
});
/*-------------------end setup intake------------------------ */
/*-------------------setup manage------------------------ */
Route::middleware('loginauth')->controller(SetupManageController::class)->group(function(){
    Route::get('/set-up/base/currency', 'setbasecurrency')->name('setman.addbasecurr');
    Route::post('/set-up/set/base/currency', 'addnewbasecurrency')->name('setman.addbewcode');
});
/*-------------------end setup manage------------------------ */