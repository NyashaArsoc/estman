<?php

use App\Http\Controllers\DashController;
use App\Http\Controllers\HCApprovalController;
use App\Http\Controllers\HCIntakeController;
use App\Http\Controllers\HCManageController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\PropManApprovalController;
use App\Http\Controllers\PropManDeclineController;
use App\Http\Controllers\PropManIntakeController;
use App\Http\Controllers\PropManManageController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SetupIntakeController;
use App\Http\Controllers\SetupManageController;
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
Route::controller(TransactionController::class)->group(function (){
    Route::get('/creditor/payment', 'creditorview')->name('transact.viewpay');
    Route::get('/single-landlord/remit/{id}', 'getlandlorddetails');
    Route::get('/single-creditor/bal/{column}/{id}', 'getcreditorbal');
    Route::any('/creditor-payment', 'creditorpayment')->name('transact.paycreditor');
});
*/

Route::controller(LoginAuthController::class)->group(function () {
    Route::get('/login', 'signin')->name('login.signin');
    Route::get('/', 'defaultport');
    Route::post('/user/login', 'userlogin')->name('login.login');
    Route::any('/logout', 'userlogout')->name('login.signout');
    Route::any('/licensecheck', 'licensecheck');
    Route::get('/user/profile', 'profileview')->name('login.profile');
    Route::post('/profile/edit', 'profilepassword')->name('login.editprofile');
    Route::get('/passwordexpired/{id}', 'passwordexpired')->name('login.expire');
    Route::any('/password/{id}/expired/renew', 'changepasswordexpired')->name('login.expirenew');
});
Route::middleware('loginauth')->controller(DashController::class)->group(function () {
    Route::get('/dashboard/property', 'propertyview')->name('dash.property');
    Route::get('/welcome', 'maindashboard')->name('dash.main');
    Route::get('/dashboard/valuation', 'valuationdashboard')->name('dash.val');
    Route::get('/human-capital/dashboard', 'humancapitaldashboard')->name('dash.hc');
    Route::get('/set-up/dashboard', 'setupdashboard')->name('dash.setup');
    Route::get('/dashboard/property/chart', 'propertyviewchart');
    Route::get('/admin/dashboard', 'administrationdashboard')->name('dash.admin');
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
/*
*/
/*
Route::controller(ValApprovalController::class)->group(function () {
/*}); */
/*
Route::controller(ValDeclinedController::class)->group(function () {
    Route::get('/val/list/quality-check/declined', 'listalldeclinedinstructionqualitycheck')->name('valdec.listquality');
    Route::get('/declined/val/{propid}/view-single/{instr_id}/quality', 'viewdeclinedsinglequalitycheck')->name('valdec.viewsinglqlty');
});
*/
/*-------------------property management intake------------------------ */
Route::middleware('loginauth')->controller(PropManIntakeController::class)->group(function () {
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
    Route::get('/prop/add/{id}/tenant/keen', 'addtenantkeen')->name('propin.addtenkeen');
    Route::post('/prop/add/{id}/tenant/new/keen', 'addtenantnewkeen')->name('propin.addnewtenkeen');
    Route::get('/prop/add/{id}/tenant/contact', 'addtenantcontact')->name('propin.addtencon');
    Route::post('/prop/add/{id}/tenant/new/contact', 'addtenantnewcontact')->name('propin.addnewtencon');
    Route::get('/prop/add/{id}/lease/rates', 'addleaserate')->name('propin.addlearate');
    Route::post('/prop/add/new/lease/rates/{id}', 'addnewleaserate')->name('propin.addnewlearate');
    Route::get('/prop/add/{id}/lease/prepay', 'addleaseprepay')->name('propin.addleapre');
    Route::post('/prop/add/new/lease/prepay/{id}', 'addnewleaseprepay')->name('propin.addnewleaprepay');
    Route::get('/prop/add/{id}/lease/arrear', 'addleasearrear')->name('propin.addleaarrer');
    Route::post('/prop/add/new/lease/arrear/{id}', 'addnewleasearrear')->name('propin.addnewleaarrear');
    Route::get('/prop/add/{id}/lease/rates/declined', 'addleaseratedeclined')->name('propin.addlearatedec');
    Route::post('/prop/add/declined/new/lease/rates/{id}', 'addnewleaseratedeclined')->name('propin.addnewlearatedec');
    Route::get('/prop/add/customer/receipt', 'createreceipting')->name('propin.payment');
    Route::any('/prop/process/customer/payment', 'processleasepayment')->name('propin.procpay');
    Route::get('/prop/prepare/rent-roll', 'createrentroll')->name('propin.preremit');
    Route::get('/prop/view/{id}/pre/rentroll', 'viewpropertypreroll')->name('propin.viewpreroll');
    Route::any('/prop/pre-pare/{id}/rentroll', 'addnewrentrol')->name('propin.prepareroll');
    Route::get('/prop/download/{id}/summary/rentroll', 'preremitpdf')->name('propin.downrentsum');
});
/*-------------------end property management intake------------------------ */
/*-------------------property management approval------------------------ */
Route::middleware('loginauth')->controller(PropManApprovalController::class)->group(function () {
    Route::get('/prop/list/approval/landlord', 'listlandlordapproval')->name('propapp.listland');
    Route::get('/prop/view/{id}/landlord/approval', 'viewlandlordapproval')->name('propapp.viewland');
    Route::get('/prop/{id}/landlord/approve', 'approvenewsinglelandlordapproval')->name('propapp.landapprove');
    Route::get('/prop/list/approval/property', 'listpropertyapproval')->name('propapp.listprop');
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
    Route::get('/prop/pre-invoice/list', 'listallpreinvoice')->name('propapp.listpre');
    Route::get('/prop/{id}/pre-invoice/view', 'viewinvoicebilled')->name('propapp.viewpre');
    Route::post('/prop/{id}/preinvoice/approved', 'approvalpreinvoice')->name('propapp.preapp');
    Route::get('/prop/rent-roll', 'createrentroll')->name('propapp.preroll');
    Route::get('/prop/rent-roll/{id}/remit', 'addscheduleremit')->name('propapp.addremit');
    Route::any('/prop/schedule/{id}/rent-roll/remit', 'processremittance')->name('propapp.processremit');
});
/*-------------------end property management approval------------------------ */
/*-------------------property management declines------------------------ */
Route::middleware('loginauth')->controller(PropManDeclineController::class)->group(function () {
    Route::any('/prop/landlord/{id}/decline', 'declinenewlandlord')->name('propdec.landdec');
    Route::get('/prop/landlord/list/declined', 'listdeclinelandlord')->name('propdec.listlanddec');
    Route::get('/prop/view/landlord/{id}/edit', 'vieweditsinglelandlord')->name('propdec.editviewland');
    Route::any('/prop/landlord/{id}/delete', 'deletesinglelandlord')->name('propdec.landdel');
    Route::any('/prop/{id}/landlord/{contactid}/update', 'updatesinglelandlord')->name('propdec.landupd');
    Route::any('/prop/lease/{id}/decline', 'declinenewlease')->name('propdec.leadec');
    Route::any('/prop/disable/{id}/landlord/contact/{cid}', 'disablelandlordcontact')->name('propdec.dislancon');
    Route::any('/prop/disable/{id}/landlord', 'disablelandlord')->name('propdec.disland');
    Route::any('/prop/disable/{id}/property', 'disableproperty')->name('propdec.disprop');
    Route::any('/prop/disable/{id}/tenant', 'disabletenant')->name('propdec.disten');
    Route::any('/prop/disable/{id}/tenant/contact/{cid}', 'disabletenantcontact')->name('propdec.distencon');
    Route::any('/prop/tenant/{id}/decline', 'declinenewtenant')->name('propdec.tendec');
    Route::get('/prop/tenant/list/declined', 'listdeclinetenant')->name('propdec.listtendec');
    Route::get('/prop/view/tenant/{id}/edit/dec', 'vieweditsingletenant')->name('propdec.editviewten');
    Route::any('/prop/{id}/tenant/update/details', 'updatesingletenant')->name('propdec.tenupd');
    Route::any('/prop/property/{id}/decline', 'declinenewproperty')->name('propdec.propdec');
    Route::get('/prop/property/list/declined', 'listdeclinedproperty')->name('propdec.listpropdec');
    Route::get('/prop/view/property/{id}/edit', 'vieweditsingleproperty')->name('propdec.editviewprop');
    Route::any('/prop/{id}/property/update/dec', 'updatesingleproperty')->name('propdec.propupd');
    Route::any('/prop/property/{id}/delete', 'deletesingleproperty')->name('propdec.propdel');
    Route::any('/prop/tenant/{id}/delete', 'deletesingletenant')->name('propdec.tendel');
    Route::get('/prop/lease/list/declined', 'listdeclinelease')->name('propdec.listleadec');
    Route::get('/prop/view/lease/{id}/edit/dec', 'vieweditsinglelease')->name('propdec.editviewlea');
    Route::get('/prop/lease/{id}/prepay/{itemid}/edit', 'vieweditleaseprepaydetails')->name('propdec.editleapre');
    Route::any('/prop/lease/{id}/prepay/{lid}/update', 'updateleaseprepaydetails')->name('propdec.uptleaprepay');
    Route::get('/prop/lease/{id}/arrear/{itemid}/edit', 'vieweditleasearreardetails')->name('propdec.editleaarrear');
    Route::any('/prop/lease/{id}/arrear/{lid}/update', 'updateleasearreardetails')->name('propdec.uptleaprearrear');
    Route::get('/prop/lease/{rid}/edit/{id}/rate/dec', 'vieweditleaserate')->name('propdec.editlearat');
    Route::any('/prop/lease/{rid}/update/{id}/rates/dec', 'updateleaserate')->name('propdec.updtlearate');
    Route::any('/prop/lease/{rid}/delete/{id}/rates/dec', 'deleteleaserate')->name('propdec.dellearate');
    Route::any('/prop/lease/{rid}/delete/{id}/arrear/dec', 'deleteleasearrear')->name('propdec.delleaarrear');
    Route::any('/prop/lease/{rid}/delete/{id}/prepay/dec', 'deleteleaseprepay')->name('propdec.delleaprepay');
    Route::any('/prop/update/lease/{id}/dec', 'updatesinglelease')->name('propdec.uptlea');
    Route::any('/prop/lease/{id}/disable', 'disablesinglelease')->name('propdec.dislea');
    Route::any('/prop/update/{id}/preinvoice', 'updateinvoicebilled')->name('propdec.updtpre');
    Route::get('/prop/edit/{id}/pre-invoice/view', 'editinvoicebilled')->name('propdec.editpre');
    Route::get('/prop/invoice/list/billed/edited', 'listalleditedpreinvoice')->name('propdec.listpre');
    Route::get('/prop/view/{id}/pre-invoice/edited', 'vieweditedinvoicebilled')->name('propdec.vieweditpre');
    Route::any('/prop/update/{id}/preinvoice/approve', 'approveupdateinvoicebilled')->name('propdec.updtpreinvoice');
});
/*-------------------end property management declines------------------------ */
/*-------------------property management declines------------------------ */
Route::middleware('loginauth')->controller(PropManManageController::class)->group(function () {
    Route::get('/prop/list/landlord', 'listalllandlords')->name('propma.landlist');
    Route::get('/prop/landlord/single/type/{id}', 'getlandlordbytype');
    Route::get('/prop/tenant/single/type/{id}', 'gettenantbytype');
    Route::get('/prop/property/single/type/{id}', 'getpropertybytype');
    Route::get('/prop/tenant/single/details/{id}', 'gettenantbyid');
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
    Route::get('/prop/list/alltenant', 'listalltenants')->name('propma.tenalist');
    Route::get('/prop/tenant/{id}/view', 'viewtenantdetails')->name('propma.viewtena');
    Route::get('/prop/edit/{id}/tenant', 'viewedittenantdetails')->name('propma.edittena');
    Route::get('/prop/edit/{id}/tenant/keen/{cid}', 'viewedittenantkeen')->name('propma.edittenkeen');
    Route::any('/prop/update/{id}/tenant/keen/{cid}', 'updatetenantkeen')->name('propma.updatenakeen');
    Route::any('/prop/update/{id}/tenant', 'updatetenantdetails')->name('propma.updttena');
    Route::get('/prop/edit/{id}/tenant/contact/{cid}', 'viewedittenantcontact')->name('propma.edittencon');
    Route::any('/prop/update/{id}/tenant/contact/{cid}', 'updatetenantcontact')->name('propma.updatenacon');
    Route::get('/prop/list/alllease', 'listallleases')->name('propma.lealist');
    Route::get('/prop/lease/{id}/view', 'viewleasedetails')->name('propma.viewlea');
    Route::get('/prop/edit/{id}/lease', 'vieweditleasedetails')->name('propma.editlea');
    Route::get('/prop/{rid}/edit/{id}/rate/lease', 'vieweditleaserate')->name('propma.editlearat');
    Route::any('/prop/update/{id}/lease', 'updateleasedetails')->name('propma.updtlea');
    Route::any('/prop/{rid}/update/{id}/lease/rates', 'updateleaserate')->name('propma.updtlearate');
    Route::any('/prop/{id}/lease/reactivate', 'reactivatesinglelease')->name('propma.reactlea');
    Route::get('/prop/lease/{id}/renewal', 'viewrenewleasedetails')->name('propma.renlea');
    Route::any('/prop/update/lease/{id}/renewal', 'updatesingleleaserenew')->name('propma.uptrenlea');
    Route::get('/prop/list/property/invoice', 'listallpropertyinvoice')->name('propma.propinvo');
    Route::get('/prop/view/{id}/property/invoice', 'viewsinglepropertyinvoice')->name('propma.viewpropinvo');
    Route::get('/prop/view/{tid}/tenant/invoice/{pid}', 'viewsingletenantinvoice')->name('propma.viewteninvo');
    Route::get('/prop/view/{id}/lease/invoice', 'viewsingleleaseinvoice')->name('propma.viewleainvo');
    Route::get('/prop/view/{id}/generated/{lid}/invoice', 'viewsinglegeneratedinvoice')->name('propma.viewgeninvo');
    Route::get('/prop/download/{id}/generated/invoice-pdf/{lid}', 'pdfsinglegeneratedinvoice')->name('propma.pdfgeninvo');
});
/*-------------------end property management declines------------------------ */
/*-------------------setup intake------------------------ */
Route::middleware('loginauth')->controller(SetupIntakeController::class)->group(function () {
    Route::get('/set-up/add/currency', 'addcurrency')->name('setin.addcurr');
    Route::post('/set-up/add/new/currency', 'addnewcurrency')->name('setin.addnewcurr');
    Route::get('/set-up/add/client-type', 'addclienttype')->name('setin.addcltyp');
    Route::post('/set-up/add/new/client-type', 'addnewclienttype')->name('setin.addnewcltyp');
    Route::get('/set-up/add/property-type', 'addpropertytype')->name('setin.addpropty');
    Route::post('/set-up/add/new/property-type', 'addnewpropertytype')->name('setin.addnewpropty');
    Route::get('/set-up/add/province', 'addprovince')->name('setin.addprov');
    Route::post('/set-up/add/new/province', 'addnewprovince')->name('setin.addnewprov');
    Route::get('/set-up/add/lease/interest', 'addleaseinterest')->name('setin.addintrst');
    Route::post('/set-up/add/new/lease/interest', 'addnewleaseinterest')->name('setin.addnewintrst');
    Route::get('/set-up/add/vat/config', 'addvatconfig')->name('setin.addvat');
    Route::post('/set-up/add/new/vat/config', 'addnewvatconfig')->name('setin.addnewvat');
    Route::get('/set-up/add/currency/exchangerate', 'addcurrencyrate')->name('setin.ratecurr');
    Route::post('/set-up/add/new/dcurrency/exchangerate', 'addexchangerate')->name('setin.newratecurr');
    Route::get('/set-up/add/leave/group', 'addleavegroup')->name('setin.addlevgrp');
    Route::any('/set-up/create/new/leave/group', 'createnewleavegroup')->name('setin.createlevgrp');
    Route::get('/set-up/add/leave/holiday', 'addleaveholiday')->name('setin.addlevhol');
    Route::any('/set-up/create/new/holiday', 'createleaveholiday')->name('setin.createholid');
});
/*-------------------end setup intake------------------------ */
/*-------------------setup manage------------------------ */
Route::middleware('loginauth')->controller(SetupManageController::class)->group(function () {
    Route::get('/set-up/base/currency', 'setbasecurrency')->name('setman.addbasecurr');
    Route::post('/set-up/set/base/currency', 'addnewbasecurrency')->name('setman.addbewcode');
    Route::get('/set-up/leave/group', 'listleavegroups')->name('setman.listlevgrp');
    Route::any('/disable/{id}/leave/group', 'disableleavegroup')->name('setman.disablelevgrp');
    Route::any('/activate/{id}/leave/group', 'activateleavegroup')->name('setman.activlevgrp');
    Route::get('/leave-group/{id}/assign/type', 'viewassignleavegrouptype')->name('setman.viewassignlevtyp');
    Route::any('/assign-type/{id}/leave/group', 'assigntypeleavegroup')->name('setman.assigntyplevgrp');
    Route::get('/set-up/leave/group/{id}', 'listtypeperleavegroups')->name('setman.typperlevgrp');
    Route::get('/set-up/type/{tid}/leave-group/{gid}', 'viewleavetypegroupconfig')->name('setman.typlevgrpconf');
    Route::any('/work-days/{id}/leave/group', 'assignworkdayleavegroup')->name('setman.assigndaygrp');
    Route::post('/config-days/{id}/leave/group-type/{gid}', 'createaccruedayleavegroup')->name('setman.crtaccrue');
    Route::get('/set-up/leave/type', 'listleavetype')->name('setman.listlevtype');
    Route::get('/set-up/leave/tyoe/{id}', 'viewsingleleavetype')->name('setman.viewtype');
    Route::any('/work-days/{id}/leave/type', 'assignconfigleavetype')->name('setman.assignconfigtype');
});
/*-------------------end setup manage------------------------ */
/*-------------------valuations intake------------------------ */
Route::middleware('loginauth')->controller(ValIntakeController::class)->group(function () {
    Route::get('/val/new/client', 'addnewclientdetails')->name('valin.client');
    Route::any('/val/add/new/client', 'createnewclientdetails')->name('valin.createclient');
    Route::get('/val/new/property', 'addnewpropertydetails')->name('valin.newprop');
    Route::any('/val/add/new/property', 'createnewpropertydetails')->name('valin.createprop');
    Route::get('/val/client/{id}/bytype', 'getsingleclientbytype');
    Route::get('/val/create/new/portfolio', 'createportfolio')->name('valin.newportfoli');
    Route::post('/val/add/new/portfolio', 'createnewportfolio')->name('valin.createport');
    Route::get('/val/client/{id}/contact', 'getsingleclientcontact');
    Route::get('/val/new/portfolio-instruction', 'addnewinstructionportfolio')->name('valin.addinstport');
    Route::any('/val/submit/page/port-instr', 'addportfoliosubmitpage')->name('valin.portpage1');
    Route::get('/val/{id}/port/{vid}/page', 'addinstructionportsteptwo')->name('valin.portpage2');
    Route::any('/val/allocate/new/port-instr', 'allocateinstructionport')->name('valin.alloport');
    Route::get('/val/new/normal-instruction', 'addnewinstructionnormal')->name('valin.addinstnorm');
    Route::post('/val/submit/page/normal-instr', 'addnormalsubmitpage')->name('valin.normpage1');
    Route::get('/val/{id}/nom/{vid}/inst/{cid}/pur/{pid}/typ/{tid}/pay/{payid}/{accessdate}', 'addinstructionnormalsteptwo')->name('valin.normpage2');
    Route::any('/val/allocate/new/normal-instr', 'allocateinstructionnorm')->name('valin.allonom');
    Route::get('/val/new/client/{id}/contact', 'addnewclientcontact')->name('valin.newclient');
    Route::post('/val/create/contact/{id}/client', 'createnewclientcontact')->name('valin.crtclicont');
});
/*-------------------end valuations intake------------------------ */
/*-------------------valuations approval------------------------ */
Route::middleware('loginauth')->controller(ValApprovalController::class)->group(function () {
    Route::get('/val/list/acknowledgement/pending', 'listallinstructionacknowledge')->name('valapp.listacknw');
    Route::get('/val/{id}/view-single/{instr_id}/acknowledgement', 'viewsingleinstructionacknowledge')->name('valapp.viewsinglackwn');
    Route::any('/val/{id}/acknowledge/{instr_id}/accept/{to_id}', 'confirmacknowledgement')->name('valapp.confirmacknow');
    Route::get('/val/list/compilation', 'listallinstructioncompile')->name('valapp.listcomp');
    Route::any('/val/{id}/decline/{instr_id}/acknowledge', 'declineacknowledgement')->name('valapp.declineacknow');
    Route::get('/val/{id}/view-single/{instr_id}/compilation', 'viewsingleinstructioncompile')->name('valapp.viewsinglcomp');
    Route::any('/val/{id}/compile/{instr_id}/{propid}/submit', 'submitcompilation')->name('valapp.sbtcompl');
    Route::get('/val/list/quality-check/pending', 'listallinstructionqualitycheck')->name('valapp.listquality');
    Route::get('/val/{id}/view/instruction/{instr_id}/quality/check', 'viewsinglequalitycheck')->name('valapp.viewsingleqlty');
    /*-----------download reports-------------------- */
    Route::any('/val-report/{instr_id}/download/doc', 'downloadreportword')->name('valapp.downdoc');
    Route::any('/val-report/{instr_id}/excel/download', 'downloadreportexcel')->name('valapp.downexc');
    /*-----------end download reports-------------------- */
    Route::any('/val/{id}/quality/{instr_id}', 'submitqualitycheck')->name('valapp.sbtquality');
    Route::get('/val/list/report-approval', 'listallinstructionfinalapproval')->name('valapp.listreportapp');
    Route::get('/val/{id}/view-single/{instr_id}/instruction/approval', 'viewsingleinstructionapproval')->name('valapp.viewinstrapp');
    Route::any('/val/{id}/instruction/{instr_id}/approval', 'submitreportapproval')->name('valapp.reportapproval');
    Route::get('/val/list/printing/pending', 'listallinstructionprinting')->name('valapp.listallprint');
    Route::get('/val/{id}/view-instruction/{instr_id}/printing', 'viewsingleintructionprint')->name('valapp.viewsinglprint');
    Route::any('/val/{id}/report/{instr_id}/printing', 'submitprinting')->name('valapp.printreport');
    Route::get('/val/list/invoicing/pending', 'listallinstructioninvoicing')->name('valapp.listinvoices');
    Route::get('/val-invoice/{id}/view-port', 'viewsingleinvoicingportfolio')->name('valapp.viewsingleinvoport');
    Route::any('/val/{id}/submit-portfolio/invoice', 'submitinvoicingportfolio')->name('valapp.sbtinvoiceport');
    Route::get('/val/{id}/view-single/{instr_id}/invoice', 'viewsinglenormalinvoicing')->name('valapp.viewsingleinvo');
    Route::any('/val/{id}/submit-normal/invoicing', 'submitinvoicingnormal')->name('valapp.sbtinvoic');
    Route::get('/val/list/dispatch/pending', 'listallinstructionpendingdispatch')->name('valapp.listdispat');
    Route::get('/val/{id}/view-single/{instr_id}/dispatch/pending', 'viewsingleinstructiondispatch')->name('valapp.viewsingldispatch');
    Route::any('/val/{id}/report/dispatched', 'submitdispatch')->name('valapp.sbtdispat');
    Route::get('/val/list/email-report', 'listallinstructionsendingsoftcopy')->name('valapp.listalltomail');
    Route::get('/val/{id}/view-single/{instr_id}/to-mail', 'viewsingletomail')->name('valapp.viewsinglsofy');
    Route::any('/val/{id}/report/send/softcopy', 'submittomail')->name('valapp.sbttomail');
    Route::get('/val/list/portfolio/compilation', 'listallportfoliocompile')->name('valapp.listportcompile');
    Route::get('/val/portfolio/{id}/compilation', 'listallinstructionportfoliocompile')->name('valapp.viewsinglportfoli');
    Route::any('/val/portfolio/compilation', 'submitportfoliocompiledreports')->name('valapp.sbtcompilrep');
    Route::any('/val/close/portfolio/{id}', 'closeportfolio')->name('valapp.closeport');
    Route::get('/val/list/portfolio/review/pending', 'listallportfolioforreview')->name('valapp.listportreviews');
    Route::get('/val/portfolio/{id}/review', 'listallinstructionportfolioreview')->name('valapp.viewsinglportreview');
    Route::any('/val/portfolio/review', 'submitportfolioreviewedreports')->name('valapp.sbtreviewportfolio');
    Route::any('/val/portfolio/{id}/close/review', 'closeportfolioreview')->name('valapp.portclosereview');
});
/*-------------------valuations decline------------------------ */
Route::middleware('loginauth')->controller(ValDeclinedController::class)->group(function () {
    Route::get('/val/list/acknowledgement/declined', 'listalldeclinedacknowledgement')->name('valdec.listackn');
    Route::get('/val/{id}/view-declined/{instr_id}/acknowledgement', 'viewsingleinstructionacknowledge')->name('valdec.viewsinglackwn');
    Route::any('/val/allocate/{id}/declined/instruction/{instr_id}', 'allocateinstructionacknowledge')->name('valdec.alloinstr');
});
/*-------------------valuations manage------------------------ */
Route::controller(ValManageController::class)->group(function () {
    Route::get('/val/list/client', 'listallclient')->name('valman.listclient');
    Route::get('/val/{id}/client/edit', 'editsingleclient')->name('valman.editclient');
    Route::get('/val/{id}/client/view', 'viewsingleclient')->name('valman.viewclient');
    Route::get('/val/{id}/client/add/contact/{cid}', 'editsingleclientcontact')->name('valman.editaddclient');
    Route::any('/val/update/{id}/client', 'updateclientdetails')->name('valman.updtclient');
    Route::any('/val/contact/{id}/client/update/{cid}', 'updatesingleclientcontact')->name('valman.editclientdet');
    Route::get('/val/list/instructions', 'listallinstructions')->name('valman.listinstr');
    Route::get('/val/instruction/{id}/stage', 'viewsingleinstructionstage')->name('valman.viewinstrstage');
});
/*-------------------human capital intake------------------------ */
Route::middleware('loginauth')->controller(HCIntakeController::class)->group(function () {
    Route::get('/hc/import/staff', 'importstafflist')->name('hcin.impstaf');
    Route::post('/hc/create/staff', 'createstafflist')->name('hcin.crtstaf');
    Route::get('/hc/leavetype/required/{id}', 'returnleaverequired');
    Route::get('/hc/apply/leave', 'applyleave')->name('hcin.applev');
    Route::get('/hc/add/days', 'addleavedays')->name('hcin.addday');
    Route::get('/hc/add/days/{id}/user', 'listgroupsperuser')->name('hcin.lstgrpusr');
    Route::get('/hc/add/type/{id}/user/{uid}/days', 'addtypedaytouser')->name('hcin.daytotyp');
    Route::post('/hc/staff/{id}/takeon/{tid}', 'staffaddtakeonbalances')->name('hcin.takeon');
    Route::get('/hc/staff/{uid}/typeid/{tid}', 'getdaysavailable');
    Route::post('/hc/apply/{uid}/leave/create/{rid}', 'createleave')->name('hcin.cretlev');
    Route::get('/hc/leavegroup/working-days/{gid}', 'getgroupworkingdays');
});
/*-------------------human capital manage------------------------ */
Route::middleware('loginauth')->controller(HCManageController::class)->group(function () {
    Route::get('/hc/list/staff', 'listallstaff')->name('hcman.liststff');
    Route::get('/hc/view/staff/{uid}/{gid}', 'viewsinglestaff')->name('hcman.viwstff');
});
/*-------------------human capital intake------------------------ */
Route::middleware('loginauth')->controller(HCApprovalController::class)->group(function () {
    Route::get('/hc/leave/approval', 'listpendingapproval')->name('hcapp.listlev');
    Route::get('/hc/leave/application/{id}/approval', 'viewsingleapplication')->name('hcapp.viwsingapp');
    Route::post('/hc/leave/application/{id}/first-approve', 'apprpveingleapplication')->name('hcapp.apprvleve');
    Route::get('/hc/leave/application/confirmation', 'listpendingconfirmation')->name('hcapp.listlevcon');
    Route::get('/hc/leave/application/{id}/confirm', 'viewsingleapplicationconfirm')->name('hcapp.viwsingappcon');
    Route::any('/hc/leave/application/{id}/second-approve', 'confirmsingleapplication')->name('hcapp.confleve');
    Route::any('/hc-pdf/{path}/leave-download/attachment', 'downloadattachments')->name('hcapp.dwnattchpdf');
});
