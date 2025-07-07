<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class valweeklynormalreport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:valweeklynormalreport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Valuations Weekly Normal Instructions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = DB::select("SELECT DATEADD(WEEK, DATEDIFF(WEEK, 0, GETDATE()) -1, 0) AS StartOfWeek");
        $arr['mondayfirstday']  = $start[0]->StartOfWeek;
        $end = DB::select("SELECT DATEADD(DAY, 6, ?) AS EndOfWeek", [$arr['mondayfirstday']]);
        $arr['sundaylastday']  = $end[0]->EndOfWeek;
        $arr['portfolioids']   = DB::table('valinstructions')->where('isportfolio', '=', 'Y')
            ->pluck('id')->toArray();
        $arr['normalindividual'] = DB::select('EXEC spGetValWeekNormalReportIndividual');
        /*invoicing */
        $arr['invoicependingcw']   = DB::table('valinstrinvoicing')
            ->where([['status', '=', 'P'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['invoicependingweekplus']   = DB::table('valinstrinvoicing')
            ->where([['status', '=', 'P'], ['datestamp', '<', $arr['mondayfirstday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['invoicecompletedcw']   = DB::table('valinstrinvoicing')
            ->where([['status', '=', 'C'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        /*approval */
        $arr['approvependingweekplus']   = DB::table('valinstrfinalapproval')
            ->where([['status', '=', 'P'], ['datestamp', '<', $arr['mondayfirstday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['approvependingcw']   = DB::table('valinstrfinalapproval')
            ->where([['status', '=', 'P'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['approvecompletedcw']   = DB::table('valinstrfinalapproval')
            ->where([['status', '=', 'C'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        /*print */
        $arr['printpendingweekplus']   = DB::table('valinstrprinting')
            ->where([['status', '=', 'P'], ['datestamp', '<', $arr['mondayfirstday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['printpendingcw']   = DB::table('valinstrprinting')
            ->where([['status', '=', 'P'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['printcompletedcw']   = DB::table('valinstrprinting')
            ->where([['status', '=', 'C'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        /*Quality check */
        $arr['qualitypendingweekplus']   = DB::table('valinstrqualitycheck')
            ->where([['status', '=', 'P'], ['datestamp', '<', $arr['mondayfirstday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['qualitypendingcw']   = DB::table('valinstrqualitycheck')
            ->where([['status', '=', 'P'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['qualitycompletedcw']   = DB::table('valinstrqualitycheck')
            ->where([['status', '=', 'C'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        /*To mail */
        $arr['mailpendingweekplus']   = DB::table('valinstrsendingreport')
            ->where([['status', '=', 'P'], ['datestamp', '<', $arr['mondayfirstday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['mailpendingcw']   = DB::table('valinstrsendingreport')
            ->where([['status', '=', 'P'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        $arr['mailcompletedcw']   = DB::table('valinstrsendingreport')
            ->where([['status', '=', 'C'], ['datestamp', '>=', $arr['mondayfirstday']], ['datestamp', '<=', $arr['sundaylastday']]])
            ->whereNotIn('instructionid', $arr['portfolioids'])->count();
        try {
            // Send email
            Mail::send('tomail.val-weekly-normal-report', $arr, function ($message) {
                $message->to('systemreports@arsoc.co.zw') // Replace with the recipient's email
                    ->subject('Weekly Status Report (Normal)');
            });

            $this->info('Weekly report email sent successfully!');
        } catch (\Exception $e) {
            $errormessage = 'Error: ' . $e->getMessage();
            Mail::send([], [], function ($message) use ($errormessage) {
                $message->to('systemreports@arsoc.co.zw')
                    ->subject('Weekly Status Report (Normal)')
                    ->setBody($errormessage, 'text/plain');
            });
        }
    }
}
