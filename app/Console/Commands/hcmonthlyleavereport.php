<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class hcmonthlyleavereport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hcmonthlyleavereport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $arr['dateat'] = Carbon::now()->format('F j, Y');
            $datefrom = Carbon::today()->subDays(35)->toDateString();

            $applications   = DB::table('hcleaveapplication as a')->join('hcleavetype as t', 'a.typeid', '=', 't.id')
                ->leftJoin('systusers as u', 'a.staffid', '=', 'u.id')->where('a.status', '=', 'A')
                ->where('a.datefrom', '>=', $datefrom)->select(
                    'a.*',
                    't.description as leavetype',
                    'u.firstname',
                    'u.lastname'
                )->get();
            $arr['leavetype'] = $applications->groupBy('leavetype');
            $arr['applications'] = $applications;
            // Send email
            Mail::send('tomail.hc-leave-application-report', $arr, function ($message) {
                // $message->to('ngaatendweb@intpro.co.zw')->cc('coo@intpro.co.zw')
                //     ->bcc('marcos@intpro.co.zw')
                $message->to('systemreports@arsoc.co.zw')
                    ->subject('Monthly Leave Report');
            });

            $this->info('Weekly report email sent successfully!');
        } catch (\Exception $e) {
            $mymessage = 'Error: ' . $e->getMessage();
            $mymailto = 'systemreports@arsoc.co.zw';
            Mail::html("<p>$mymessage</p>", function ($message) use ($mymailto) {
                $message->to($mymailto)
                    ->subject('Leave Report Error');
            });
        }
    }
}
