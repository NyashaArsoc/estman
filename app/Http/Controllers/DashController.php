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
    public function propertyviewchart()
    {
        $base = $this->getbasecurrency();
        if ($base === 'failed') {
            return redirect()->route('dash.main')->with('error', 'no base currency set');
        }
        $currencycode = $base;
        $currentYear = now()->year;
        $dates = [];
        $periods = [];
        for ($month = 1; $month <= 12; $month++) {
            $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');
            $periods[] = $endOfMonth;
            $dates[] = Carbon::create($currentYear, $month)->format('M-Y');
        }
        // Fetch all billing for year in one query
        $bills = DB::table('propmaninvoicegenerated')
            ->whereIn('period', $periods)
            ->where('currencycode', $currencycode)
            ->selectRaw('period, SUM(totalbilled) as total')
            ->groupBy('period')
            ->pluck('total', 'period');

        $receipts = DB::table('propmanleasereceipts')
            ->whereIn('period', $periods)
            ->where('currencycode', $currencycode)
            ->selectRaw('period, SUM(amountpaid) as total')
            ->groupBy('period')
            ->pluck('total', 'period');
        $rentalbilled = [];
        $rentalcollected = [];
        foreach ($periods as $p) {
            $rentalbilled[] = $bills[$p] ?? 0;
            $rentalcollected[] = $receipts[$p] ?? 0;
        }

        return response()->json([
            'dates' => $dates,
            'invoices' => $rentalbilled,
            'receipts' => $rentalcollected,
        ]);
    }
    public function propertyview()
    {
        $currentperioddate      =       Carbon::now()->endOfMonth()->format('Y-m-d');
        $sysdate = $this->systemdate();
        $leasedue = Carbon::parse($sysdate)->addDays(35);

        //$base = DB::table('setupcurrencybase')->where('active', 'Y')->select('code')->latest('id')->first();
        $base = $this->getbasecurrency();
        if ($base === 'failed') {
            return redirect()->route('dash.main')->with('error', 'no base currency set');
        }
        $arr = [
            'sysdates' => $sysdate,
            'base' => $base,
            'activelandlord' => DB::table('propmanlandlord')->where('available', 'Y')->count(),
            'activeproperty' => DB::table('propmanallproperty')->where('available', 'Y')->count(),
            'activetenant' => DB::table('propmanalltenant')->where('available', 'Y')->count(),
            'activelease' => DB::table('propmanalllease')->where('available', 'Y')->count(),
            'invoice' => DB::table('propmaninvoicepre')->count(),
            'lease' => DB::table('propmanalllease')
                ->where('available', 'Y')
                ->whereBetween('validto', [$sysdate, $leasedue])
                ->select('*')->limit(5)->get(),

        ];
        $arr['ytdpaid'] = DB::table('propmanleasereceipts')->where('currencycode', $base)->whereYear('datestamp', now()->year)->whereDate('datestamp', '<=', now())
            ->sum('amountpaid');
        $arr['ytdowing'] = DB::table('propmanleasearrearsdetails')->where('currencycode', $base)->whereYear('datestamp', now()->year)->whereDate('datestamp', '<=', now())
            ->sum('balrent');
        $arr['currentpaid'] = DB::table('propmanleasereceipts')->where('currencycode', $base)->where('period', $currentperioddate)->sum('amountpaid');
        $arr['currentowing'] = DB::table('propmanleasearrearsdetails')->where('currencycode', $base)->where('baldays', '<', 35)->sum('balrent');

        return view('dash/property-view')->with($arr);
    }

    function humancapitaldashboard()
    {
        $arr['myuser'] = $this->userdetail();
        $arr['totalapplication']   = DB::table('hcleaveapplication')->where('staffid', $arr['myuser']->id)->get()->count();
        $arr['approvedapplication']   = DB::table('hcleaveapplication')->where('staffid', $arr['myuser']->id)->where('status', '=', 'A')->get()->count();
        $arr['rejectedapplication']   = DB::table('hcleaveapplication')->where('staffid', $arr['myuser']->id)->where('status', '=', 'R')->get()->count();
        $arr['application']   = DB::table('hcleaveapplication')->join('hcleavetype', 'hcleaveapplication.typeid', '=', 'hcleavetype.id')
            ->select(
                'hcleavetype.description',
                'hcleaveapplication.status',
                'hcleaveapplication.daysapplied'
            )
            ->where('hcleaveapplication.staffid', $arr['myuser']->id)
            ->orderBy('hcleaveapplication.id', 'desc')->take(3)->get();
        return view('dash.hc-dashboard')->with($arr);
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
        $arr['portfolio']   = DB::select('EXEC spGetValPortfolioCompilation');
        $arr['portfolioreview']   = DB::select('EXEC spGetValPortfolioReview');
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
