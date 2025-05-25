<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    /*--------------------------main dashboard---------------------*/
    public function maindashboard()
    {
        try {
            $arr['user'] = DB::table('systusers')->select('*')->where('username', session('alluser'))
                ->first();
            return view('dash/main-dash')->with($arr);
        } catch (\Throwable $th) {
            $error = 'failed to display dashboard';
            return $this->userforcelogout($error);
        }
    }
    /*---------------property management dashboard------------------------*/
    public function propertyview()
    {
        $basecurrency = $this->getbasecurrency();
        $currentyear    = Carbon::now()->year;
        $jan            = Carbon::createFromDate($currentyear, 1, 1)->endOfMonth()->format('Y-m-d');
        $feb            = Carbon::createFromDate($currentyear, 2, 1)->endOfMonth()->format('Y-m-d');
        $mar            = Carbon::createFromDate($currentyear, 3, 1)->endOfMonth()->format('Y-m-d');
        $apr            = Carbon::createFromDate($currentyear, 4, 1)->endOfMonth()->format('Y-m-d');
        $may            = Carbon::createFromDate($currentyear, 5, 1)->endOfMonth()->format('Y-m-d');
        $jun            = Carbon::createFromDate($currentyear, 6, 1)->endOfMonth()->format('Y-m-d');
        $jul            = Carbon::createFromDate($currentyear, 7, 1)->endOfMonth()->format('Y-m-d');
        $aug            = Carbon::createFromDate($currentyear, 8, 1)->endOfMonth()->format('Y-m-d');
        $sep            = Carbon::createFromDate($currentyear, 9, 1)->endOfMonth()->format('Y-m-d');
        $oct            = Carbon::createFromDate($currentyear, 10, 1)->endOfMonth()->format('Y-m-d');
        $nov            = Carbon::createFromDate($currentyear, 11, 1)->endOfMonth()->format('Y-m-d');
        $dec            = Carbon::createFromDate($currentyear, 12, 1)->endOfMonth()->format('Y-m-d');
        // check if basecurrency is set
        switch (true) {
            case ($basecurrency == 'failed'):
                $error = 'no base currency set';
                return  redirect()->route('dash.main')
                    ->with('error', $error);
            default:
                $arr['sysdates'] = $this->systemdate();
                $arr['base']   = DB::table('setupcurrencybase')->where('active', '=', 'Y')
                    ->select('code')->latest('id')->first();
                $arr['activelandlord']   = DB::table('propmanlandlord')->where('available', '=', 'Y')->get()->count();
                $arr['activeproperty']   = DB::table('propmanallproperty')->where('available', '=', 'Y')->get()->count();
                $arr['activetenant']   = DB::table('propmanalltenant')->where('available', '=', 'Y')->get()->count();
                $arr['activelease']   = DB::table('propmanalllease')->where('available', '=', 'Y')->get()->count();
                $leasedue = Carbon::parse($arr['sysdates'])->addDays(35);
                $arr['lease']   = DB::table('propmanalllease')->where('available', '=', 'Y')
                    ->where('validto', '>', $arr['sysdates'])->where(
                        'validto',
                        '<',
                        $leasedue
                    )->select('*')->take(5)->get();
                $arr['invoice']   = DB::table('propmaninvoicepre')->get()->count();
                /*-----------calculation of amount billed ------------------------- */
                $billjan  =   DB::table('propmaninvoicegenerated')->where('period', $jan)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billfeb  =   DB::table('propmaninvoicegenerated')->where('period', $feb)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billmar  =   DB::table('propmaninvoicegenerated')->where('period', $mar)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billapr  =   DB::table('propmaninvoicegenerated')->where('period', $apr)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billmay  =   DB::table('propmaninvoicegenerated')->where('period', $may)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billjun  =   DB::table('propmaninvoicegenerated')->where('period', $jun)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billjul  =   DB::table('propmaninvoicegenerated')->where('period', $jul)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billaug  =   DB::table('propmaninvoicegenerated')->where('period', $aug)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billsep  =   DB::table('propmaninvoicegenerated')->where('period', $sep)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billoct  =   DB::table('propmaninvoicegenerated')->where('period', $oct)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billnov  =   DB::table('propmaninvoicegenerated')->where('period', $nov)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                $billdec  =   DB::table('propmaninvoicegenerated')->where('period', $dec)->where('currencycode', $arr['base']->code)->sum('totalbilled');
                /*----------------------receipts----------------------- */
                $recjan  =   DB::table('propmanleasereceipts')->where('period', $jan)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recfeb  =   DB::table('propmanleasereceipts')->where('period', $feb)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recmar  =   DB::table('propmanleasereceipts')->where('period', $mar)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recapr  =   DB::table('propmanleasereceipts')->where('period', $apr)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recmay  =   DB::table('propmanleasereceipts')->where('period', $may)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recjun  =   DB::table('propmanleasereceipts')->where('period', $jun)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recjul  =   DB::table('propmanleasereceipts')->where('period', $jul)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recaug  =   DB::table('propmanleasereceipts')->where('period', $aug)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recsep  =   DB::table('propmanleasereceipts')->where('period', $sep)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recoct  =   DB::table('propmanleasereceipts')->where('period', $oct)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recnov  =   DB::table('propmanleasereceipts')->where('period', $nov)->where('currencycode', $arr['base']->code)->sum('amountpaid');
                $recdec  =   DB::table('propmanleasereceipts')->where('period', $dec)->where('currencycode', $arr['base']->code)->sum('amountpaid');

                $arr['dates'] = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $arr['rentalcollected'] = [$recjan, $recfeb, $recmar, $recapr, $recmay, $recjun, $recjul, $recaug, $recsep, $recoct, $recnov, $recdec];
                $arr['rentalbilled'] = [$billjan, $billfeb, $billmar, $billapr, $billmay, $billjun, $billjul, $billaug, $billsep, $billoct, $billnov, $billdec];

                return view('dash/property-view')->with($arr);
        }
    }
    function valuationview()
    {
        return view('dash.valuation-view');
    }
    public function valuationdashboard()
    {
        $currentdate    = Carbon::now();
        $previousdate   = $currentdate->subDays(10);
        $arr['invoice']   = DB::table('valinstrinvoicing')->where('status', '=', 'P')->get()->count();
        $arr['approve']   = DB::table('valinstrfinalapproval')->where('status', '=', 'P')->get()->count();
        $arr['print']   = DB::table('valinstrprinting')->where('status', '=', 'P')->get()->count();
        $arr['quality']   = DB::table('valinstrqualitycheck')->where('status', '=', 'P')->get()->count();
        $arr['pending']   = DB::table('valinstructions')->where('status', '=', 'pending')->get()->count();
        $arr['mail']        = DB::table('valinstrsendingreport')->where('status', '=', 'pending')->get()->count();
        $arr['portfolio']   = DB::select('EXEC spValGetPortfolioCompilation');
        $arr['portfolioreview']   = DB::select('EXEC spValGetPortfolioReview');
        $arr['instructions'] = DB::table('valinstrfinalapproval')
            ->join('valinstructions', 'valinstrfinalapproval.instructionid', '=', 'valinstructions.id')
            ->join('valclientproperty', 'valclientproperty.id', '=', 'valinstructions.propertyid')
            ->where('valinstrfinalapproval.status', 'C')
            ->where('valinstrfinalapproval.completedon', '>=', $previousdate)
            ->select(
                'valinstrfinalapproval.completedby',
                'valinstrfinalapproval.completedon',
                'valclientproperty.streetaddress'
            )
            ->orderBy('valinstrfinalapproval.id', 'desc')
            ->take(10)
            ->get();
        //return $arr['instructions'] ;
        return view('dash/val-dash')->with($arr);
    }
    public function setupdashboard()
    {
        return view('dash.setup-dash');
    }
}
